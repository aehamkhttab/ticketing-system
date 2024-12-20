@extends('layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Edit Ticket Form Card -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Edit Ticket</h3>

                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $ticket->title }}" required>
                            </div>

                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" id="description" class="form-control" rows="4" required>{{ $ticket->description }}</textarea>
                            </div>

                            <!-- Status Field -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing" {{ $ticket->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="finished" {{ $ticket->status == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                            </div>

                            <!-- Deadline Field -->
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline:</label>
                                <input type="date" name="deadline" id="deadline" class="form-control" value="{{ $ticket->deadline }}" required>
                            </div>

                            <!-- Assigned User Field -->
                            <div class="mb-3">
                                <label for="assigned_user_id" class="form-label">Assigned User ID:</label>
                                <select class="form-control" name="assigned_user_id">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected($ticket->assigned_user_id == $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Attachment Display & Upload -->
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attachments:</label>

                                <!-- Display Existing Attachments -->
                                @if ($ticket->attachments->isNotEmpty())
                                    <div class="mb-2">
                                        <h6>Existing Attachments:</h6>
                                        <ul>
                                            @foreach ($ticket->attachments as $attachment)
                                                <li>
                                                    <a href="{{ route('attachments.download', $attachment->id) }}" class="btn btn-link">
                                                        {{ $attachment->file_name }} (Download)
                                                    </a>
                                                    <form action="{{ route('attachments.destroy', $attachment->id) }}"
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="text-muted">No attachments uploaded yet.</p>
                                @endif

                                <!-- Upload New Attachments -->
                                <input type="file" name="attachments[]" id="attachments" multiple
                                       class="form-control @error('attachments') is-invalid @enderror">
                                @error('attachments')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Allowed file types: jpg, jpeg, png, pdf, doc, docx, xlsx</small>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Ticket</button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
