<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::getAll();
    }

    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string'],
            'username' => ['string', 'max:30', 'unique:users'],
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
        ]);

        $user = User::create($validatedUser);

        return $user;
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
