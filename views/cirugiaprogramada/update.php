<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cirugiaprogramada */

$this->title = 'Update Cirugiaprogramada: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cirugiaprogramadas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cirugiaprogramada-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiempo'=>$tiempo,
        'list'=>$list
    ]) ?>

</div>
