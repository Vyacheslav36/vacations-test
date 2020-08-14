<?php

/**
 * @var yii\web\View $this
 * @var common\models\Vacation $model
 * @var array $usersList
 * @var \yii\data\ActiveDataProvider $vacationsDataProvider
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
        'usersList' => $usersList,
        'vacationsDataProvider' => $vacationsDataProvider
    ]) ?>

</div>
