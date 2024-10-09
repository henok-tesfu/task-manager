@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded-md shadow-sm max-w-3xl">
    <h1 class="text-2xl font-bold mb-4 text-red-500">Task Manager</h1>

    <!-- Success Messages -->
    @if(session('success'))
    <div class="p-3 mb-4 bg-green-50 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    <!-- Create New Project -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-2">Create a New Project</h2>
        <form action="{{ route('projects.store') }}" method="POST" class="flex items-center space-x-2">
            @csrf
            <input type="text" name="name" placeholder="Project Name"
                class="border p-1 rounded-md flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit"
                class="bg-indigo-500 text-white px-3 py-1 rounded-md hover:bg-indigo-600">Create</button>
        </form>
        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    <!-- Select Project -->
    @if($projects->isNotEmpty())
    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-2">Select a Project</h2>
        <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-2">
            <select name="project_id" onchange="this.form.submit()"
                class="border p-1 rounded-md flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Select a Project</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ $selectedProject && $selectedProject->id == $project->id ?
                    'selected' : '' }}>
                    {{ $project->name }}
                </option>
                @endforeach
            </select>
        </form>
    </div>
    @else
    <p class="text-gray-500 text-sm">No projects available. Please create a project to manage tasks.</p>
    @endif

    <!-- Task List -->
    @if($selectedProject)
    <div class="bg-gray-50 p-4 rounded-md shadow-sm">
        <h3 class="text-lg font-semibold mb-3">Tasks for {{ $selectedProject->name }}</h3>

        <!-- Task List with Drag and Drop -->
        <ul id="task-list" class="space-y-3">
            @foreach($tasks as $task)
            <li data-id="{{ $task->id }}" class="p-3 bg-white rounded-md shadow-md flex justify-between items-center">
                <span>{{ $task->name }}</span>
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:text-blue-600">Edit</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>

        <!-- Add Task Form -->
        <div class="mt-4">
            <form action="{{ route('tasks.store') }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                <input type="text" name="name" placeholder="Task Name"
                    class="border p-1 rounded-md flex-1 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">Add
                    Task</button>
            </form>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var taskList = document.getElementById('task-list');

        new Sortable(taskList, {
            animation: 150,
            onEnd: function () {
                var order = Array.from(taskList.children).map(function (task) {
                    return task.dataset.id;
                });

                fetch("{{ route('tasks.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    });
</script>
@endsection