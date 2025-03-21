<x-app-layout>
    <div class="flex min-h-screen flex-col items-center justify-center bg-white py-12">
        <div class="max-w-3xl text-center">
            <div class="mb-4 flex justify-center">
                <x-application-logo class="h-20 w-auto text-gray-900" />
            </div>

            <h1 class="text-xl font-semibold leading-tight text-gray-800 sm:text-7xl md:text-8xl">
                LARAVEL FURNITURE
            </h1>

            <div class="mt-12 flex justify-center">
                <a href="{{ route('goods.index') }}"
                   class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-6 py-3 text-sm font-semibold uppercase tracking-widest text-white shadow-sm transition-colors duration-150 ease-in-out hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:px-8 sm:py-4 sm:text-base">
                    Explore Catalog
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
