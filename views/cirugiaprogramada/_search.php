<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CirugiaprogramadaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cirugiaprogramada-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_paciente') ?>

    <?= $form->field($model, 'id_medico') ?>

    <?= $form->field($model, 'id_procedimiento') ?>

    <?= $form->field($model, 'id_anestesia') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'id_diagnostico') ?>

    <?php // echo $form->field($model, 'hora_inicio') ?>

    <?php // echo $form->field($model, 'id_cant_hora') ?>

    <?php // echo $form->field($model, 'ayudantes') ?>

    <?php // echo $form->field($model, 'id_equipo') ?>

    <?php // echo $form->field($model, 'lado') ?>

    <?php // echo $form->field($model, 'id_observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
