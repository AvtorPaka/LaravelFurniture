<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Shopping Cart
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('orders.make') }}">
                @csrf

                <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="address" value="Delivery Address *"/>
                            <x-text-input
                                id="address"
                                name="address"
                                value="{{ old('address') }}"
                                class="block mt-1 w-full"
                                placeholder="Country, City, House, Apartment"
                            />
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>


                        <div>
                            <x-input-label for="description" value="Order Notes (Optional)"/>
                            <textarea
                                id="description"
                                name="description"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                rows="3"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>
                    </div>


                    <div class="mt-6 flex flex-col items-center gap-4">
                        <div class="text-xl font-semibold text-center">
                            Total: ${{ number_format($totalPrice, 2) }}
                        </div>

                        <div class="text-center">
                            <x-primary-button type="submit" class="inline-flex px-8 py-3">
                                Checkout
                            </x-primary-button>
                        </div>
                    </div>

                </div>
            </form>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <table class="w-full border divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="bg-gray-50 px-6 py-3 text-left">
                                <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Product</span>
                            </th>
                            <th class="bg-gray-50 px-6 py-3 text-left">
                                <span
                                    class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Price</span>
                            </th>
                            <th class="bg-gray-50 px-6 py-3 text-left">
                                <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Quantity</span>
                            </th>
                            <th class="bg-gray-50 px-6 py-3 text-left">
                                <span
                                    class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Total</span>
                            </th>
                            <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                Actions
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                        @foreach($cartItems as $cartItem)
                            <tr class="bg-white">
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                    <a href="{{ route('goods.show', $cartItem->itemable) }}"
                                       class="hover:text-blue-600">
                                        {{ $cartItem->itemable->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                    ${{ number_format($cartItem->itemable->price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                    {{ $cartItem->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-indigo-600 whitespace-nowrap">
                                    ${{ number_format($cartItem->itemable->price * $cartItem->quantity, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('cartItem.remove-one', $cartItem) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <x-secondary-button type="submit" class="px-2">
                                                -
                                            </x-secondary-button>
                                        </form>

                                        <form action="{{ route('cartItem.remove-all', $cartItem) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">
                                                Remove
                                            </x-danger-button>
                                        </form>

                                        <form action="{{ route('cartItem.add-one', $cartItem) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <x-secondary-button type="submit" class="px-2">
                                                +
                                            </x-secondary-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
