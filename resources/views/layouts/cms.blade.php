@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Controll Managment Service') }}</div>

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a href="/cms/post" class="active" aria-selected="true">Post builder</a>
            </div>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a href="/cms/file" class="active" aria-selected="true">File management</a>
            </div>
            @if (Auth::user()->role->name=='Super Admin')
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a href="/cms/usermanagment" class="active" aria-selected="true">User / Role Managment</a>
                </div>   
            @endif
        </div>
        <div class="col-md-9">
            @yield('content-cms')
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection