<?php

namespace backend\models;

use Yii;
use common\models\Department;
use common\models\User;

class DepartmentForm extends Department
{
    /**
     * @return array
     */
    public static function getListForSelect()
    {
        $result = [];
        $departments = Yii::$app->user->can(User::ROLE_ADMINISTRATOR)
            ? self::find()->all()
            : self::find()->forManager(Yii::$app->user->id)->all();

        foreach ($departments as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }
}
