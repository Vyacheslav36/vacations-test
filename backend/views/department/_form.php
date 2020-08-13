<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Department $model
 * @var yii\bootstrap4\ActiveForm $form
 * @var array $managerList
 */
?>

<div class="department-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'manager_id')->widget(\kartik\select2\Select2::class, [
                    'data' => $managerList,
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('backend', 'Select an employee')],
                ]);
                ?>
                <?php echo $form->field($model, 'maxNumberOfVacationDays')->textInput() ?>
                <?php echo $form->field($model, 'maxNumberOfEmployeesOnVacation')->textInput() ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
