<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public const TYPE_MESSAGE  = 'message';
    public const TYPE_ESTIMATE = 'estimate';
}
