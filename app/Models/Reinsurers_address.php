<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reinsurers_address extends Model
{

    protected $primaryKey = 'reinsurer_address_id';

    protected $fillable = [
        'reinsurersreinsurer_id','street', 'suburb', 'region', 'country'
    ];

    public function reinsurer () : BelongsTo
    {
        return $this->belongsTo(Reinsurer::class);
    }
}
