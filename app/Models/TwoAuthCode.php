<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['expires_at', 'code', 'user_id'])]
class TwoAuthCode extends Model
{
    use HasUuids;

    protected function casts(): array 
    {
        return [
            'expires_at' => 'datetime',
            'user_id' => 'string',
            'code' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
