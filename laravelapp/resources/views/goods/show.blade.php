<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Furniture: {{ $good->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Name:</p>
                            <p class="font-medium">{{ $good->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600">Category:</p>
                            <p class="font-medium">
                                <a href="{{ route('categories.show', $good->category) }}" class="hover:text-blue-600">
                                    {{ $good->category->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Price:</p>
                            <p class="font-medium text-lg text-indigo-600">
                                ${{ number_format($good->price, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600">Average Rating:</p>
                            <p class="font-medium text-lg text-gray-900">
                                {{ number_format($good->average_rating, 2) }} / 5.00
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-600">Description:</p>
                        <p class="text-gray-800 whitespace-pre-wrap">
                            {{ $good->description ?? 'No description' }}
                        </p>
                    </div>


                    @can('ratings.modify')
                        <div class="mt-6 pt-4 border-t">
                            <h3 class="text-lg font-medium mb-4">Rate product</h3>

                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($good->userRating)
                                <div class="flex items-center gap-4 mb-4">
                                    <p class="text-gray-600">Current rating:</p>
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full">
                                    {{ $good->userRating->rating }} / 5
                                </span>
                                </div>
                            @endif

                            <form action="{{ route('ratings.add-or-update', $good) }}" method="POST" class="space-y-4">
                                @csrf

                                <div class="flex items-center gap-2">
                                    <label for="rating" class="text-gray-600">Select rating:</label>
                                    <select name="rating" id="rating"
                                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ $good->userRating?->rating === $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="flex gap-2 mt-4 mb-4">
                                    <x-primary-button type="submit" class="px-4 py-2">
                                        {{ $good->userRating ? 'Update Rating' : 'Rate' }}
                                    </x-primary-button>

                                    @if($good->userRating)
                                        <a href="{{ route('ratings.destroy', $good->userRating) }}"
                                           onclick="event.preventDefault(); document.getElementById('delete-rating-form').submit();"
                                           class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Delete Rating
                                        </a>
                                    @endif
                                </div>
                            </form>

                            @if($good->userRating)
                                <form id="delete-rating-form"
                                      action="{{ route('ratings.destroy', $good->userRating) }}"
                                      method="POST"
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    @endcan

                    <div class="mt-8 border-t pt-6">
                        <a href="{{ route('goods.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
