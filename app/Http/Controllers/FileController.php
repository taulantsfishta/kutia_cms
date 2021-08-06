<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((auth()->user() == null) || (auth()->user()->role->name == 'Super Admin')){
            $files = File::orderBy('created_at','asc')->paginate(5);
        }else{
            $files = File::where('user_id',auth()->user()->id)->orderBy('created_at','asc')->paginate(5);
        }
        return view('files.index')->with('files',$files);   
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
            'cover_file'=>'image|nullable|max:1999'
        ]);

        // Handle File Upload 
        if($request->hasFile('cover_file')){
            //Get filename with the extension
            $fileNameWithExt = $request->file('cover_file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_file')->getClientOriginalExtension();
            //File name to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload File
            $path = $request->file('cover_file')->storeAs('public/cover_file',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }
        $file = new File;
        $file->filename = $fileNameToStore;
        $file->user_id = isset($request->user_id) ? $request->user_id : auth()->user()->id;
        $file->save();
        return redirect('/files')->with('success','File is saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::where('id',$id)->where('user_id',auth()->user()->id)->get();
        if(count($file)>0){
            return view('files.show')->with('file',$file[0]);
        }else{
           return redirect('/files');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);
        unlink(storage_path('app/public/cover_file/'.$file->filename));
        $file->delete();
        return redirect('/files')->with('success','File Successfully Deleted');

    }
}
