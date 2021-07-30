<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserIp extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\UserAndPermission\Database\factories\UserIpFactory::new();
    }
}
