<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Scoping functions if we want to limit searches
    public function scopeWhereRole($query, $roleName)
    {
        return $query->where('name', $roleName);
    }
}
