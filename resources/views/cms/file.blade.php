@extends('layouts.cms')

@section('content-cms')
{{Form::open(['action'=>'FileController@store','method'=>'POST','enctype'=>'multipart/form-data'])}}
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
    <h3>Create File</h3>
    <br>
    {{Form::file('cover_file')}}
</div>
<br>
{{Form::submit('Save File',['class'=>'btn btn-primary'])}}
{{Form::close()}}
@endsection