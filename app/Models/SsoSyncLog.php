<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsoSyncLog extends Model
{
    protected $fillable = ['user_id', 'status', 'error_message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
