<!-- resources/views/tickets/details.blade.php -->

@extends('layout')

@section('content')
    <h1>{{ $ticket->title }}</h1>

    <p><strong>Description:</strong> {{ $ticket->description }}</p>
    <p><strong>Status:</strong> {{ $ticket->status }}</p>
    <p><strong>Deadline:</strong> {{ $ticket->deadline }}</p>
    <p><strong>Assigned User:</strong> {{ $ticket->assigned_user }}</p>

    <a href="{{ route('tickets.edit', $ticket->id) }}">Edit Ticket</a>
    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Ticket</button>
    </form>
    <a href="{{ route('tickets.index') }}">Back to Tickets</a>
@endsection
