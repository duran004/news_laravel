@extends('layouts.admin.app')
@section('title', 'Users')

@section('content')
    <div class="border-1 bg-white p-3 mt-3 shadow-sm">
        <h2>{{ __('Admin.users') }}</h2>
        @livewire('LivewireDataTable', ['model' => \App\Models\User::class, 'api_route' => '/admin/users'])
        @livewireScripts
    </div>
@endsection
