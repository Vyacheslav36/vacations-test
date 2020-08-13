<?php

/**
 * @var yii\web\View $this
 * @var common\models\Vacation $model
 * @var array $usersList
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('backend', 'Vacation'),
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Vacations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="vacation-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'usersList' => $usersList
    ]) ?>

</div>
