<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                @if ($errors->any())
                    <ul class="mb-4 list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block mb-1">Title</label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title', $task->title) }}"
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
                        >{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <button
                            type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded"
                        >
                            Save changes
                        </button>

                        <a
                            href="{{ route('tasks.index', $task->project_id) }}"
                            class="underline"
                        >
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>