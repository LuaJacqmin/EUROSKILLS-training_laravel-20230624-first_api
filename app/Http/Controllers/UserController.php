<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers(){
        $users = DB::table('users')->get();
        $userItems = DB::table('items')->get();

        foreach ($users as $key => $user) {
            $user->items = DB::table('items')->where('user_id', '=', $user->id)->get();
        }

        return $users ? $users : abort(404);
    }

    public function getUser($id){
        $user = DB::table('users')->where('id', $id)->first();
        $user->items = DB::table('items')->where('user_id', '=', $id)->get();

        return $user ? $user : abort(404);
    }

    public function newUser(Request $request){
        $newUser = new User();

        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;
        $newUser->remember_token = $request->remember_token;

        $newUser->save();

        return $newUser;
    }

    public function updateUser(Request $request, int $id){
        $updatedUser = User::findOrFail($id);

        $updatedUser->update($request->all());

        return response()->json(["data" => $updatedUser, "Message"=>sprintf('User %s has been updated', $id)]);
    }

    public function deleteUser(int $id){
        User::findOrFail($id)->delete();

        DB::table('items')->where('user_id', $id)->delete();

        return response()->json(["Message"=>sprintf('User %s has been deleted', $id)]);
    }
}
