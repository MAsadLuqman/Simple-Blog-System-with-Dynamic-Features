<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use League\Config\Exception\ValidationException;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use PragmaRX\Google2FAQRCode\Google2FA;
use Spatie\Permission\Models\Permission;
use PDF;
use Svg\Tag\Image;

class UserController extends Controller
{
    public ImageService $imageService;
    public function __construct()
    {
        $this->imageService = new ImageService();
    }
    public function index()
    {
        $users = User::paginate();
        return view('users.index', compact('users'));
    }

    public function dashboard()
    {
        $user = User::with('roles')->get();
        return view('dashboard', compact('user'));
    }

    public function login_match(LoginUserRequest $request)
    {

        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if(Auth::user()->email_verified_at == NULL){
                $this->sendmail($user);
                Auth::logout();
                return redirect()->route('login')->with('error', 'Email are not Verified');
            }
            if(!is_null(auth()->user()->google2fa_secret)){
                return view('2fa');
            }
            return redirect()->route('dashboard');
        }
        else {
            return redirect()->route('login')->with('error', 'Invalid Credentials');
        }
    }

    public function register()
    {
        return view('register');
    }
    public function add()
    {
        $permissions = Permission::all();
      return view('users.add', compact('permissions'));
    }
    public function register_save(StoreUserRequest $request)
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
            return redirect()->route('dashboard');
        }
        else{
            $user->assignRole('user');
            $user->givePermissionTo($request->permission);
            return redirect()->route('users.index')->with('success', 'User created successfully');
        }
    }


    public function show($id)
    {
        $user = User::findorfail($id);
        return view('users.view_user', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);
        $this->deleteImage($user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted Successfully');
    }

    public function search(Request $request){
        $users = User::where('name', 'LIKE', '%'.$request->search."%")->
        orwhere('email', 'LIKE', '%'.$request->search."%")->
            orwhere('id',$request->search)->get();
        return view('users.search', compact('users'));

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
        return redirect()->route('login')->with('success', 'Logged out Successfully');
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

        return view('dashboard', compact('totalUsers', 'totalPosts', 'totalTags'));
    }

    public function edit($id)
    {
        $permissions= Permission::all();
        $user = User::findorfail($id);
        return view('users.edit', compact(['user', 'permissions']));
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
        return redirect()->route('users.show', $user->id)->with('success', 'User Updated Successfully');

    }
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
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
            auth()->login($user);
            return redirect()->route('Welcome_users');

        }catch (\Exception $exception){
            dd($exception);
        }
    }

    public function passwordReset(){
        return view('forgotpassword');
    }
    public function sendResetLinkEmail(Request $request){

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if($user){
            Mail::to($user->email)->queue(new passwordreset($user));
            return redirect()->route('password.reset')->with('success', 'Reset Link Sent Successfully');
        }
        else{
            return redirect()->route('password.reset')->with('error', 'Email Not Found');
        }

    }
    public function verifyResetLink($id,$time){
        $userId= Crypt::decryptString($id);
        $time=Crypt::decryptString($time);
       if(now()->timestamp <= $time){
           return view('updatepassword', compact('userId'));

       }
       else{
           return redirect()->route('password.reset')->with('error', 'Reset Link Expired');
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
        return redirect()->route('dashboard');
    }
    public function pdfgenerate()
    {
        $users = User::all();

        $data = [
            'date' => now(),
            'users' => $users,
        ];
        $pdf = PDF::loadView('users.pdf', $data);

        return $pdf->download('users.pdf');
    }

    public function login_2fa(){
        return view('2fa');
    }

    public function enable2Fa(Request $request ,$id){

        $user = User::findorfail($id);
        if($user){
            $user = auth()->user();
            $google2fa = new Google2FA();
            $secretKey = $google2fa->generateSecretKey();
            $qrCode = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $secretKey
            );
            // Remove XML tag
            $svgContent = preg_replace('/<\?xml.*?\?>\s*/', '', $qrCode);
            $filePath = 'images/qr';
            if (!file_exists(storage_path($filePath))) {
                mkdir($filePath, 0777, true);
            }
           Storage::disk('public')->put($filePath.'/qr.svg', $svgContent);
            return view('users.two-way-auth', compact('secretKey', 'qrCode','user'));
        }

    }
    public function verify2Fa(Request $request, $id){
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);
        $user = User::findorfail($id);
        $google2fa = new Google2FA();
        if($request->ajax()){
            if ($google2fa->verifyKey($request->google2fa_secret, $request->otp)) {
                $user->update(['google2fa_secret' => $request->google2fa_secret]);
                return response()->json(['status'=>true,'success'=>'2 Factor Authentication added successfully']);
            } else {
                return response()->json(['status'=>false,'success'=>'otp are invalid']);
            }

        }
    }
    public function verifyotp(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // Verify OTP
        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
        }
    }
}
