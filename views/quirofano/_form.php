<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Quirofano */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nuevo Quirofano</h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="quirofano-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?= $form->field($model, 'observacion')->textInput() ?>

    <?= $form->field($model, 'habilitado')->checkbox() ?>

    <?= $form->field($model, 'necesita_anestesiologo')->checkbox() ?> 


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

  </div>
</div>
<div class="x_content">
       <div class="x_content">
             <div class="modal fade bs-usuario-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="usuario-index">
                         <div id="ajaxCrudDatatable">
                           <?=GridView::widget([
                               'id'=>'crud-usuario',
                               'dataProvider' => $dataProviderAnes,
                               'filterModel' => $searchModelAnes,
                               'pjax'=>true,
                               'columns' => require(dirname(__DIR__).'/quirofano/_columnsAnestesiologo.php'),
                               'toolbar'=> [

                               ],
                               'panel' => [
                                   'type' => 'primary',
                                   'heading'=> false,
                               ]
                           ])?>
                         </div>
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                       <button type="button"  onclick='agregarFormularioAnes();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>
</div>
<script>
function agregarFormularioAnes (){
  document.getElementById("quirofano-anestesiologo").value=  $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("quirofano-id_anestesiologo").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el anestesiologo' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}

</script>
