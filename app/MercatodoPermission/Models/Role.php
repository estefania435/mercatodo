<?php

namespace App\MercatodoPermission\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug','description', 'full-access',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimesTamps();
    }
    public function permissions()
    {
        return $this->belongsToMany('App\MercatodoPermission\Models\Permission')->withTimesTamps();
    }
}
