<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class File extends Model
{
  use SoftDeletes;

  protected $hidden = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

  protected $appends  = array('enc_id', 'enc_file');

  public function getEncIdAttribute()
  {
      return encrypt($this->attributes['id']);
  }

  public function getEncFIleAttribute($value)
  {
      return encrypt($this->attributes['file_name']);
  }
}
