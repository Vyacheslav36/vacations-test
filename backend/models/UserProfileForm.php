<?php

namespace backend\models;

use Yii;
use common\models\UserProfile;

class UserProfileForm extends UserProfile
{
    /**
     * @return array
     */
    public static function getGenderStatuses()
    {
        return [
            self::GENDER_MALE => Yii::t('backend', 'Male'),
            self::GENDER_FEMALE => Yii::t('backend', 'Female'),
        ];
    }
}
