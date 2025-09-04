@extends ('layouts.app')

@section('title', 'Notifications')

@section('content')

    <div class="container mt-4 scrollbar">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('home.dashboard') }}" class="btn btn-outline-secondary btn-cancel">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <h2 class="primary-text mb-2 mt-2">Notifications</h2>
        @foreach ($notifications as $note)
            <div class="card mb-4">
                <div class="card-header fs-5">
                    <div class="d-flex justify-content-between">
                        <span>
                            Notification #{{ $note->id }} — Subject: {{ $note->subject }}
                        </span>
                        @if (!$note->read)
                            <form action="{{ route('notifications.update', $note->id) }}" method="POST"
                                class="d-inline m-0 p-0">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <button type="submit" class="btn p-0 m-0" style="font-size: 0.9em;">
                                    📩
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="text-end">
                        Sender:
                        @if ($note->sender)
                            {{ $note->sender }}
                            <div class="font-italic">
                                {{ $note->sender->email }}
                            </div>
                        @else
                            System
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <p>
                        {{ $note->message }}
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <form id="delete-form-{{ $note->id }}" action="{{ route('notifications.destroy', $note->id) }}"
                        method="POST" class="d-inline m-0 p-0">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="button" class="btn btn-link p-0 m-0  btn-delete" data-id="{{ $note->id }}"
                            style="font-size: 0.9em;">
                            🗑
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Pagination links --}}
        <div class="mt-4 d-flex justify-content-end">
            {{ $notifications->links() }}
        </div>
    </div>

@endsection
