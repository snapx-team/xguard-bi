<?php

namespace Xguard\BusinessIntelligence\Repositories;

use Xguard\BusinessIntelligence\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Collection;

class ErpUsersRepository
{
    public static function retrieve(int $erpUserId): ?UserResource
    {
        $erpUser = User::find($erpUserId);
        return $erpUser ? new UserResource($erpUser) : null;
    }

    public static function getSomeUsers($search): Collection
    {
        $erpUsers = User::where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere(User::raw('CONCAT(first_name, " ", last_name)'), 'like', "%{$search}%");
        })->orderBy('first_name')->take(10)->get();

        return $erpUsers->map(function ($erpUser) {
            return new UserResource($erpUser);
        });
    }

    public static function getAllUsers(): Collection
    {
        $erpUsers = User::orderBy('first_name')->take(10)->get();

        return $erpUsers->map(function ($erpUser) {
            return new UserResource($erpUser);
        });
    }
}
