<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreated;
use App\Mail\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {
   //the first endpoint; Create User API
   public function createUser(Request $request) {
         //users validation
         $validdata = $request->validate([
            "email"=> "required|email|unique:users,email",
            "password"=> "required|min:8",
            "name"=> "required|min:3|max:50",
         ]);

         //Create a new user
         $user = User::create([
            "email"=> $validdata["email"],
            "password"=> Hash::make($validdata["password"]),
            "name"=> $validdata["name"],
         ]);

         //send two emails with mailhog
         Mail::to($user->email)->send(new UserCreated($user));
         Mail::to("admin@example.com")->send(new AdminNotification($user));

         //Response
         return response()->json([
            "id" => $user->id,
            "email" => $user->email,
            "name" => $user->name,
            "created_at" => $user->created_at, 	
         ]);
    }

   //the second enpoint: Get Users API
   public function getUsers(Request $request) {
      $search = $request->input("search");
      $sortBy = $request->input("sortBy", "created_at");
      $page = $request->input("page", 1);

      $users = User::withCount("orders")->when($search, function($query, $search) {
         $query->where("name","like","%$search%")
               ->orWhere("email","like","%$search%");
      })
      ->orderBy($sortBy)
      ->paginate(10, ["*"], "page", $page);

      //Response
      return response()->json([
         "page" => $users->currentPage(),
         "users" => $users->items(),	
      ]);
   }
}