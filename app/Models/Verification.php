<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    //

      protected $fillable = [
        'uses',
        'type',
        'code',
        'expired_at',

    ];

    public function verificable()
    {
        return $this->morphTo();
    }

}
