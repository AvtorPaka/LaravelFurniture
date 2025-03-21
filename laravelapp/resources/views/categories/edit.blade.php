<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Category with ID : {{ $category->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <x-input-label for="name" value="Category Name" />
                            <x-text-input id="name" name="name"
                                          value="{{ old('name', $category->name) }}"
                                          class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description"
                                      class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                      rows="3">{{ old('description', $category->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="parent_category_id" value="Parent Category" />
                            <select id="parent_category_id" name="parent_category_id"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">No Parent</option>
                                @foreach($availableParents as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_category_id', $category->parent_category_id) == $parent->id ? 'selected' : '' }}
                                        {{ $parent->id === $category->id ? 'disabled' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('parent_category_id')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="px-6 py-3">
                                Save Changes
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
