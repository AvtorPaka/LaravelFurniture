<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Orders
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
                        <table class="w-full border divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">ID</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Status</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Created At</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Address</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Customer</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Total Price</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Items</span>
                                </th>
                                @can('order.modify')
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Actions</span>
                                </th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @foreach($orders as $order)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ $order->status }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ $order->address }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                        {{ $order->user->name ?? "Deleted" }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-indigo-600 whitespace-nowrap">
                                        ${{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full border divide-y divide-gray-200">
                                                <thead>
                                                <tr>
                                                    <th class="bg-gray-100 px-3 py-2 text-left text-xs text-gray-500">
                                                        Name
                                                    </th>
                                                    <th class="bg-gray-100 px-3 py-2 text-left text-xs text-gray-500">
                                                        Quantity
                                                    </th>
                                                    <th class="bg-gray-100 px-3 py-2 text-left text-xs text-gray-500">
                                                        Price
                                                    </th>
                                                    <th class="bg-gray-100 px-3 py-2 text-left text-xs text-gray-500">
                                                        Total Price
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td class="px-3 py-2 whitespace-nowrap">{{ $item->name }}</td>
                                                        <td class="px-3 py-2 whitespace-nowrap">{{ $item->quantity }}</td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            ${{ number_format($item->price, 2) }}</td>
                                                        <td class="px-3 py-2 whitespace-nowrap text-indigo-600">
                                                            ${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    @can('order.modify')
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-nowrap">
                                            <div class="flex flex-col items-center justify-center gap-2">


                                                <a href="{{ route('orders.edit', $order) }}"
                                                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('orders.destroy', $order) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this order?')"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit">
                                                        Delete
                                                    </x-danger-button>
                                                </form>

                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
