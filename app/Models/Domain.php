<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function(Domain $domain) {
            $domain->records()->delete();
        });
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'domain_id');
    }
}
