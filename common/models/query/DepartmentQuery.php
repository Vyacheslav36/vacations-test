<?php

namespace common\models\query;

use common\models\Department;

/**
 * This is the ActiveQuery class for [[\common\models\Department]].
 *
 * @see \common\models\Department
 */
class DepartmentQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Department[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Department|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
