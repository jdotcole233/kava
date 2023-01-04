<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientActivity extends Model
{
    use HasFactory;
    protected $primaryKey = "client_activity_id";
    protected $fillable = [
        'usersuser_id', 'resource_accessed', 'ip_address',
        'device_type', 'country_code', 'city', 'region',
        'country', 'lat', 'lng'
    ];

    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class, 'usersuser_id', 'id');
    }
}
