<!-- resources/views/tickets/create.blade.php -->

@extends('layout')

@section('content')
    <h1>Create a New Ticket</h1>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required>

        <label for="deadline">Deadline:</label>
        <input type="date" name="deadline" id="deadline" required>

        <label for="assigned_user">Assigned User:</label>
        <input type="text" name="assigned_user" id="assigned_user" required>

        <button type="submit">Create Ticket</button>
    </form>
@endsection
