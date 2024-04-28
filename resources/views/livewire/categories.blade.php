<div>
    <h1>Categories</h1>
    <x-input type="text" wire:model.live="search" />
    @error('search')
        <x-alert type="info">{{ $message }}</x-alert>
    @enderror
    @if (session()->has('error'))
        <x-alert type="danger">{{ session('error') }}</x-alert>
    @endif
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <x-button wire:navigate href="edit/{{ $category->id }}">Edit</x-button>
                        <x-button wire:click="delete({{ $category->id }})">Delete</x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
