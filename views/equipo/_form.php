<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Equipo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipo-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if($model->cirugias()){
        echo  $form->field($model, 'descripcion')->input("text",['readonly' => true])->label('Descripcion') ;
      }else {
        echo  $form->field($model, 'descripcion')->textInput(['maxlength' => true]);
      }
    ?>

    <?= $form->field($model, 'dias')->textInput() ?>

    <?= $form->field($model, 'activo')->checkbox() ?>

    <?= $form->field($model, 'id_especialidad')->dropDownList($model->getEspecialidades(), ['id'=>'id_provincia',    'prompt'=>'- Seleccionar especialidad'])->label('Especialidad') ;?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
