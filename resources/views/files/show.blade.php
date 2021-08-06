@extends('layouts.app')
@section('content')
<br />
<h1>{{$file->pathname}}</h1>
<hr>
<small>Saved {{$file->created_at}} by {{$file->user->name}}</small>
<hr />
@if (Auth::check())
<a href="/files" class="btn btn-primary float-left">Go Back</a>
<br>
<br>
<img src="/storage//cover_file/{{$file->filename}}" alt="">
@endif
@endsection