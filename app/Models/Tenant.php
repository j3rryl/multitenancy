<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use UsesLandlordConnection;

    // Add any custom fields or methods specific to your setup
    protected $fillable = [
        'name',       // Name of the tenant (e.g., institution name)
        'database',   // The database name for the tenant
    ];

    /**
     * Custom method to return the database connection name for this tenant.
     */
    public function getDatabaseConnectionName()
    {
        return 'tenant';
    }
}
