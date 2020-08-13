<?php

/**
 * @var yii\web\View $this
 * @var common\models\Vacation $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'Vacation'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Vacations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacation-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
