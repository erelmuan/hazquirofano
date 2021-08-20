<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nuevo medico </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
      </br>
<div class="medico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'apellido')->input("text",['style'=> 'width:100%; text-transform:uppercase;']) ?>

    <?= $form->field($model, 'nombre')->input("text",['style'=> 'width:100%; text-transform:uppercase;']) ?>

    <?= $form->field($model, 'id_tipodoc')->dropDownList($model->getTipodocs())->label('Tipo de documento') ;?>

    <?= $form->field($model, 'num_documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'matricula')->textInput() ?>

    <?= $form->field($model, 'id_especialidad')->dropDownList($model->getEspecialidades())->label('Profesion') ;?>


    <label>Buscar usuario:<span id='usuario'> </span>
        <button title="Busqueda avanzada de usuarios" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-usuario-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>

      </label>
      <input type="text" id="usuariobuscar" name="UsuarioSearch[usuario]"  placeholder="Ingresar nombre de usuario" >
      <button type="button" class ="btn btn-primary btn-xs" onclick='usuarioba();'>Buscar y añadir</button>
      </div>

    <!-- <label> Usuario </label> </br>
      <input id="cirugia-usuario" style="width:250px;" value='<?=($model->usuario)?$model->usuario->usuario.", ".$model->usuario->usuario:'' ?>' type="text" readonly>
 -->
   <div class="form-group field-medico-usuario">
   <label class="control-label" for="medico-usuario">Usuario</label>
   <input type="text" id="medico-usuario" class="form-control" value='<?=($model->usuario)?$model->usuario->usuario:'' ?>' readonly/>

   <div class="help-block"></div>
   </div>

      <?=$form->field($model, 'id_usuario')->hiddenInput()->label(false); ?>


      <?  if (!Yii::$app->request->isAjax){ ?>
         <div class='pull-right'>
            <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
         </div>
      <? }
          $form = ActiveForm::end();
      ?>
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
                               'dataProvider' => $dataProviderUsu,
                               'filterModel' => $searchModelUsu,
                               'pjax'=>true,
                               'columns' => require(dirname(__DIR__).'/cirugiaprogramada/_columnsUsuario.php'),
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
                       <button type="button"  onclick='agregarFormularioUsu();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>
    </div>


</div>


<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>

function pacienteba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=paciente/search' ?>',
        type: 'get',
        data: {
              "PacienteSearch[num_documento]":$("#pacientebuscar").val() ,
              _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
              },
        success: function (data) {
          var content = JSON.parse(data);
          if (content.status=='error'){
            swal(
            content.mensaje ,
            'PRESIONAR OK',
            'error'
            )
          }else{
            swal(
            'Se agrego el paciente' ,
            'PRESIONAR OK',
            'success'
            )
          document.getElementById("cirugia-paciente").value= content['apellido']+", "+content['nombre'];
          document.getElementById("cirugia-id_paciente").value= content['id'];
         }
        }
   });

}

function usuarioba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=usuario/search' ?>',
        type: 'get',
        data: {
              "UsuarioSearch[usuario]":$("#usuariobuscar").val() ,
              _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
              },
        success: function (data) {
          var content = JSON.parse(data);
          if (content.status=='error'){
            swal(
            content.mensaje ,
            'PRESIONAR OK',
            'error'
            )
          }else{
            swal(
            'Se agrego el usuario' ,
            'PRESIONAR OK',
            'success'
            )
          document.getElementById("medico-usuario").value= content['usuario'];
          document.getElementById("medico-id_usuario").value= content['id'];
        }
        }
   });

}
///script agregar y quitar paciente desde la busqueda avanzada



function agregarFormularioUsu (){
  document.getElementById("medico-usuario").value=  $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("medico-id_usuario").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el usuario' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}

</script>
