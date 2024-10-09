<!-- resources/views/tickets/details.blade.php -->

@extends('layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Ticket Details Card -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">{{ $ticket->title }}</h3>
                        <p class="card-text"><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
                        <p class="card-text"><strong>Description:</strong> {{ $ticket->description }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                        <p class="card-text"><strong>Deadline:</strong> {{ $ticket->deadline }}</p>
                        <p class="card-text"><strong>Assigned User:</strong> {{ $ticket->assigned_user->name }}</p>
                        <p class="card-text"><strong>Created By User (ID):</strong> {{ $ticket->user_id }}</p>

                        <!-- Action Buttons -->
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-secondary">Edit</a>

                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">Back to Tickets</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
