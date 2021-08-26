<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametrizacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hora_inicio')->textInput() ?>

    <?= $form->field($model, 'hora_final')->textInput() ?>

    <?= $form->field($model, 'dias_anticipacion')->textInput() ?>

    <?= $form->field($model, 'dias_creacion')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
