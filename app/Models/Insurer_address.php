<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insurer_address extends Model
{
    protected $primaryKey = 'insurer_address_id';

    protected $fillable = [
        'insurersinsurer_id','street', 'suburb', 'region', 'country'
    ];

    public function insurer () : BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }
}
