<?php

use backend\models\UserForm;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\DepartmentSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">
    <div class="card">
        <div class="card-header">
            <?php if (Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR)): ?>
                <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                    'modelClass' => Yii::t('backend', 'Department'),
                ]), ['create'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        'attribute' => 'name',
                        'label' => Yii::t('backend', 'Department')
                    ],
                    [
                        'attribute' => 'manager_id',
                        'value' => function ($model) {
                            return $model->manager->publicIdentity;
                        },
                        'filter' => UserForm::getListForSelect(true),
                        'label' => Yii::t('backend', 'Head of department')
                    ],
                    [
                        'format' => 'html',
                        'value' => function ($model) {
                            $maxNumberOfVacationDays = $model->attributeLabels()['maxNumberOfVacationDays'] . ': ' . $model->maxNumberOfVacationDays;
                            $maxNumberOfEmployeesOnVacation = $model->attributeLabels()['maxNumberOfEmployeesOnVacation'] . ': ' . $model->maxNumberOfEmployeesOnVacation;
                            return join('<br/>', [$maxNumberOfVacationDays, $maxNumberOfEmployeesOnVacation]);
                        },
                        'label' => Yii::t('backend', 'Settings'),
                    ],

                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                        'visibleButtons' => [
                            'delete' => function ($model) {
                                return Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR);
                            },
                        ]
                    ],
                ],
            ]); ?>

        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
