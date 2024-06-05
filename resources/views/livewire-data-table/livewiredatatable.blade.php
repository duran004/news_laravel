{{-- @once
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endonce --}}
<div>
    <input wire:model.live="search" type="search" class="form-control" placeholder="Search users..." />
    <table class="table">
        <thead>
            <tr>

                @foreach ($columns as $column => $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

            @foreach ($items as $item)
                <tr>
                    @foreach ($columns as $column => $label)
                        @php
                            //if label text is long cut
                            $item->$label = Str::limit($item->$label, 100);

                        @endphp
                        @if (Str::endsWith($label, '_at'))
                            <td><span title="{{ $item->$label }}">{{ $item->$label->format('d/m/Y H:i:s') }}</span></td>
                        @elseif (Str::endsWith($label, '_id'))
                            @php
                                $relation = Str::beforeLast($label, '_id');
                                //make camel case and remove _
                                $relation = Str::camel($relation);
                                //make first letter capital
                                $relation = ucfirst($relation);
                                //call the relation model
                                $relation = 'App\Models\\' . $relation;
                                $relation = new $relation();
                                $relation = $relation->find($item->$label);
                            @endphp

                            @if (Str::contains($label, 'image'))
                                <td><img src="{{ $relation->path }}" alt="{{ $relation->name }}" width="100"></td>
                            @else
                                <td>{{ $relation->name }}</td>
                            @endif
                        @elseif ($label == 'actions')
                            <td>
                                <a href="{{ $api_route }}/{{ $item->id }}/edit" class="btn btn-primary">Edit</a>
                                <a href="{{ $api_route }}/{{ $item->id }}/delete"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        @else
                            <td>{{ $item->$label }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination pagination-sm">
        @if ($items->previousPageUrl())
            <button wire:click="setPage({{ $items->currentPage() - 1 }})" class="page-item page-link">Previous</button>
        @endif

        @foreach (range(1, $items->lastPage()) as $page)
            <button wire:click="setPage({{ $page }})"
                class="{{ $items->currentPage() == $page ? 'disabled' : 'active' }} page-item page-link">{{ $page }}</button>
        @endforeach

        @if ($items->nextPageUrl())
            <button wire:click="setPage({{ $items->currentPage() + 1 }})" class="page-item page-link">Next</button>
        @endif

    </div>
</div>
