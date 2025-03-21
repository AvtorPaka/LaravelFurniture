<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Name:</p>
                            <p class="font-medium">{{ $category->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600">Parent Category:</p>
                            <p class="font-medium">
                                @if($category->parent === null)
                                    -
                                @else
                                    <a href="{{ route('categories.show', $category->parent) }}"
                                       class="hover:text-blue-600">
                                        Name: {{$category->parent->name}}

                                        @can('categories.view.all')
                                        <br> ID: {{$category->parent->id}}
                                        @endcan

                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    @can('categories.view.all')
                    <div>
                        <p class="text-gray-600">ID:</p>
                        <p class="font-medium">{{ $category->id }}</p>
                    </div>
                    @endcan

                    <div>
                        <p class="text-gray-600">Description:</p>
                        <p class="text-gray-800 whitespace-pre-wrap">
                            {{ $category->description ?? 'No description' }}
                        </p>
                    </div>


                    <div class="mt-8 border-t pt-6 flex flex-col space-y-4">
                        @can('categories.view.all')
                            <a href="{{ route('categories.index') }}"
                               class="inline-flex items-center mb-4 gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Categories
                            </a>
                        @endcan
                        <a href="{{ route('goods.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Goods
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
