<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return [
                    "user" => $user,
                    "token" => $user->createToken('token')->plainTextToken
                ];
            } else {
                return response()->json([
                    'message' => 'Invalid password'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
    public function me(Request $request)
    {
        return $request->user();
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
    public function updatePassword(Request $request,User $user)
    {
        $request->validate([
            'password' => 'required'
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return $user;
    }

    public function index(){ return User::orderBy('name')->get(); }
    public function show(User $user){ return $user; }
    public function store(Request $request){ return User::create($request->all()); }
    public function update(Request $request, $id){
        return User::find($id)->update($request->all());
    }
    public function destroy($id){
        $user=User::find($id);
        $user->delete();
        return $user;
    }
}
