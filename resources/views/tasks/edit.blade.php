@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded-md shadow-sm max-w-3xl">
    <h1 class="text-2xl font-bold mb-4 text-red-500">Edit Task</h1>

    <!-- Success Messages -->
    @if(session('success'))
    <div class="p-3 mb-4 bg-green-50 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
            <input type="text" name="name" id="name" value="{{ $task->name }}"
                class="border p-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('tasks.index', ['project_id' => $selectedProject->id]) }}"
                class="bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600">Cancel</a>
            <button type="submit"
                class="bg-indigo-600 text-white px-3 py-1 rounded-md hover:bg-indigo-700">Update</button>
        </div>
    </form>
</div>
@endsection