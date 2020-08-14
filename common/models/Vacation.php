<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use common\models\query\UserQuery;
use common\models\query\VacationQuery;

/**
 * This is the model class for table "vacation".
 *
 * @property int $id
 * @property int $user_id
 * @property int $from_date
 * @property int $to_date
 * @property bool $is_approved
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 * @property UserProfile $userProfile
 * @property Department $department
 */
class Vacation extends \yii\db\ActiveRecord
{
    public $additionalValidation = true;
    protected $_dateRange;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ]
        ];
    }

    public function getDateRange()
    {
        return $this->from_date && $this->to_date
            ? \Yii::$app->formatter->asDate($this->from_date, "php:d-m-Y") . ' - ' . \Yii::$app->formatter->asDate($this->to_date, "php:d-m-Y")
            : null;
    }

    public function setDateRange($value)
    {
        $this->_dateRange = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacation';
    }

    /**
     * The function counts the number of days between two dates
     *
     * @param int $d1
     * @param int $d2
     *
     * @return number amount of days
     */
    public static function countDaysBetweenDates($d1, $d2)
    {
        $seconds = abs($d2 - $d1);

        return round($seconds / 86400);
    }

    /**
     * Function for checking if the possible number of vacation days per year is exceeded
     *
     * @param int $userId
     * @param int $fromDate
     * @param int $toDate
     * @param int $maxNumberOfVacationDays
     *
     * @return bool
     */
    private function checkForNumberOfVacationDays(int $userId, int $fromDate, int $toDate, $maxNumberOfVacationDays = 0)
    {
        $vacationsForEmployeeInCurrentYear = VacationQuery::getVacationsForEmployeeInCurrentYear($userId);
        $numberOfVacationDays = $this->countDaysBetweenDates($fromDate, $toDate);
        foreach ($vacationsForEmployeeInCurrentYear as $vacation) {
            $numberOfVacationDays += $this->countDaysBetweenDates($vacation->from_date, $vacation->to_date);
        }
        if ($numberOfVacationDays > $maxNumberOfVacationDays) {
            return false;
        }
        return true;
    }

    public function validateVacationDate($attribute)
    {
        if ($this->additionalValidation) {
            $fromDate = $this->from_date;
            $toDate = $this->to_date;
            $user = User::findOne($this->user_id);
            if ($user && $user->userProfile->department) {
                $maxNumberOfEmployeesOnVacation = $user->userProfile->department->maxNumberOfEmployeesOnVacation;
                $maxNumberOfVacationDays = $user->userProfile->department->maxNumberOfVacationDays;
                if (VacationQuery::getNumberOfIntersectingVacations($user->id, $fromDate, $toDate) >= $maxNumberOfEmployeesOnVacation) {
                    $this->addError('dateRange', Yii::t('backend', 'Your dates overlap with more than {number} employees', [
                        'number' => $maxNumberOfEmployeesOnVacation
                    ]));
                }

                if (!$this->checkForNumberOfVacationDays($user->id, $fromDate, $toDate, $maxNumberOfVacationDays)) {
                    $this->addError('dateRange', Yii::t('backend', 'You have exceeded the possible number of vacation days per year: {number}', [
                        'number' => $maxNumberOfVacationDays
                    ]));
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'from_date', 'to_date'], 'required'],
            [['from_date'], 'filter', 'filter' => function ($value) {
                return is_int($value) ? $value : strtotime($value);
            }],
            [['to_date'], 'filter', 'filter' => function ($value) {
                return is_int($value) ? $value : strtotime($value . '+23 hour 59 minute 59 second');
            }],
            [['from_date', 'to_date'], 'validateVacationDate'],
            ['is_approved', 'boolean'],
            [['user_id', 'created_at', 'updated_at', 'from_date', 'to_date'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'user_id' => Yii::t('backend', 'Employee'),
            'from_date' => Yii::t('backend', 'Vacation start'),
            'to_date' => Yii::t('backend', 'Vacation end'),
            'is_approved' => Yii::t('backend', 'Is Approved'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id'])
            ->via('user');
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id'])
            ->via('userProfile');
    }

    /**
     * {@inheritdoc}
     * @return VacationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VacationQuery(get_called_class());
    }
}
