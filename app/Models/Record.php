<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
}
