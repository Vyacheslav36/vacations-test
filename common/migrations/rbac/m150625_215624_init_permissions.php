<?php

use common\models\User;
use common\rbac\Migration;

class m150625_215624_init_permissions extends Migration
{
    public function up()
    {
        $userRole = $this->auth->getRole(User::ROLE_USER);
        $managerRole = $this->auth->getRole(User::ROLE_MANAGER);
        $administratorRole = $this->auth->getRole(User::ROLE_ADMINISTRATOR);

        $loginToBackend = $this->auth->createPermission('loginToBackend');
        $this->auth->add($loginToBackend);

        $this->auth->addChild($managerRole, $loginToBackend);
        $this->auth->addChild($administratorRole, $loginToBackend);
        $this->auth->addChild($userRole, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission('loginToBackend'));
    }
}
