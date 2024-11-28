{{--


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
                            <p class="card-text" ><small>Assigned to: {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text"><small>Deadline: {{ $ticket->deadline }}</small></p>
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
                            <p class="card-text" ><small>Assigned to: {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text" ><small>Deadline: {{ $ticket->deadline }}</small></p>
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
                            <p class="card-text" ><small>Assigned to: {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text"><small>Deadline: {{ $ticket->deadline }}</small></p>
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

--}}
@extends('layout')

@section('content')
    <div class="container">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Page Title -->
        <h1 class="my-4 text-center text-uppercase">Tickets Overview</h1>

        <!-- Create Ticket Button -->
        <div class="mb-4 text-center">
            <a href="{{ route('tickets.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle"></i> Create Ticket
            </a>
        </div>

        <!-- Sorting Controls -->
        <div class="mb-4 text-center">
            <form method="GET" action="{{ route('tickets.index') }}" class="d-inline">
                <label for="sort" class="form-label fw-bold">Sort by Deadline:</label>
                <select name="sort" id="sort" class="form-select d-inline w-auto" onchange="this.form.submit()">
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Earliest First</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Latest First</option>
                </select>
            </form>
        </div>

        <!-- Tickets Section -->
        <div class="row">
            <!-- Pending Tickets -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 bg-light rounded p-3">
                <h2 class="text-center text-success">Pending</h2>
                @foreach($pendingTickets as $ticket)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $ticket->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($ticket->description, 100) }}</p>
                            <p class="card-text"><small><strong>Assigned to:</strong> {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text"><small><strong>Deadline:</strong> {{ $ticket->deadline }}</small></p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $pendingTickets->links() }}
                </div>
            </div>

            <!-- Ongoing Tickets -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 bg-secondary text-white rounded p-3">
                <h2 class="text-center">Ongoing</h2>
                @foreach($ongoingTickets as $ticket)
                    <div class="card mb-3 shadow-sm border-0 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-warning">{{ $ticket->title }}</h5>
                            <p class="card-text">{{ Str::limit($ticket->description, 100) }}</p>
                            <p class="card-text"><small><strong>Assigned to:</strong> {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text"><small><strong>Deadline:</strong> {{ $ticket->deadline }}</small></p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $ongoingTickets->links() }}
                </div>
            </div>

            <!-- Finished Tickets -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 bg-dark text-white rounded p-3">
                <h2 class="text-center text-warning">Finished</h2>
                @foreach($finishedTickets as $ticket)
                    <div class="card mb-3 shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-success">{{ $ticket->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($ticket->description, 100) }}</p>
                            <p class="card-text"><small><strong>Assigned to:</strong> {{ $ticket->assigned_user->name }}</small></p>
                            <p class="card-text"><small><strong>Deadline:</strong> {{ $ticket->deadline }}</small></p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $finishedTickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

