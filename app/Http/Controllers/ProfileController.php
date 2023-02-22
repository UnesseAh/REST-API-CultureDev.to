<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //

    public function editProfile(Request $request, User $user){
        $input = $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|unique:users',
            'password'=>'required'
        ]);

        $input['password'] = Hash::make($request->password);

        $user->update($input);

        return response(['message'=>'profile updated successfully'], 200);
    }
}
