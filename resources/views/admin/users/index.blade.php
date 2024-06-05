@extends('layouts.admin.app')
@section('title', 'Users')

@section('content')
    <div class="border-1 bg-white p-3 mt-3 shadow-sm">
        <h2>{{ __('dashboard.Users') }}</h2>

        {{-- <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>email</th>
                        <th>email_verified_at</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table> --}}
        @livewire('livewire-data-table', ['model' => \App\Models\User::class, 'api_route' => '/admin/users'])
        {{-- @livewire('livewire-data-table', ['model' => \App\Models\Category::class, 'api_route' => '/admin/users'])
        @livewire('livewire-data-table', ['model' => \App\Models\Image::class, 'api_route' => '/admin/users'])
        @livewire('livewire-data-table', ['model' => \App\Models\MainCategory::class, 'api_route' => '/admin/users'])
        @livewire('livewire-data-table', ['model' => \App\Models\News::class, 'api_route' => '/admin/users']) --}}
        @livewireScripts

    </div>



    {{-- <script>
        window.onload = function() {
            $('#myTable').DataTable({
                ajax: {
                    url: '{!! route('api.user.get.all') !!}',
                    type: 'GET',
                    dataSrc: 'data',
                },
                serverSide: true,
                processing: true,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            return '<a href="/admin/users/' + row.id + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'email_verified_at'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <div class="grid grid-cols-2 gap-2">
                                <form action="/admin/users/${data}" method="get" class="formajax_refresh_popup col-6">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                </form>
                                <form action="/api/user/delete/${data}" method="post" class="formajax_delete col-6 ">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>

                            </div>
                            `;
                        }
                    }
                ]
            });
        };
    </script> --}}


@endsection
