<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;


class UserController extends Controller
{
    


 public function logout(){
   
   Auth::logout();
   Session::forget('side_menu');
   return redirect('/');

 }

 public function getUser(){
        
  $user_id = Auth::user()->id; 
  return $user_id;
}
}
