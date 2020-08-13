<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Vacation $model
 * @var kartik\form\ActiveForm $form
 */
?>

<div class="vacation-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->field($model, 'dateRange', [
                'addon' => ['prepend' => ['content' => '<i class="fas fa-calendar-alt"></i>']],
                'options' => ['class' => 'drp-container form-group']
            ])->widget(DateRangePicker::class, [
                'useWithAddon' => true,
                'convertFormat' => true,
                'startAttribute' => 'from_date',
                'endAttribute' => 'to_date',
                'pluginOptions' => [
                    'locale' => ['format' => 'd-m-Y'],
                ]
            ])->label(Yii::t('backend', 'Vacation dates')) ?>

        </div>
        <div class="card-footer">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
