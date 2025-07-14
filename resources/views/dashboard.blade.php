@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    <p>This is your task management dashboard.</p>

    <!-- Task Management Buttons -->
    <a href="{{ route('tasks.index') }}" class="btn btn-primary">View Tasks</a>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">Create New Task</a>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
