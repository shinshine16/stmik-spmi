<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LogActivity extends Model
{
    protected $table = 'log_activity';
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
