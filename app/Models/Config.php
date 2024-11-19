<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
  use SoftDeletes;

  protected $hidden = [
        'id','created_at', 'updated_at', 'deleted_at'
    ];
}
