<?php

namespace App\Models;

use App\ReBrokerAddress;
use App\ReBrokerAssociate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReinsuranceBroker extends Model
{
    use HasFactory;


    protected $primaryKey = "re_broker_id";
    protected $fillable = ['re_broker_name', 're_broker_email', 're_broker_abbrv', 're_broker_website', 'delete_status'];

    public function re_broker_address () : HasOne
    {
        return $this->hasOne(ReBrokerAddress::class, 're_brokersre_broker_id', 're_broker_id')->where('delete_status', '=', 'NOT DELETED');
    }

    public function re_broker_associates (): HasMany
    {
        return $this->hasMany(ReBrokerAssociate::class, 're_brokersre_broker_id', 're_broker_id')
            ->where('delete_status', '=', 'NOT DELETED')->orderBy('created_at', 'DESC');
    }

    public function re_broker_participations (): HasMany
    {
        return $this->hasMany(ReBrokerTreatiesParticipation::class, 're_brokersre_broker_id', 're_broker_id')
            ->where('delete_status', '=', 'NOT DELETED')->orderBy('created_at', 'DESC');
    }
}
