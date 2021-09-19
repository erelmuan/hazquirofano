<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\DiasSemanales;
use app\models\AnestesiologoSemana;


/* @var $this yii\web\View */
/* @var $model app\models\Anestesiologo */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Anestesiologo </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="anestesiologo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>
    <label> Dias de atención </label>
    <?
        $listadoDias= ArrayHelper::map(AnestesiologoSemana::find()->where(['id_anestesiologo' => $model->id])->all(), 'id', 'id_semana');
        $dias=array_values($listadoDias);
        echo Html::checkboxList('anestesiologo_semana', $dias, $list,
         ['item'=>function ($index, $label, $name, $checked, $value){
           return Html::checkbox($name, $checked, [
               'value' => $value,
                 'label'=>$label,
                 'class' =>"flat",
              // 'disabled' => $label==='seeeee',
             'index'=>$index,
           ]);
}]);
     ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
</div>
