<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 sm:py-10">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-3 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->name }}</p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- NIP -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" required maxlength="20"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-mono focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        @error('nip') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select name="role" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                            <option value="guru" {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>