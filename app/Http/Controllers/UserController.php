<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Support\Facades\Crypt;



class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>'index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user() != null ){
            $users = User::orderBy('created_at','asc')->paginate(5);
            return view('users.index')->with('users',$users);   
        }else{
            return redirect('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'role_id'=>'required',
            'password' =>'required',
        ]);
        error_log(User::where('name',$request->name)->get());
        error_log(User::where('email',$request->email)->get());
        if(count(User::where('name',$request->name)->get())>0 || count(User::where('email',$request->email)->get())>0){
            return redirect('cms/usermanagment')->with('error','Username Or Email Exist');      
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect('/users')->with('success','User Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if( (auth()->user()->role->name !== "Super Admin") &&  isset($user->user_id) && (auth()->user()->id != $user->user_id) ){
           return redirect('/users');
        }
        return view('users.edit')->with('user',$user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->password!=$request->password_confirmation){
            return redirect('/users')->with('error',"Passowords didin't match");   
        } 
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/users')->with('success','Password Successfully Reseted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success','User Successfully Deleted');
    }
}
