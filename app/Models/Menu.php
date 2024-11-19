<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use App\Models\Kategori;


class Menu extends Model
{
  use SoftDeletes;

  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
  ];

  protected $appends  = array('enc_id');

  public function getEncIdAttribute()
  {
      return encrypt($this->attributes['id']);
  }

  public function kategori()
  {
      return $this->hasMany(Kategori::class, 'id_menu', 'id');
  }

}
