<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reinsurer_representative extends Model
{
    protected $primaryKey = 'reinsurer_representative_id';

    protected $fillable = ['reinsurersreinsurer_id','rep_first_name', 'rep_last_name', 'rep_primary_phonenumber',
        'rep_secondary_phonenumber', 'rep_email', 'position'];

    public function offer_to_associate () : HasMany
    {
        return $this->hasMany(Reinsurer_representative::class);
    }

    public function reinsurer () : BelongsTo
    {
        return $this->belongsTo(Reinsurer::class, "reinsurersreinsurer_id");
    }

}
