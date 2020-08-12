<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\rbac\models\RbacAuthRule */

$this->title = Yii::t('backend', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-auth-rule-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
