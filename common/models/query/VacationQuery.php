<?php

namespace common\models\query;

use common\models\User;
use common\models\Vacation;

/**
 * This is the ActiveQuery class for [[Vacation]].
 *
 * @see Vacation
 */
class VacationQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Vacation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Vacation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $managerId
     * @return $this
     */
    public function forManager($managerId) {
        $managerDepartmentId = User::findOne($managerId)->userProfile->department_id;
        if ($managerDepartmentId) {
            $this->joinWith('department');
            $this->andWhere(['department.id' => $managerDepartmentId]);
        }
        return $this;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function forUser($userId) {
        $this->andWhere(['user_id' => $userId]);
        return $this;
    }
}
