@extends('layouts.app')

@section('content')
{{-- <h1>Posts</h1> --}}
@if (count($users)>0)
<div class="jumbotron">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nr.</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                @if (Auth::check())
                <th scope="col">Reset Password</th>
                <th scope="col">Delete User</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                @if ($user->id != auth()->user()->id)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td scope="row">{{$user->name}}</td>
                        <td scope="row">{{$user->role->name}}</td>
                        @if (Auth::check())
                        <td scope="row">
                            <a href="/users/{{$user->id}}/edit" class="btn btn-primary">Edit</a>
                        </td>
                        <td scope="row">
                            {!!Form::open(["action"=>["UserController@destroy",$user->id],"method"=>"POST"])!!}
                            {{Form::hidden("_method","DELETE")}}
                            {{Form::submit("Delete",["class"=>"btn btn-danger"])}}
                            {!!Form::close()!!}
                        </td>
                        @endif
                    </tr>   
                @endif
            @endforeach
        </tbody>
    </table>
{{$users->links('pagination::bootstrap-4')}}
</div>
@else
<p>You have no post</p>
@endif

@endsection