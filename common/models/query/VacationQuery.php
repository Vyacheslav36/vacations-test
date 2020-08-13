<?php

namespace common\models\query;

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
}
