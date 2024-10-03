{{--
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<div class="container mt-5">
    <div class="row">
        <!-- Open Tickets Column -->
        <div class="col-md-4">
            <h3 class="text-center">Pending Tickets</h3>
            @foreach($tickets as $ticket)
                @if($ticket->status == 'pending')
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- In Progress Tickets Column -->
        <div class="col-md-4">
            <h3 class="text-center">Ongoing Tickets</h3>
            @foreach($tickets as $ticket)
                @if($ticket->status == 'ongoing')
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Closed Tickets Column -->
        <div class="col-md-4">
            <h3 class="text-center">Finished Tickets</h3>
            @foreach($tickets as $ticket)
                @if($ticket->status == 'finished')
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
--}}
<!-- resources/views/index.blade.php -->

@extends('layout')

@section('content')
    <div class="container">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <h1>Tickets Overview</h1>

        <!-- Create Ticket Button -->
        <div class="mb-4">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Create Ticket</a>
        </div>

        <!-- Row to separate statuses -->
        <div class="row">

            <!-- Column for Pending Tickets -->
            <div class="col-md-4">
                <h2>Pending</h2>
                @foreach($tickets->where('status', 'pending') as $ticket)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Column for Ongoing Tickets -->
            <div class="col-md-4">
                <h2>Ongoing</h2>
                @foreach($tickets->where('status', 'ongoing') as $ticket)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Column for Finished Tickets -->
            <div class="col-md-4">
                <h2>Finished</h2>
                @foreach($tickets->where('status', 'finished') as $ticket)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ $ticket->description }}</p>
                            <p class="card-text"><small class="text-muted">Deadline: {{ $ticket->deadline }}</small></p>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection

