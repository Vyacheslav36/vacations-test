<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */
?>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'summary' => '',
    'columns' => [
        [
            'attribute' => 'user.publicIdentity',
            'label' => Yii::t('backend', 'Employee')
        ],
        [
            'attribute' => 'dateRange',
            'format' => 'text',
            'label' => Yii::t('backend', 'Vacation dates')
        ],
        [
            'attribute' => 'is_approved',
            'value' => function ($model) {
                return $model->is_approved
                    ? Yii::t('backend', 'Approved')
                    : Yii::t('backend', 'Not approved');
            },
        ],
    ]
]);
