<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(){
        $plans = Plan::all();
        return view('plans.index', compact('plans'));
    }
    public function create(){
        return view('plans.add');
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stripe_id'=> 'required',
            'price_id'=> 'required'
        ]);
        $plan = Plan::create($data);
        return redirect()->route('plans.index')->with('success','Plan created successfully');
    }
}
