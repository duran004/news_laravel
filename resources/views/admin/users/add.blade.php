@extends('layouts.admin.app')
@section('title', 'Users')

@section('content')
    <div class="border-1 bg-white p-3 mt-3 shadow-sm">
        <h2>{{ __('Users.Add') }}</h2>
        <form action="{{ route('api.user.create') }}" method="post" class="formajax_refresh_popup">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                    placeholder="Password Confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
