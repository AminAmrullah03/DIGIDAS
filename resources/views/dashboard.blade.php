<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="/absen" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" aria-hidden="true"><path d="M11.7 2.3a1 1 0 0 1 1.6 0l8 10A1 1 0 0 1 20.5 14H16v7a1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1v-7H2.5a1 1 0 0 1-.8-1.7l8-10Z"/></svg>
                            <span>Buka Halaman Absensi</span>
                        </a>
                        <a href="/rekap" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" aria-hidden="true"><path d="M3 5a2 2 0 0 1 2-2h2V1h2v2h4V1h2v2h2a2 2 0 0 1 2 2v2H3V5Zm0 4h18v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Zm4 3v2h6v-2H7Zm0 4v2h10v-2H7Z"/></svg>
                            <span>Lihat Rekap Absensi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>
