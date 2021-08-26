<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;

///////////////////////////
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
///////////////////
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\TypeaheadBasic;
///////////////
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
//////////////
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Biopsias */
/* @var $form yii\widgets\ActiveForm */
use kartik\datecontrol\DateControl;
use kartik\widgets\TimePicker;
use yii\widgets\MaskedInput;
use kartik\touchspin\TouchSpin;
use kartik\range\RangeInput;
?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA BIOPSIA" : "<i class='glyphicon glyphicon-pencil'></i> PARAMETRIZACIÓN" ; ?> </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>

<?
CrudAsset::register($this);
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);
?>

<div class="x_panel" >
    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
    </ul>
    <legend class="text-info"><small>PARAMETROS GENERALES</small></legend>
      <?php $form = ActiveForm::begin(); ?>
      <div class="x_content" style="display: block;">

      <div class="row" >

      <div class="col-sm-3 invoice-col">
        <?= $form->field($model, 'hora_inicio')->widget(TimePicker::classname(), [ 'pluginOptions' => [ 'showSeconds' => false,'showMeridian' => false ,'minuteStep' => 30],]); ?>
        <?= $form->field($model, 'hora_final')->widget(TimePicker::classname(),  [ 'pluginOptions' => [ 'showSeconds' => false,'showMeridian' => false,'minuteStep' => 30],]); ?>
        <?= $form->field($model, 'horario_minimo')->widget(TimePicker::classname(),  [  'pluginOptions' => [ 'showSeconds' => false,'showMeridian' => false,'minuteStep' => 30],]); ?>

      </div>
      <div class="col-sm-3 invoice-col">

        <?= $form->field($model, 'dias_anticipacion')->widget(TouchSpin::classname(),[
            'name' => 't5',
            'pluginOptions' => [
        'initval' => 3.00,
        'min' => 0,
        'max' => 200,
        'step' => 1,
        'decimals' => 0,
        'boostat' => 5,
        'maxboostedstep' => 10,
        'prefix' => 'dias',
    ]])->input('dias_anticipacion')->label("Dias para modificar la cirugia");  ?>
    <?= $form->field($model, 'dias_creacion')->widget(TouchSpin::classname(),[
        'name' => 't5',
        'pluginOptions' => [
    'initval' => 3.00,
    'min' => 0,
    'max' => 45,
    'step' => 1,
    'decimals' => 0,
    'boostat' => 5,
    'maxboostedstep' => 10,
    'prefix' => 'dias',
    ]])->input('dias_creacion')->label("Max. dias para crear una cirugia");

    echo $form->field($model, 'niveles')->widget(RangeInput::classname(), [
        'options' => ['placeholder' => 'Rate (0 - 5)...'],
        'html5Container' => ['style' => 'width:125px'],
        'html5Options' => ['min' => 20, 'max' => 100],
        'addon' => ['append' => ['content' => '%']]
    ])->label("Nivel(empieza en verde, el resto es amarillo)");
    ?>
      </div>
      <div class="col-sm-3 invoice-col">
        <label> Parametrización especialidades </label>
        <p>
        <?= Html::a('Ir a especialidades', "?r=especialidad/index", ['class' => 'btn btn-success']) ?>
       </p>
       <label> Parametrización equipos </label>
       <p>
       <?= Html::a('Ir a equipos', "?r=equipo/index", ['class' => 'btn btn-success']) ?>
      </p>
      <label> Parametrización Observaciones </label>
      <p>
      <?= Html::a('Ir a observaciones', "?r=observacionquirurgica/index", ['class' => 'btn btn-success']) ?>
     </p>
      </div>
      <div class="col-sm-3 invoice-col">
        <label> Parametrización fecha sin atención </label>
        <p>
        <?= Html::a('Ir a fechas sin atención', "?r=dias-sin-cirugia/index", ['class' => 'btn btn-success']) ?>
       </p>
       <label> Parametrización dias sin atención </label>
       <p>
       <?= Html::a('Ir a dias sin atención', "?r=dias-semanales/index", ['class' => 'btn btn-success']) ?>
      </p>
      <label> Parametrización Quirofanos </label>
      <p>
      <?= Html::a('Ir a quirofanos', "?r=quirofano/index", ['class' => 'btn btn-success']) ?>
     </p>
      </div>
    </div>
  </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

      <?php ActiveForm::end(); ?>


</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
