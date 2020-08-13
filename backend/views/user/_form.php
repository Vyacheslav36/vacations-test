<?php

use backend\assets\UserAsset;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use backend\models\DepartmentForm;
use backend\models\UserProfileForm;
use common\models\User;

UserAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin() ?>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
                <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php echo $form->field($model, 'picture')->widget(
                    Upload::class,
                    [
                        'url' => ['/file/storage/upload'],
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    ]);
                ?>
                <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>
                <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>
                <?php echo $form->field($model, 'middlename')->textInput(['maxlength' => 255]) ?>
                <?php echo $form->field($model, 'department_id')->widget(\kartik\select2\Select2::class, [
                    'data' => DepartmentForm::getListForSelect(),
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('backend', 'Select department')],
                ]) ?>
                <?php echo $form->field($model, 'gender')->widget(\kartik\select2\Select2::class, [
                    'data' => UserProfileForm::getGenderStatuses(),
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('backend', 'Select gender')],
                ]) ?>
                <?php echo $form->field($model, 'locale')->widget(\kartik\select2\Select2::class, [
                    'data' => Yii::$app->params['availableLocales'],
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('backend', 'Select locale')],
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
