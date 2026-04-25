<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher;

class NipUserProvider extends EloquentUserProvider
{
    public function __construct(Hasher $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * Retrieve a user by the given credentials (NIP + password).
     * Override default yang mencari berdasarkan 'email'.
     */
    public function retrieveByCredentials(array $credentials): ?User
    {
        // Hapus 'password' dari credentials sebelum query
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if ($key === 'password') continue;
            $query->where($key, $value);
        }

        return $query->first();
    }
}