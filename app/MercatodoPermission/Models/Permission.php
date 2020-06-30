<?php

namespace App\MercatodoPermission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'slug','description',
    ];
    public function roles()
    {
        return $this->belongsToMany('App\MercatodoPermission\Models\Role')->withTimesTamps();
    }
}
