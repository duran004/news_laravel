<?php
echo function_exists('opcache_get_status') && opcache_get_status() && opcache_get_status()['jit']['enabled'] ? 'JIT enabled' : 'JIT disabled';
?>
@extends('layouts.app')
@section('content')
    @livewire('Categories')
    @livewire('Counter', ['count' => 10])
    {{-- <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="info" />
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="primary" />
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="secondary" />
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="success" />
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="danger" />
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="warning" /> --}}
    <x-alert msg="The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk" type="dark" />

    <x-accordion class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <x-accordionitem title="acc 1">
            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
            plugin adds the appropriate classes that we use to style each element. These classes control the overall
            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
            within the <code>.accordion-body</code>, though the transition does limit overflow.
        </x-accordionitem>
        <x-accordionitem title="acc 2">
            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
            plugin adds the appropriate classes that we use to style each element. These classes control the overall
            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
            within the <code>.accordion-body</code>, though the transition does limit overflow.
        </x-accordionitem>
    </x-accordion>

    <x-form class="shadow-lg p-3 mb-5 bg-body-tertiary rounded" action="{{ route('welcome') }}" method="POST">
        <x-input type="number" placeholder="Enter your age" name="age" />
        <x-button type="success">Submit</x-button>
        <x-button type="success">Submit</x-button>
        <x-button type="success">Submit</x-button>
        <x-button type="success">Submit</x-button>
        <x-button type="success">Submit</x-button>
        <x-button type="success">Submit</x-button>
    </x-form>
@endsection
