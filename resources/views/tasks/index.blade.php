<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tasks: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <a href="{{ route('projects.index') }}" class="underline">
                Back to projects
            </a>

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Create a task</h3>

                @if ($errors->any())
                    <ul class="mb-4 list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('tasks.store', $project) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block mb-1">Title</label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            required
                            maxlength="255"
                            class="w-full border-gray-300 rounded"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block mb-1">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            maxlength="2000"
                            class="w-full border-gray-300 rounded"
                        >{{ old('description') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="bg-gray-800 text-white px-4 py-2 rounded"
                    >
                        Create task
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Your tasks</h3>

                @forelse ($tasks as $task)
                    <div class="border-b py-4">
                        <h4 class="font-semibold">{{ $task->title }}</h4>

                        <p class="text-gray-600 whitespace-pre-line">{{ $task->description }}</p>

                        <div class="mt-2">
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    class="task-completion rounded"
                                    data-url="{{ route('tasks.completion', $task) }}"
                                    @checked($task->is_completed)
                                >

                                <span class="task-status">
                                    {{ $task->is_completed ? 'Completed' : 'Incomplete' }}
                                </span>
                            </label>

                            <p class="task-error text-sm text-red-600" role="alert"></p>
                        </div>

                        <div class="flex items-center gap-4 mt-3">
                            <a
                                href="{{ route('tasks.edit', $task) }}"
                                class="underline"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('tasks.destroy', $task) }}"
                                onsubmit="return confirm('Delete this task?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">This project has no tasks yet.</p>
                @endforelse
            </div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.task-completion').forEach((checkbox) => {
            checkbox.addEventListener('change', async () => {
                const container = checkbox.closest('div');
                const status = container.querySelector('.task-status');
                const error = container.querySelector('.task-error');
                const previousValue = !checkbox.checked;

                checkbox.disabled = true;
                error.textContent = '';

                try {
                    const response = await fetch(checkbox.dataset.url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            is_completed: checkbox.checked,
                        }),
                    });

                    if (!response.ok) {
                        throw new Error('Request failed');
                    }

                    const data = await response.json();

                    checkbox.checked = data.is_completed;
                    status.textContent = data.is_completed
                        ? 'Completed'
                        : 'Incomplete';
                } catch (requestError) {
                    checkbox.checked = previousValue;
                    error.textContent = 'Could not save the status. Please try again.';
                } finally {
                    checkbox.disabled = false;
                }
            });
        });
    </script>

</x-app-layout>