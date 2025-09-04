@extends ('layouts.app')

@section('title', 'Notification')

@section('content')

    <div class="container mt-4 scrollbar">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('home.dashboard') }}" class="btn btn-outline-secondary btn-cancel">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <h2 class="primary-text mb-2 mt-2">Notification</h2>

        <div class="card mb-4">
            <div class="card-header fs-5">
                <div class="d-flex justify-content-between">
                    <span>
                        Notification #{{ $notifications->id }} — Subject: {{ $notifications->subject }}
                    </span>
                    <form action="{{ route('notifications.update', $notifications->id) }}" method="POST"
                        class="d-inline m-0 p-0">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit" class="btn btn-link p-0 m-0" style="font-size: 0.9em;">
                            📩
                        </button>
                    </form>
                </div>
                <div class="text-end">
                    Sender:
                    @if ($notifications->sender)
                        {{ $notifications->sender }}
                        <div class="font-italic">
                            {{ $notifications->sender->email }}
                        </div>
                    @else
                        System
                    @endif
                </div>
            </div>
            <div class="card-body">
                <p>
                    {{ $notifications->message }}
                </p>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <form id="delete-form-{{ $notifications->id }}"
                    action="{{ route('notifications.destroy', $notifications->id) }}" method="POST"
                    class="d-inline m-0 p-0">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-link p-0 m-0  btn-delete" data-id="{{ $notifications->id }}"
                        style="font-size: 0.9em;">
                        🗑
                    </button>
                </form>
            </div>
        </div>

        {{-- Pagination links
        <div class="mt-4 d-flex justify-content-end">
            {{ $notifications->links() }}
        </div> --}}

    </div>

@endsection
