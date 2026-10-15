<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My projects
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Create a project
                </h3>

                @if ($errors->any())
                    <ul class="mb-4 list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block mb-1">
                            Project name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
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
                        Create project
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Your projects
                </h3>

                @forelse ($projects as $project)
                    <div class="border-b py-4">
                        <h4 class="font-semibold">
                            <a href="{{ route('tasks.index', $project) }}" class="underline">
                                {{ $project->name }}
                            </a>
                        </h4>

                        <p class="text-gray-600 whitespace-pre-line">{{ $project->description }}</p>

                        <form
                            method="POST"
                            action="{{ route('projects.destroy', $project) }}"
                            onsubmit="return confirm('Delete this project and all its tasks?');"
                            class="mt-3"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-red-600">
                                Delete project
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-600">
                        You have no projects yet. Create your first one above.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>