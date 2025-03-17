<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\passwordreset;
use App\Mail\SendAuthMail;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public ImageService $imageService;
    public function __construct()
    {
        $this->imageService = new ImageService();
    }
    public function index()
    {
        $users = User::paginate(10);
        return response()->json($users);
    }

    public function dashboard()
    {
        $user = User::with('roles')->get();

        return response()->json($user);
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            if(Auth::user()->email_verified_at == NULL){
                $user = Auth::user();
                $this->sendmail($user);
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Email is not verified'
                ],401);
            }
            return response()->json([
                'status' => true,
                'message' => 'Login success',
                'user' => Auth::user(),
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ],401);
        }
    }
    public function adduser()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        $imageName = $this->imageService->saveImage($request->file('image'), 'images');
        $data['image'] = $imageName;
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        if(!$request->check_login=='add_by_admin'){
            $user->assignRole('user');
            $user->givePermissionTo(['create-post','delete-post','update-post','view-post']);
            $this->sendmail($user);
            auth()->login($user);
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'user' => auth()->user,
            ],200);
        }
        else{
            $user->assignRole('user');
            $user->givePermissionTo($request->permission);
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ],200);
        }
    }


    public function show($id)
    {
        $user = User::findorfail($id);
        $permissions = Permission::all();
        return response()->json([
            'user' => $user,
            'permissions' => $permissions
        ]);
    }

    public function delete($id)
    {
        $user = User::findorfail($id);
        $this->deleteImage($user);
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',

        ],200);
    }

    public function search(Request $request){
        $users = User::where('name', 'LIKE', '%'.$request->search."%")->
        orwhere('email', 'LIKE', '%'.$request->search."%")->
        orwhere('id',$request->search)->get();
        return response()->json($users);

    }

    public function deleteImage($user)
    {
        $path = storage_path('app/public/images/' . $user->image);
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ],200);
    }

    public function count()
    {
        $totalUsers = User::all()->count();
        $posts = Post::query();
        if (auth()->user()->roles->first()->name == 'user') {
            $posts = $posts->where('user_id', auth()->id());
        }
        $totalPosts = $posts->count();
        $totalTags = Tag::all()->count();

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'totalTags' => $totalTags
        ],200);
    }

    public function update($id, UpdateUserRequest $request)
    {
        $user = User::findorfail($id);
        $data = $request->validated();
        $imageName = $user->image;
        if ($request->hasFile('image')) {
            if (!empty($imageName)) {
                $this->deleteImage($user);
            }
            $imageName = time() . '.' . $request->image->extension();
            $image = $request->file('image');
            $image->storeAs('images', $imageName, ['disk' => 'public']);
        }
        $data['image']=$imageName;
        $user->update($data);
        $user->permissions()->sync($request->permissions) ;
        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'user' => $user,
        ],200);

    }
    public function profile()
    {
        $user = Auth::user();
        return response()->json($user);
    }
    public function sendMail($user){
        Mail::to($user->email)->queue(new SendAuthMail($user));
    }
    public function verifyUser($id)
    {
        try {
            $userId= Crypt::decryptString($id);
            $user = User::findorfail($userId);
            $user->update(['email_verified_at'=>now()]);


        }catch (\Exception $exception){
            dd($exception);
        }
        return response()->json($user);
    }


    public function sendResetLinkEmail(Request $request){

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if($user){
            Mail::to($user->email)->queue(new passwordreset($user));
            return response()->json([
                'status' => true,
                'message' => 'Check your email'
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Email does not exist',
            ],401);
        }

    }
    public function verifyResetLink($id,$time){
        $userId= Crypt::decryptString($id);
        $time=Crypt::decryptString($time);
        if(now()->timestamp <= $time){
            return response()->json([
                'status' => true,
                'userid'=>$userId,
            ],200);

        }
        else{
            return response()->json([
                'status' => false,
                'message'=>'Reset link has expired'
            ],401);
        }

    }
    public function updatePassword(Request $request ,$id){
        $user = User::findorfail($id);
        $data = $request->validate([
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'password'=>Hash::make($request->password),
        ]);
        auth()->login($user);
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ],200);
    }
}
