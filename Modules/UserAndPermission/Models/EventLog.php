<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $fillable = ['payload' , 'type', 'recorded_at'];
}
