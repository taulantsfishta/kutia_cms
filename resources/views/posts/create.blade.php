@extends('layouts.app')
@section('content')
    <h1>Create Post</h1>
    {{Form::open(['action'=>'PostController@store','method'=>'POST'])}}
        <div class="form-group">
            {{Form::label('title','Title')}}
            {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('content','Content')}}
            {{Form::textarea('content','',['id'=>'content','class'=>'form-control','placeholder'=>'Contnet'])}}
        </div>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {{Form::close()}}
@endsection