@extends('layouts.admin')

@section('title', 'Business')

@section('content')

    <div class="container mt-4">
        <div class="text-end m-2 mb-3">
            <a href="{{ route('admin.newBusiness') }}" class="btn btn-primary btn-custom">
                New
            </a>
        </div>
        <div class="table-responsive vh-100">
            <table class="table align-middle table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Business</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($businesses as $bus)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bus->name }}</td>
                            <td>{{ $bus->email }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="more-btn dropdown text-grey bg-transparent border-0" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        id="dropdownMenuButton{{ $loop->iteration }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="3.794" height="15.176"
                                            viewBox="0 0 3.794 15.176">
                                            <path
                                                d="M18.981,8.647a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,8.647Zm0,11.382a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,20.029Zm0-5.691a1.9,1.9,0,1,0-1.9,1.9A1.9,1.9,0,0,0,18.981,14.338Z"
                                                transform="translate(-15.188 -6.75)" fill="Currentcolor"></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow">
                                        <a class="dropdown-item" href="{{ route('admin.editBusiness', $bus->id) }}">Edit</a>
                                        <form id="delete-form-{{ $bus->id }}"
                                            action="{{ route('admin.deleteBusiness', $bus->id) }}" method="POST"
                                            style="display: inline;">
                                            {{ csrf_field() }}
                                            {{ method_field('Delete') }}
                                            <button type="button" class="dropdown-item btn-delete"
                                                data-id="{{ $bus->id }}">
                                                Delete
                                            </button>
                                        </form>
                                        <a class="dropdown-item" href="{{ route('admin.passwordReset', $bus->id) }}">Reset
                                            password</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.startImpersonate', $bus->id) }}">Login as business</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
