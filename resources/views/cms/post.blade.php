@extends('layouts.cms')
@section('content-cms')
{{Form::open(['action'=>'PostController@store','method'=>'POST'])}}
@if(Auth::user()->role->name=='Super Admin')
<div class="form-group">
    {!! Form::Label('item', 'Select User:') !!}
    <select class="form-control" name="user_id" required>
        <option value="" disabled selected>User List</option>
        @foreach($users as $user)
        @if (($user->role_id != 1))
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endif
        @endforeach
    </select>
</div>
@endif
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