<form action="{{ $action }}" method="{{ $method }}" {{ $attributes }}>
    @csrf
    {{ $slot }}
</form>
