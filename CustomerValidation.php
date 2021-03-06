<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation;

use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

/**
 * Class CustomerValidation
 * @package CustomerValidation
 */
class CustomerValidation extends BaseModule
{
    const MESSAGE_DOMAIN = "customervalidation";
    const DOMAIN_NAME = "customervalidation";
    const ROUTER = "router.customervalidation";

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);

        $database->insertSql(null, [__DIR__ . "/Config/create.sql", __DIR__ . "/Config/insert.sql"]);
    }

    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
    {
        // If we have to delete module data, remove the media directory.
        if ($deleteModuleData) {
            $database = new Database($con);

            $database->insertSql(null, array(__DIR__ . '/Config/destroy.sql'));
        }
    }
    
    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {

        $database = new Database($con);

        $database->insertSql(null, [__DIR__ . "/Config/update.sql"]);
    }
}
