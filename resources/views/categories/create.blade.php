<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-8">Create New Category</h2>
                <br>
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name <span class="text-red-600 hover:text-red-900"> *</span></label>
                        <input type="text" id="name" name="name" class="form-input w-full" placeholder="Enter category name" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Description <span class="text-red-600 hover:text-red-900"> *</span></label>
                        <textarea id="description" name="description" class="form-textarea w-full" placeholder="Enter category description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                   
                    <div class="mt-6">
                        <button style="background-color: hsl(234.47deg 87.58% 68.43%);" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>