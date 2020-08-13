<?php

/**
 * @var yii\web\View $this
 * @var common\models\Department $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'Department'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
