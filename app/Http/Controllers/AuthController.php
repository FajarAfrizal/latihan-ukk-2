<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function pageLogin()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $check = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($check)){
            $request->session()->regenerate();
            return redirect()->route('pageProduct');
        }
        return redirect()->back()->with('error-login', 'Invalid username or password');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function index()
    {       
        $data = User::orderBy('created_at', 'desc')->get();
        return view('user.user', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if ($request->password){
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
        }else{
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role
            ]);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back();
    }
}
