<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use App\Models\Menu;

class Kategori extends Model
{
  use SoftDeletes;

  protected $hidden = [
      'id_menu', 'id_parent', 'created_at', 'updated_at', 'deleted_at'
      // 'id', 'id_menu', 'id_parent', 'created_at', 'updated_at', 'deleted_at'
  ];

  protected $appends  = array('enc_id', 'enc_id_menu', 'enc_id_parent');

  public function getEncIdAttribute()
  {
      return encrypt($this->attributes['id']);
  }

  public function getEncIdMenuAttribute()
  {
      return encrypt($this->attributes['id_menu']);
  }

  public function getEncIdParentAttribute()
  {
      return encrypt($this->attributes['id_parent']);
  }

  public function menu()
  {
    return $this->hasOne(Menu::class, 'id', 'id_menu');
  }

  public function parent()
  {
    return $this->hasOne(self::class, 'id', 'id_parent');
  }
}
