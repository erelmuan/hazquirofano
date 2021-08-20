<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DiasSemanales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dias-semanales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dia')->input("text",['readonly' => true])->label('Día') ?>

    <?= $form->field($model, 'habilitado')->checkbox() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
