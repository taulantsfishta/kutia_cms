<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
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
        if((auth()->user() == null) || (auth()->user()->role->name == 'Super Admin')){
            $posts = Post::orderBy('created_at','asc')->paginate(3);
        }else{
            $posts = Post::where('user_id',auth()->user()->id)->orderBy('created_at','asc')->paginate(3);
        }
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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
            'title'=>'required',
            'content'=>'required'
        ]);
        $post = new Post();
        $post->title=$request->input('title');
        $post->content = $request->input('content');
        $post->user_id = isset($request->user_id) ? $request->user_id : auth()->user()->id;

        $post->save();

        return redirect('/posts')->with('success','Post Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id',$id)->where('user_id',auth()->user()->id)->get();
        if((count($post)>0) || (auth()->user()->role->name=="Super Admin")){
            $post = Post::where('id',$id)->get();
            return view('posts.show')->with('post',$post[0]);
        }else{
           return redirect('/posts');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if( (auth()->user()->role->name !== "Super Admin") &&  isset($post->user_id) && (auth()->user()->id != $post->user_id) ){
           return redirect('/posts');
        }
        return view('posts.edit')->with('post',$post);
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
        $this->validate($request,[
            'title' => 'required',
            'content'  => 'required'
        ]);
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect('/posts')->with('success','Post Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if((auth()->user()->role->name !== "Super Admin") && isset($post->user_id) && (auth()->user()->id != $post->user_id)){
           return redirect('/posts');
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Successfully Deleted');
    }
}
