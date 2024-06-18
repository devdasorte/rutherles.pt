<?php
namespace App\Jobs;

use App\Facades\UtilityFacades;
use Stancl\Tenancy\Jobs\CreateDatabase as VendorCreateDatabase;
use Stancl\Tenancy\Database\DatabaseManager;
use Stancl\Tenancy\Events\CreatingDatabase;
use Stancl\Tenancy\Events\DatabaseCreated;


class CreateDatabase extends VendorCreateDatabase
{
    public function handle(DatabaseManager $databaseManager)
    {
        if(UtilityFacades::getsettings('database_permission') == 1)
        {
            event(new CreatingDatabase($this->tenant));

            // Terminate execution of this job & other jobs in the pipeline
            if ($this->tenant->getInternal('create_database') === false) {
                return false;
            }

            $databaseManager->ensureTenantCanBeCreated($this->tenant);
            $this->tenant->database()->makeCredentials();
            $this->tenant->database()->manager()->createDatabase($this->tenant);

            event(new DatabaseCreated($this->tenant));
    }
}
}
