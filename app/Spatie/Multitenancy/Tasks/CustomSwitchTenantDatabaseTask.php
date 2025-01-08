<?php

namespace App\Spatie\Multitenancy\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Exceptions\InvalidConfiguration;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class CustomSwitchTenantDatabaseTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(Tenant $tenant): void
    {
        $this->setTenantConnectionProperties($tenant);
    }

    public function forgetCurrent(): void
    {
        $this->setTenantConnectionProperties(null);
    }

    protected function setTenantConnectionProperties(?Tenant $tenant)
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();

        if ($tenantConnectionName === $this->landlordDatabaseConnectionName()) {
            throw InvalidConfiguration::tenantConnectionIsEmptyOrEqualsToLandlordConnection();
        }

        if (is_null(config("database.connections.{$tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }

        $configUpdates = [];

        if ($tenant) {
            $configUpdates = [
                'host' => $tenant->database_host,
                'database' => $tenant->database,
                'username' => $tenant->database_username,
                'password' => $tenant->database_password,
                'port' => $tenant->database_port,
            ];
        }

        foreach ($configUpdates as $key => $value) {
            config([
                "database.connections.{$tenantConnectionName}.{$key}" => $value,
            ]);
        }

        app('db')->extend($tenantConnectionName, function ($config, $name) use ($configUpdates) {
            foreach ($configUpdates as $key => $value) {
                $config[$key] = $value;
            }

            return app('db.factory')->make($config, $name);
        });

        DB::purge($tenantConnectionName);

        // Octane will have an old `db` instance in the Model::$resolver.
        Model::setConnectionResolver(app('db'));
    }
}
