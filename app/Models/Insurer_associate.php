<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insurer_associate extends Model
{
    protected $primaryKey = 'insurer_associate_id';

    protected $fillable = ['insurersinsurer_id','assoc_first_name', 'assoc_last_name', 'assoc_primary_phonenumber',
        'assoc_secondary_phonenumber', 'assoc_email', 'position'];

    public function insurer () : BelongsTo
    {
        return $this->belongsTo(Insurer::class);
    }
}
