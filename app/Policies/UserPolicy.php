<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Menentukan apakah user boleh melihat statistik keuangan/omzet.
     * Dipakai di dashboard.blade.php: @can('viewAny', App\Models\User::class)
     * Hanya Admin yang boleh melihat, Kasir tidak.
     */
    public function viewAny(User $user)
    {
        return $user->role->name === 'admin';
    }
}
