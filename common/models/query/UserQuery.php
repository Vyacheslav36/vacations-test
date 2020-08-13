<?php

namespace common\models\query;

use common\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package common\models\query
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @param int $managerId
     * @return $this
     */
    public function forManager($managerId) {
        $managerDepartmentId = User::findOne($managerId)->userProfile->department_id;
        if ($managerDepartmentId) {
            $this->joinWith('userProfile');
            $this->andWhere(['user_profile.department_id' => $managerDepartmentId]);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function onlyManagers() {
        $managerRole = User::ROLE_MANAGER;
        $this->where("user.id in (select user_id from rbac_auth_assignment where item_name = '$managerRole')");
        return $this;
    }
}