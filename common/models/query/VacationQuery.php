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
    public function forManager($managerId)
    {
        $managerDepartmentId = User::findOne($managerId)->userProfile->department_id;
        if ($managerDepartmentId) {
            $this->andWhere(['department.id' => $managerDepartmentId]);
        }
        return $this;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function forUser($userId)
    {
        $this->andWhere(['vacation.user_id' => $userId]);
        return $this;
    }

    /**
     * @param $userId
     * @param $fromDate
     * @param $toDate
     * @return bool|int|string|null
     */
    public static function getNumberOfIntersectingVacations($userId, $fromDate, $toDate)
    {
        $userDepartmentId = User::findOne($userId)->userProfile->department_id;
        if ($userDepartmentId) {
            $query = Vacation::find()
                ->joinWith('department');

            $query->where("((vacation.from_date between $fromDate and $toDate)
               or (vacation.to_date between $fromDate and $toDate)
               or (vacation.from_date < $fromDate and $toDate < vacation.to_date))");

            $query->andWhere(['department.id' => $userDepartmentId]);

            return $query->count();
        }
        return null;
    }

    /**
     * @param $userId
     * @return array|Vacation[]
     */
    public static function getVacationsForEmployeeInCurrentYear($userId)
    {
        $firstDayInYear = strtotime('first day of January this year');
        $lastDayInYear = strtotime('last day of December this year +23 hour 59 minute 59 second');

        $query = Vacation::find()
            ->where("vacation.user_id = $userId and ((vacation.from_date between $firstDayInYear and $lastDayInYear)
                or (vacation.to_date between $firstDayInYear and $lastDayInYear))");

        return $query->all();
    }
}
