<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $fillable = ['username', 'password', 'nama_bioskop', 'role'];

    public $timestamps = false; // karena tabel admin tidak punya kolom created_at dan updated_at

    protected $hidden = ['password'];
}
