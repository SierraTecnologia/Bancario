<?php

namespace Bancario\Modules\Graph\Resources;

use App\Contants\Tables;
use Population\Manipule\Entities\UserEntity;
use Illuminate\Database\Eloquent\Builder;
use Muleta\Modules\Eloquents\Displays\BuilderAbstract;

/**
 * Class GraphBuilder.
 *
 * @package Population\Manipule\Builders
 */
class GraphBuilder extends BuilderAbstract
{
    // /**
    //  * @var string
    //  */
    // private $rolesTable = Tables::TABLE_ROLES;

    // /**
    //  * @return $this
    //  */
    // public function whereNameCustomer()
    // {
    //     return $this->where("{$this->rolesTable}.name", UserEntity::ROLE_CUSTOMER);
    // }

    // /**
    //  * @return $this
    //  */
    // public function whereNameAdministrator()
    // {
    //     return $this->where("{$this->rolesTable}.name", UserEntity::ROLE_ADMINISTRATOR);
    // }
}
