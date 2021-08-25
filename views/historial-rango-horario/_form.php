<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialRangoHorario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-rango-horario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cirugia_programada')->textInput() ?>

    <?= $form->field($model, 'hora_inicio')->textInput() ?>

    <?= $form->field($model, 'hora_final')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
