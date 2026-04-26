<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen User</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola akun superadmin dan guru</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah User
                </a>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-emerald-100 dark:bg-emerald-900/40 border border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900/40 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-300 rounded-xl text-sm">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm
                                        {{ $user->isSuperAdmin() ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</p>
                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">(Anda)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-mono">
                                {{ $user->nip ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    {{ $user->isSuperAdmin()
                                        ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'
                                        : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' }}">
                                    {{ $user->isSuperAdmin() ? 'Superadmin' : 'Guru' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Reset Password -->
                                    <button onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-900/50 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                        </svg>
                                        Reset PW
                                    </button>

                                    <!-- Hapus -->
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                          onsubmit="return confirm('Hapus user {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500 text-sm">
                                Belum ada user. Klik "Tambah User" untuk membuat akun baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div id="resetModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Reset Password</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Reset password untuk: <span id="resetUserName" class="font-semibold text-gray-700 dark:text-gray-200"></span></p>

            <form id="resetForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                    <input type="password" name="password" required minlength="8"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Minimal 8 karakter">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required minlength="8"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Ulangi password baru">
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeResetModal()"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow transition">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResetModal(userId, userName) {
            document.getElementById('resetUserName').textContent = userName;
            document.getElementById('resetForm').action = `/admin/users/${userId}/reset-password`;
            const modal = document.getElementById('resetModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeResetModal() {
            const modal = document.getElementById('resetModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>