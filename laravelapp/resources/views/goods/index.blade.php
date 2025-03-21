<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Furniture Goods
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">

                    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">

                        @can('goods.create')
                            <a href="{{ route('goods.create') }}"
                               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                Add new good
                            </a>
                        @endcan

                        <form method="GET" action="{{ route('goods.index') }}"
                              class="flex flex-col gap-2 w-full md:w-auto md:flex-row md:items-center md:gap-3">
                            <div class="flex-1">
                                <input type="text" name="name" placeholder="Search by name"
                                       value="{{ request('name') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" placeholder="Min $"
                                       value="{{ request('min_price') }}" step="1"
                                       class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="text-gray-400">–</span>
                                <input type="number" name="max_price" placeholder="Max $"
                                       value="{{ request('max_price') }}" step="1"
                                       class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <select name="category"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 md:w-48">
                                <option value="">All Categories</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="flex gap-2">
                                <button type="submit"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white shadow-sm transition-colors duration-150 ease-in-out hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Apply
                                </button>
                                <a href="{{ route('goods.index') }}"
                                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="min-w-full align-middle">
                        <table class="w-full border divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Name</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Category</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Price</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Rating</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Description</span>
                                </th>
                                <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                    @auth()
                                        Actions
                                    @endauth
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @foreach($goods as $good)
                                <tr class="bg-white">
                                <tr class="bg-white">
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('goods.show', $good) }}" class="hover:text-blue-600">
                                            {{ $good->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('categories.show', $good->category) }}"
                                           class="hover:text-blue-600">
                                            {{ $good->category->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-indigo-600 whitespace-nowrap">
                                        ${{ number_format($good->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ number_format($good->average_rating, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        @if($good->description)
                                            @if(mb_strlen($good->description) > 50)
                                                {{ mb_substr($good->description, 0, 50) . '...' }}
                                            @else
                                                {{ $good->description }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">


                                            @can('goods.update')
                                                <a href="{{ route('goods.edit', $good) }}?{{ http_build_query(request()->query()) }}"
                                                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('cart.update')
                                            <form
                                                action="{{ route('goods.add-to-cart', $good) }}?{{ http_build_query(request()->query()) }}"
                                                method="POST">
                                                @csrf
                                                <x-primary-button type="submit">
                                                    Add to cart
                                                </x-primary-button>
                                            </form>
                                            @endcan

                                            @can('goods.delete')
                                                <form
                                                    action="{{ route('goods.destroy', $good) }}?{{ http_build_query(request()->query()) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                    @csrf
                                                    @method("DELETE")
                                                    <x-danger-button type="submit">
                                                        Delete
                                                    </x-danger-button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6">
                            {{ $goods->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
