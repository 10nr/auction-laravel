<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('categories.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded">
                    Add Category
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left p-3">Name</th>
                                <th class="text-left p-3">Description</th>
                                <th class="text-left p-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-b">
                                    <td class="p-3">
                                        {{ $category->name }}
                                    </td>

                                    <td class="p-3">
                                        {{ $category->description ?? 'No description' }}
                                    </td>

                                    <td class="p-3">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           style="color: blue;">
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600"
                                                    onclick="return confirm('Delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3 text-center">
                                        No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
