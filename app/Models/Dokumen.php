<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pejabat;
use App\Models\Kategori;
use App\Models\Jenis_dokumen;

class Dokumen extends Model
{
  use SoftDeletes;

  protected $hidden = [
        'id', 'id_pejabat', 'id_kategori', 'id_jenis_dokumen', 'file', 'created_at', 'updated_at', 'deleted_at'
    ];

  protected $appends  = array('enc_id', 'enc_file');

  public function getEncIdAttribute()
  {
      return encrypt($this->attributes['id']);
  }

  public function getEncFIleAttribute($value)
  {
      return encrypt($this->attributes['file']);
  }

  public function pejabat()
  {
    return $this->hasOne(Pejabat::class, 'id', 'id_pejabat');
  }

  public function kategori()
  {
    return $this->hasOne(Kategori::class, 'id', 'id_kategori');

  }

  public function jenis_dokumen()
  {
    return $this->hasOne(Jenis_dokumen::class, 'id', 'id_jenis_dokumen');

  }

}
