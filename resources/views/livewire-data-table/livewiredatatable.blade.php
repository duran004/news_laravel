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
            @if ($items->isEmpty())
                <tr>
                    <td colspan="{{ count($columns) }}">
                        <div class="w-100 text-center p-1 alert alert-danger ">No records found.</div>
                    </td>
                </tr>
            @endif

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
                                if ($item->$label != null) {
                                    $relation = Str::beforeLast($label, '_id');
                                    if ($relation == 'parent') {
                                        //if same model name
                                        $relation = $model_name;
                                    }
                                    //make camel case and remove _
                                    $relation = Str::camel($relation);
                                    //make first letter capital
                                    $relation = ucfirst($relation);
                                    //call the relation model
                                    $relation = 'App\Models\\' . $relation;

                                    $relation = new $relation();
                                    $relation = $relation->find($item->$label);
                                } else {
                                    $relation = null;
                                }
                            @endphp

                            @if (Str::contains($label, 'image'))
                                <td><img src="{{ @$relation->path }}" alt="{{ @$relation->name }}" width="100"></td>
                            @else
                                <td>{{ @$relation->name }}</td>
                            @endif
                        @elseif ($label == 'actions')
                            <td>
                                <div class="btn-group w-100">

                                    @can("$model_name-show")
                                        <form action="{{ $api_route }}/{{ $item->id }}/" method="get"
                                            class="formajax_view w-100">
                                            @csrf
                                            <button type="submit" class="w-100 btn btn-sm btn-info p-1 "><i
                                                    class="fas fa-eye"></i></button>
                                        </form>
                                    @endcan
                                    @can("$model_name-edit")
                                        <form action="{{ $api_route }}/{{ $item->id }}/edit" method="get"
                                            class="formajax_edit w-100">
                                            @csrf
                                            <button type="submit" class="w-100 btn btn-block btn-sm btn-warning p-1"><i
                                                    class="fas fa-edit"></i></button>
                                        </form>
                                    @endcan
                                    {{--  if model permissions --}}
                                    @can("$model_name-destroy", $item)
                                        <form action="{{ $api_route }}/{{ $item->id }}" method="post"
                                            class="formajax_delete w-100">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="w-100 btn btn-sm btn-danger p-1"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </div>

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
