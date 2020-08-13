<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use common\models\query\DepartmentQuery;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property int $manager_id
 * @property string $name
 * @property string|null $settings
 *
 * @property UserProfile[] $userProfiles
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['settings'], 'safe'],
            [['name', 'maxNumberOfVacationDays', 'maxNumberOfEmployeesOnVacation'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'string', 'max' => 255],
            [['manager_id'], 'integer'],
        ];
    }

    public static function getDefaultValue($attribute)
    {
        $settings = [
            'maxNumberOfVacationDays' => 30,
            'maxNumberOfEmployeesOnVacation' => 2,
        ];
        return isset($settings[$attribute]) ? $settings[$attribute] : 0;
    }

    /**
     * @return int|string
     */
    public function getMaxNumberOfVacationDays()
    {
        return $this->settings && isset($this->settings['maxNumberOfVacationDays'])
            ? $this->settings['maxNumberOfVacationDays']
            : self::getDefaultValue('maxNumberOfVacationDays');
    }

    /**
     * @return bool
     */
    public function getMaxNumberOfEmployeesOnVacation()
    {
        return $this->settings && isset($this->settings['maxNumberOfEmployeesOnVacation'])
            ? $this->settings['maxNumberOfEmployeesOnVacation']
            : self::getDefaultValue('maxNumberOfEmployeesOnVacation');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'manager_id' => Yii::t('backend', 'Manager ID'),
            'settings' => Yii::t('backend', 'Settings'),
            'maxNumberOfVacationDays' => Yii::t('backend', 'Maximum number of vacation days'),
            'maxNumberOfEmployeesOnVacation' => Yii::t('backend', 'Maximum number of employees on vacation'),
        ];
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::class, ['department_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    /**
     * {@inheritdoc}
     * @return DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }
}
