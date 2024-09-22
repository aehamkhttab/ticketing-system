<!-- resources/views/tickets/edit.blade.php -->

@extends('layout')

@section('content')
    <h1>Edit Ticket</h1>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ $ticket->title }}" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required>{{ $ticket->description }}</textarea>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" value="{{ $ticket->status }}" required>

        <label for="deadline">Deadline:</label>
        <input type="date" name="deadline" id="deadline" value="{{ $ticket->deadline }}" required>

        <label for="assigned_user">Assigned User:</label>
        <input type="text" name="assigned_user" id="assigned_user" value="{{ $ticket->assigned_user }}" required>

        <button type="submit">Update Ticket</button>
    </form>
@endsection
