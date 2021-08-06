@extends('layouts.app')
@section('content')
<br />
<h1>{{$post->title}}</h1>
<div>
    {!!$post->content!!}
</div>
<hr>
<small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
<hr />
<a href="/posts" class="btn btn-primary float-left">Go Back</a>
@if (Auth::check())
{!!Form::open(["action"=>["PostController@destroy",$post->id],"method"=>"POST","class"=>"float-right"])!!}
    {{Form::hidden("_method","DELETE")}}
    {{Form::submit("Delete",["class"=>"btn btn-danger"])}}
{!!Form::close()!!}
<a href="/posts/{{$post->id}}/edit" class="btn btn-primary float-right">Edit</a>
@endif
@endsection