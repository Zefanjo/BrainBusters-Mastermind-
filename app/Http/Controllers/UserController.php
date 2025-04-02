<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('login', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register', [
            'users' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = request::all();
        $data = $request->validated();
        $data['name'] ='name';
        $data['email'] ='email';
        $data['password'] ='password';
        $user = new User($data);

        $user->save();

        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('/profile');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
//        dd($request->all());
        $user = auth()->user();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);

        $user->save();
        return redirect('/profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('profile');
    }

    public  function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
