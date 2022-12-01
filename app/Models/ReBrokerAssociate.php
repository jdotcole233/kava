<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReBrokerAssociate extends Model
{
    protected $primaryKey = "re_broker_associate_id";
    protected $fillable = [
        're_brokersre_broker_id', 're_broker_assoc_first_name', 're_broker_assoc_first_name', 're_broker_assoc_last_name',
     're_broker_assoc_primary_phone', 're_broker_assoc_secondary_phone', 're_broker_assoc_position', 're_broker_assoc_email', 'delete_status'];

     public function re_broker () : BelongsTo
     {
         return $this->belongsTo(ReBroker::class, 're_brokersre_broker_id', 're_broker_id')->where('delete_status', '=', 'NOT DELETED');
     }
}
