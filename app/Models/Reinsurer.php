<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Reinsurer extends Model
{

    protected $primaryKey = 'reinsurer_id';

    protected $fillable = ['re_company_name', 're_company_email', 're_company_website', 're_abbrv'];


    public function offers_participant () : HasMany
    {
        return $this->hasMany(Offer_participant::class, 'reinsurersreinsurer_id', 'reinsurer_id')
            ->where('delete_status', '=', 'NOT DELETED');

    }



    public function offer_claim_participants () : HasMany
    {
        return $this->hasMany(Offer_claim_participant::class)->where('delete_status','=', 'NOT DELETED');
    }

    public function offer_extra_charges () : HasMany
    {
        return $this->hasMany(Offer_extra_charge::class)->where('delete_status','=', 'NOT DELETED');
    }

    public function offer_to_associate () : BelongsTo
    {
        return $this->belongsTo(Offer_to_associate::class)->where('delete_status','=', 'NOT DELETED');
    }

    public function offer_participant () : HasMany
    {
        return $this->hasMany(Offer_participant::class)->where('delete_status','=', 'NOT DELETED');
    }

    public function offer_participant_payment () : HasMany
    {
        return $this->hasMany(Offer_participant_payment::class)
            ->where('delete_status','=', 'NOT DELETED');
    }

    public function reinsurer_address () : HasOne
    {
        return $this->hasOne(Reinsurers_address::class, 'reinsurersreinsurer_id')
            ->where('delete_status','=', 'NOT DELETED');
    }

    public function reinsurer_representatives () : HasMany
    {
        return $this->hasMany(Reinsurer_representative::class, 'reinsurersreinsurer_id')
            ->where('delete_status','=', 'NOT DELETED');
    }

    public function employee_reinsurer () : HasOne
    {
        return $this->hasOne(Employee_reinsurer::class)
            ->where('delete_status','=', 'NOT DELETED');
    }


    public function offer_retrocedents () : HasMany {
        // return  Offer_retrocedent::where('reinsurersreinsurer_id', $this->reinsurer_id)
        // ->where('delete_status', '=', 'NOT DELETED')->get();

        return $this->hasMany(Offer_retrocedent::class, 'reinsurersreinsurer_id', 'reinsurer_id')
        ->where('delete_status', '=', 'NOT DELETED');
    }

    public function treaty_participations(): HasMany
    {
        return $this->hasMany(TreatyParticipation::class, 'reinsurersreinsurer_id', 'reinsurer_id')
        ->where('delete_status', '=', 'NOT DELETED')->distinct('treatiestreaty_id');
    }

    public function treaty_participations_ ()  {
        info($this->reinsurer_id);
        return TreatyParticipation::where('reinsurersreinsurer_id', $this->reinsurer_id)->where('delete_status', '=', 'NOT DELETED')
        ->get()->unique('treatiestreaty_id');
    }

    public function user() : MorphOne
    {
        return $this->morphOne('App\User', 'clientable');
    }
}
