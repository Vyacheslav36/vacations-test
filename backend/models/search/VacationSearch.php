<?php

namespace backend\models\search;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacation;

/**
 * VacationSearch represents the model behind the search form about `common\models\Vacation`.
 */
class VacationSearch extends Vacation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_approved', 'created_at', 'updated_at'], 'integer'],
            [['from_date', 'to_date'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Vacation::find();

        if (!\Yii::$app->user->can(User::ROLE_ADMINISTRATOR)) {
            if (!\Yii::$app->user->can(User::ROLE_MANAGER)) {
                $query->forManager(\Yii::$app->user->id);
            } else {
                $query->forUser(\Yii::$app->user->id);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $fromDate = strtotime($this->from_date);
        $toDate = strtotime($this->to_date);

        if ($fromDate && $toDate) {
            $query->andFilterWhere(['between', 'from_date', $fromDate, $toDate]);
            $query->orFilterWhere(['between', 'to_date', $fromDate, $toDate]);
            $query->orFilterWhere(['<=', 'from_date', "$fromDate and to_date >= $toDate"]);
        } else {
            if ($fromDate) {
                $query->andFilterWhere(['>=', 'from_date', $fromDate]);
            } if ($toDate) {
                $query->andFilterWhere(['<=', 'to_date', $toDate]);
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
