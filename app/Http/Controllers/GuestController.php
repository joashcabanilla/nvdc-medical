<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller{
    public function __construct()
    {
    }
 
function Index(){
return view("Components.Adminlogin");
 }   
function register(){
return view("Components.register");
 }   

}




