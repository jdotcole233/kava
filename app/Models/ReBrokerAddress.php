<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReBrokerAddress extends Model
{
    protected $primaryKey = "re_broker_address_id";
    protected $fillable = ['re_brokersre_broker_id', 'street', 'city', 'region', 'country', 're_primary_phone', 're_secondary_phone', 'delete_status'];

    public function re_broker () : BelongsTo
    {
        return $this->belongsTo(ReBroker::class, 're_broker_id', 're_brokersre_broker_id')->where('delete_status', '=', 'NOT DELETED');
    }
}
