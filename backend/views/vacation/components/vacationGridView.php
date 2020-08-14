<?php

use common\widgets\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\User;
use \kartik\widgets\DatePicker;

/**
 * @var yii\web\View $this
 * @var backend\models\search\VacationSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
?>

<?php echo GridView::widget([
    'layout' => "{items}\n{pager}",
    'options' => [
        'class' => ['gridview', 'table-responsive'],
    ],
    'tableOptions' => [
        'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'user.publicIdentity',
            'label' => Yii::t('backend', 'Employee')
        ],
        [
            'attribute' => 'dateRange',
            'format' => 'text',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'from_date',
                'attribute2' => 'to_date',
                'type' => DatePicker::TYPE_RANGE,
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'showMeridian' => true,
                ]
            ]),
            'label' => Yii::t('backend', 'Vacation dates')
        ],
        [
            'attribute' => 'is_approved',
            'value' => function ($model) {
                return $model->is_approved
                    ? Yii::t('backend', 'Yes')
                    : Yii::t('backend', 'No');
            },
            'filter' => [
                0 => Yii::t('backend', 'No'),
                1 => Yii::t('backend', 'Yes')
            ]
        ],

        [
            'class' => ActionColumn::class,
            'template' => '{view} {update} {delete} {approve}',
            'buttons' => [
                'approve' => function ($url, $model) {
                    return Html::button('<i class="fa-fw fas fa-check"></i>', [
                            'class' => "btn btn-success btn-xs js_approve_vacation",
                            'title' => Yii::t('backend', 'Approve'),
                            'data-confirm-other' => Yii::t('backend', 'Are you sure you want to approve the vacation?'),
                            'data-url' => Yii::$app->urlManagerBackend->createAbsoluteUrl(['/vacation/approve-vacation']),
                            'data-id' => $model->id
                        ]);
                },
            ],
            'visibleButtons' => [
                'approve' => function ($model) {
                    return Yii::$app->user->can(User::ROLE_MANAGER) && !$model->is_approved;
                },
                'update' => function ($model) {
                    return !$model->is_approved;
                },
                'delete' => function ($model) {
                    return !$model->is_approved;
                },
            ]
        ],
    ],
]);
