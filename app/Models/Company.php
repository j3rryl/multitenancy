<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Company extends Model
{
    use UsesLandlordConnection;

    protected $guarded = [];

    public function users(){
        return $this->hasMany(User::class, 'company_id');
    }
}
