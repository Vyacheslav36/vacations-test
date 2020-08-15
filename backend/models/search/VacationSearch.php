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
        $query = Vacation::find()
            ->joinWith('department');

        if (!\Yii::$app->user->can(User::ROLE_ADMINISTRATOR)) {
            if (\Yii::$app->user->can(User::ROLE_MANAGER)) {
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
            $query->andFilterWhere([
                "or",
                "(vacation.from_date between $fromDate and $toDate) or (vacation.to_date between $fromDate and $toDate)",
                "(vacation.from_date <= $fromDate and $toDate >= vacation.to_date)"
            ]);
        } else {
            if ($fromDate) {
                $query->andFilterWhere(['>=', 'vacation.from_date', $fromDate]);
            }
            if ($toDate) {
                $query->andFilterWhere(['<=', 'vacation.to_date', $toDate]);
            }
        }

        $query->andFilterWhere([
            'vacation.id' => $this->id,
            'vacation.user_id' => $this->user_id,
            'vacation.is_approved' => $this->is_approved,
            'vacation.created_at' => $this->created_at,
            'vacation.updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
