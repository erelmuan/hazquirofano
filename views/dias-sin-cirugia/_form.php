<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DiasSinCirugia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dias-sin-cirugia-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
    echo $form->field($model, 'fecha')->widget(MaskedInput::classname(),['name' => 'input-31',
        'clientOptions' => ['alias' =>  'dd/mm/yyyy']]);?>

    <?= $form->field($model, 'motivo')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
