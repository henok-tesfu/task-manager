@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-red-500">Task Manager</h1>

    <!-- Success Messages -->
    @if(session('success'))
    <div class="p-4 mb-6 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Create New Project -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Create a New Project</h2>
        <form action="{{ route('projects.store') }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <input type="text" name="name" placeholder="Project Name"
                class="border p-2 rounded-lg flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Create</button>
        </form>
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Select Project -->
    @if($projects->isNotEmpty())
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Select a Project</h2>
        <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-4">
            <select name="project_id" onchange="this.form.submit()"
                class="border p-2 rounded-lg flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
    <p class="text-gray-500">No projects available. Please create a project to manage tasks.</p>
    @endif

    <!-- Task List -->
    @if($selectedProject)
    <div class="bg-gray-50 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Tasks for {{ $selectedProject->name }}</h3>

        <!-- Task List with Drag and Drop -->
        <ul id="task-list" class="space-y-4">
            @foreach($tasks as $task)
            <li data-id="{{ $task->id }}" class="p-4 bg-white rounded-lg shadow-md flex justify-between items-center">
                <span>{{ $task->name }}</span>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                </form>
            </li>
            @endforeach
        </ul>

        <!-- Add Task Form -->
        <div class="mt-6">
            <form action="{{ route('tasks.store') }}" method="POST" class="flex items-center space-x-4">
                @csrf
                <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                <input type="text" name="name" placeholder="Task Name"
                    class="border p-2 rounded-lg flex-1 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Add
                    Task</button>
            </form>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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