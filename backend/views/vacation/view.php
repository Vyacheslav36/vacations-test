<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Vacation $model
 */

$this->title = Yii::t('backend', 'Vacation view');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Vacations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacation-view">
    <div class="card">
        <div class="card-header">
            <?php $disabledClass = $model->is_approved ? 'disabled' : '' ?>
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => "btn btn-primary $disabledClass"]) ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => "btn btn-danger $disabledClass",
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user.publicIdentity',
                        'format' => 'text',
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
                                ? Yii::t('backend', 'Yes')
                                : Yii::t('backend', 'No');
                        },
                        'filter' => [
                            0 => Yii::t('backend', 'No'),
                            1 => Yii::t('backend', 'Yes')
                        ]
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'datetime',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
