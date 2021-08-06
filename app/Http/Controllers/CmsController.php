<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;


class CmsController extends Controller
{
    public $users ;
    public function __construct(){
        $this->users=User::all();
        $this->middleware('auth')->except('index');
    }
     public function post(){
        return view('cms.post')->with('users',$this->users);
    }
     public function file(){
        return view('cms.file')->with('users',$this->users);
    }
     public function usermanagment(){
        $roles = Role::get();
        return view('cms.usermanagment')->with('roles',$roles)->with('users',$this->users);
    }
}
