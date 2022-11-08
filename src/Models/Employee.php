<?php

namespace Xguard\BusinessIntelligence\Models;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'bi_employees';
    protected $guarded = [];

    const TABLE_NAME = 'bi_employees';
    const ID = 'id';
    const USER_ID = 'user_id';
    const ROLE = 'role';
    const USER_RELATION_NAME = 'user';
    const DELETED = 'DELETED';
    const USER = 'USER';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(function ($user) {
            $user->first_name = self::DELETED;
            $user->last_name = self::USER;
        });
    }
}
