{{-- user show page --}}

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User {{ $user->id }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th> Roles </th>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th> Name </th>
                                    <td> {{ $user->name }} </td>
                                </tr>
                                <tr>
                                    <th> Email </th>
                                    <td> {{ $user->email }} </td>
                                </tr>
                                <tr>
                                    <th> Email Verified At </th>
                                    <td> {{ $user->email_verified_at }} </td>
                                </tr>
                                <tr>
                                    <th> Password </th>
                                    <td> {{ $user->password }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
