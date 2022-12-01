<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Insurer extends Model
{

    protected $primaryKey = 'insurer_id';

    protected $fillable = ['insurer_company_name', 'insurer_company_email', 'insurer_company_website', 'insurer_abbrv'];

    public function offers (): HasMany
    {
        return $this->hasMany(Offer::class, 'insurersinsurer_id', 'insurer_id')
            ->where('delete_status', '=', 'NOT DELETED')->orderBy('created_at', 'desc')->limit(50);
    }

    public function insurer_associates () : HasMany
    {
        return $this->hasMany(Insurer_associate::class, 'insurersinsurer_id', 'insurer_id')
            ->where('delete_status', '=', 'NOT DELETED');
    }

    public function insurer_address () : HasOne
    {
        return $this->hasOne(Insurer_address::class, 'insurersinsurer_id', 'insurer_id')
            ->where('delete_status', '=', 'NOT DELETED');
    }

     public function employee_insurer () : HasOne
     {
         return $this->hasOne(Employee_insurer::class);
     }

     public function remainders ():HasMany
     {
         return $this->hasMany(Remainder::class, 'insurersinsurer_id', 'insurer_id');
     }

    public function treaty_programs(): HasMany
    {
        return $this->hasMany(TreatyProgram::class, 'treaty_programstreaty_program_id', 'treaty_program_id')
        ->where('delete_status', '=', 'NOT DELETED');
    }

    public function treaties(): HasMany
    {
        return $this->hasMany(Treaty::class, 'insurersinsurer_id', 'insurer_id')
        ->where('delete_status', '=', 'NOT DELETED')
        ->orderBy('created_at', 'asc');
    }

    public function user () : MorphOne
    {
        return $this->morphOne('App\User', 'clientable');
    }
}
