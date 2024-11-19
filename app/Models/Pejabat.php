<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Pejabat extends Model
{
  use SoftDeletes;

  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
      // 'id', 'created_at', 'updated_at', 'deleted_at'
  ];

  protected $appends  = array('enc_id');

  public function getEncIdAttribute()
  {
      return encrypt($this->attributes['id']);
  }
}
