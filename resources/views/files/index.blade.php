@extends('layouts.app')

@section('content')
{{-- <h1>Posts</h1> --}}
@if (count($files)>0)
<div class="jumbotron">
<table class="table">
    <thead>
        <tr>
            <th scope="col">Nr.</th>
            <th scope="col">File Name</th>
            <th scope="col">User</th>
            @if (Auth::check())
            <th scope="col">Delete</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($files as $key => $file)
        <tr>
            <th scope="row">{{$file->id}}</th>
            <td><a style="color:green" href="/files/{{$file->id}}">{{$file->filename}}</a></td>
            <td>{{$file->user->name}}</td>
            @if (Auth::check())
            <td>
            {!!Form::open(["action"=>["FileController@destroy",$file->id],"method"=>"POST"])!!}
            {{Form::hidden("_method","DELETE")}}
            {{Form::submit("Delete",["class"=>"btn btn-danger"])}}
            {!!Form::close()!!}
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
{{$files->links('pagination::bootstrap-4')}}
</div>
@else
    <p>No File</p>
 @endif

@endsection