<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WiewHorasOcupadas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wiew-horas-ocupadas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_cirugia')->textInput() ?>

    <?= $form->field($model, 'horas_ocupadas')->textInput() ?>

    <?= $form->field($model, 'id_quirofano')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
