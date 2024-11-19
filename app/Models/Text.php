<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kategori;

class Text extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = ['deleted_at'];

    protected $appends  = array('id');

    public function getIdAttribute()
    {
        return encrypt($this->attributes['id']);
    }

    public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori');
    }
}
