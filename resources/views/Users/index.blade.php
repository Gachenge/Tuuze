@php
    $primary_role = strtolower(auth()->user()->primary_role);
    $layout = $primary_role === 'super_admin' ? 'layouts.admin' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Users')

@section('content')

    <div class="container mt-4">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="userRolesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
                    role="tab" aria-controls="users" aria-selected="true">
                    Users
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button"
                    role="tab" aria-controls="roles" aria-selected="false">
                    Roles
                </button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="userRolesTabContent">
            <!-- Users Tab -->
            <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="text-end m-2 mb-3">
                    <a class="btn btn-primary btn-custom" href="{{ route('users.addUser') }}">
                        ➕ New
                    </a>
                </div>
                <div class="table-responsive vh-100">
                    <table class="table align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Primary role</th>
                                <th>Assigned role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $usr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $usr->name }}</td>
                                    <td>{{ $usr->email }}</td>
                                    <td>{{ $usr->primary_role }}</td>
                                    <td>{{ $usr->role->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="more-btn dropdown text-grey bg-transparent border-0"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                id="dropdownMenuButton{{ $loop->iteration }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="3.794" height="15.176"
                                                    viewBox="0 0 3.794 15.176">
                                                    <path
                                                        d="M18.981,8.647a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,8.647Zm0,11.382a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,20.029Zm0-5.691a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,14.338Z"
                                                        transform="translate(-15.188 -6.75)" fill="Currentcolor"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border-0 shadow">
                                                <a class="dropdown-item" href="{{ route('users.editUser', $usr->id) }}">
                                                    📝Edit
                                                    user</a>
                                                <form id="delete-form-{{ $usr->id }}"
                                                    action="{{ route('users.deleteUser', $usr->id) }}" method="POST"
                                                    style="display: inline;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('Delete') }}
                                                    <button type="button" class="dropdown-item btn-delete"
                                                        data-id="{{ $usr->id }}">
                                                        🗑 Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- Roles Tab -->
            <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                <div class="text-end m-2 mb-3">
                    <a class="btn btn-primary btn-custom" href="{{ route('users.addRole') }}">
                        ➕ New
                    </a>
                </div>
                <div class="table-responsive vh-100">
                    <table class="table align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>No. of users</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rol->name }}</td>
                                    <td>{{ $rol->role_category }}</td>
                                    <td>{{ $rol->users->count() }}</td>
                                    <td>{{ $rol->status ? 'Active' : 'Deactivated' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="more-btn dropdown text-grey bg-transparent border-0"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                id="dropdownMenuButton{{ $loop->iteration }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="3.794" height="15.176"
                                                    viewBox="0 0 3.794 15.176">
                                                    <path
                                                        d="M18.981,8.647a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,8.647Zm0,11.382a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,20.029Zm0-5.691a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,14.338Z"
                                                        transform="translate(-15.188 -6.75)" fill="Currentcolor"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border-0 shadow">
                                                <a class="dropdown-item" href="{{ route('users.editRole', $rol->id) }}">
                                                    📝Edit
                                                    role</a>
                                                <form id="delete-form-{{ $rol->id }}"
                                                    action="{{ route('users.deleteRole', $rol->id) }}" method="POST"
                                                    style="display: inline;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('Delete') }}
                                                    <button type="button" class="dropdown-item btn-delete"
                                                        data-id="{{ $rol->id }}">
                                                        🗑 Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-end">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
