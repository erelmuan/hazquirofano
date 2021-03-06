<?php
/* @var $this yii\web\View */
/* @var $model app\models\Cirugiaprogramada */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Html;
use kartik\form\ActiveForm;
// use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use quidu\ajaxcrud\CrudAsset;
use kartik\builder\Form;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\form\ActiveField;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Procedimiento;
use app\models\Quirofano;
use kartik\widgets\TimePicker;
use app\models\Equipo;
use app\models\Cirugiaequipo;
use app\models\ObservacionCirugia;
use app\models\Observacionquirurgica;
use app\models\Medico;
use app\models\Estado;

use app\models\Cirugiaprogramada;




/* @var $this yii\web\View */

$this->title = 'Nueva cirugia programada';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nueva Cirugia programada </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
      </br>
      <div class='row'>

      <? $form = ActiveForm::begin();?>
      <div class='col-sm-3'>
      <label >Paciente: <span id='paciente'> </span>
        <button title="Busqueda avanzada de paciente" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-paciente-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
        <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear paciente</i>', ['paciente/create'],
         ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-primary btn-xs']); ?>
      </label>
      <input type="text" id="pacientebuscar" name="PacienteSearch[num_documento]"  placeholder="Ingresar DNI del paciente" >
      <button type="button" class ="btn btn-primary btn-xs" onclick='pacienteba();'>Buscar y añadir</button>
    </br>
      <label> Paciente </label><span id="asterisco" >*</span></br>
      <input id="cirugia-paciente"  style="width:250px"; value='<?=($model->paciente)?$model->paciente->apellido.", ".$model->paciente->nombre:''; ?>' type="text" readonly>
    <?=$form->field($model, 'id_paciente')->hiddenInput()->label(false); ?>

    <? if ($cargador){ ?>
      <label >Medico: <span id='medico'> </span>
        <button title="Busqueda avanzada de medico" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-medico-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
      </label>
      <input type="text" id="medicobuscar" name="MedicoSearch[num_documento]"  placeholder="Ingresar DNI del medico" >
      <button type="button" class ="btn btn-primary btn-xs" onclick='medicoba();'>Buscar y añadir</button>
    </br>
    <?} ?>
      <?= $form->field($model, 'ayudantes')->textInput() ?>

      </div>
      <div class='col-sm-3'>

        <?=$form->field($model, 'fecha_programada')->input("date",
        [
        'readonly' =>(Yii::$app->user->identity->isCargador())?false:true ,
        'value' => ($model->fecha_programada)?date('Y-m-d',strtotime($model->fecha_programada)):date('Y-m-d')])->label('Fecha  programada');  ?>

      <label> Medico </label> </br>
      <input id="cirugia-medico" class="form-control" style="width:250px;" value='<?=($medico)?$medico->apellido.", ".$medico->nombre:'' ?>' type="text" readonly>
      <?=$form->field($model, 'id_medico')->hiddenInput(['value'=>($medico)?$medico->id:""])->label(false); ?>

      <?=$form->field($model, 'procedimiento')->textInput() ?>
 	   <?= $form->field($model, 'hora_fin')->textInput(['readonly' => true ]) ?>
        </div>


            <div class='col-sm-3'>
            <?=$form->field($model, 'fecha_cirugia')->input("date",['readonly' => true ,'value' => $dia])->label('Fecha de cirugia');  ?>
             <?=$form->field($model, 'lado')->dropDownList(
              ['NP' => 'No procede ','derecho' => 'derecho ', 'izquierdo' => 'izquierdo']
              );
              ?>
              <?= $form->field($model, 'id_anestesia')->dropDownList($model->getAnestesias())->label('Tipo de anestesia') ;?>
              <?
                     echo ( Html::label('Quirofano', 'macro', ['class' => 'control-label has-star']));

                       echo Select2::widget( [
                                  'name' => 'Cirugiaprogramada[id_quirofano]',
                                  'value' => $model->id_quirofano,
                                  'data' =>  ArrayHelper::map($model->quirofanos($dia) , 'id','nombre'),
                                   'language' => 'es',
                                  'options' => [
                                    // 'value' => 1,
                                  'onchange' => 'onEnviarQuir(this.value,"'.$dia.'",'.$model->id.')',
                                  // 'placeholder' => 'Seleccionar código..',
                                  'multiple' => false
                                     ],
                                  'pluginOptions' => [
                                   'allowClear' => true
                                         ],
                         ]);

                   ?>
              </div>
              <div class='col-sm-3'>
                <?= $form->field($model, 'cant_tiempo')->dropDownList($model->getCantTiempo(),  ['onchange'=>'horarioFinal(this.value)'])->label('Cantidad de tiempo') ;?>
                <?=$form->field($model, 'hora_inicio')->textInput(['readonly' => true ,'value' => $tiempo])->label('Hora de inicio');  ?>

              <?= $form->field($model, 'diagnostico')->textInput(); ?>

            </div>
            <div class='col-md-12'>
              <label> Equipos </label>
            <?
            //Despues lo pongo en el controler
            // $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);

            // $listadoEquipos= ArrayHelper::map(Cirugiaequipo::find()->where(['id_cirugiaprogramada' => $model->id])->all(), 'id', 'id_equipo');
            // $equipos=array_values($listadoEquipos);
             ?>
            <?=Html::checkboxList('cirugiaequipos', $equipos, $list,
            [

                'item' => function($index, $label, $name, $checked, $value) {

              return Html::checkbox($name, $checked, [
                  'value' => $value,
                    'label'=>$label,
                    'class' =>"flat",
                 // 'disabled' => $label==='seeeee',
                 'disabled' => strpos($label, "(No disponible)") ||  strpos($label, "(Reservado x esp)"),
                'index'=>$index,
              ]);
          }
          ])
           ?>


         </div>
         <div class='col-md-3'>
           <?=$form->field($model,"otro_equpo")->textInput(); ?>
        </div>
        <div class='col-md-6'>
        <?=$form->field($model,"material_protesis")->textInput();?>
       </div>

         <div class='col-md-12'>
           <label> Observaciones </label>

         <?=Html::checkboxList('observacionquirurgica', $observacion, $listobs,
         ['item' => function($index, $label, $name, $checked, $value) {

           return Html::checkbox($name, $checked, [
               'value' => $value,
                 'label'=>$label,
             'index'=>$index,
           ]);
         }
         ])
         ?>

              <div class='col-md-6'>
                <?=$form->field($model,"observacion")->textInput()->label("Detalles");?>
             </div>

         <div class='col-md-3'>
           <? if (!isset($model->id_estado)){
                echo $form->field($model, 'estado')->textInput(['readonly' => true ,'value'=>"PENDIENTE"]);
                echo $form->field($model, 'id_estado')->hiddenInput(['value'=>1])->label(false);

           } elseif( $model->id_estado==2 || $model->id_estado==3  ) {
                echo $form->field($model, 'estado')->textInput(['readonly' => true ,'value' => $model->estado->descripcion])->label('Estado');
             }else {
               echo $form->field($model, 'id_estado')->dropDownList($model->getEstados())->label('Estado') ;

             }
           ?>
          </div>
         <div class="x_content">
               <div class="modal fade bs-paciente-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                 <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                     <div class="modal-body">
                       <div class="paciente-index">
                           <div id="ajaxCrudDatatable">
                             <?=GridView::widget([
                                 'id'=>'crud-paciente',
                                 'dataProvider' => $dataProviderPac,
                                 'filterModel' => $searchModelPac,
                                 'pjax'=>true,
                                 //Adaptacion para moviles
                                 'responsiveWrap' => false,
                                 'columns' => require(dirname(__DIR__).'/cirugiaprogramada/_columnsPaciente.php'),
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
                         <button type="button"  onclick='agregarFormularioPac();' class="btn btn-primary">Agregar al formulario</button>
                       </div>
                 </div>
               </div>
             </div>
         </div>
       </div>
    <? if ($cargador){ ?>
       <div class="x_content">
             <div class="modal fade bs-medico-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="medico-index">
                         <div id="ajaxCrudDatatable">
                           <?=GridView::widget([
                               'id'=>'crud-medico',
                               'dataProvider' => $dataProviderMed,
                               'filterModel' => $searchModelMed,
                               'pjax'=>true,
                               'columns' => require(dirname(__DIR__).'/cirugiaprogramada/_columnsMedico.php'),
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
                       <button type="button"  onclick='agregarFormularioMed();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
      </div>

    <? } if (!Yii::$app->request->isAjax){ ?>
         <div class='pull-right'>
            <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
         </div>
      <? }
          $form = ActiveForm::end();
      ?>

</div>


<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>
  function agregarCero(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
window.onload =  horarioFinal(document.getElementById("cirugiaprogramada-cant_tiempo").value);

 function horarioFinal(inter_hora){

     let hora_inicio= document.getElementById("cirugiaprogramada-hora_inicio").value;

     var hora1 = (inter_hora).split(":"),
        hora2 = (hora_inicio).split(":"),
        t1 = new Date(),
        t2 = new Date();

    t1.setHours(hora1[0], hora1[1], hora1[2]);
    t2.setHours(hora2[0], hora2[1], hora2[2]);

    //Aquí hago la resta
    t1.setHours(t1.getHours() + t2.getHours(), t1.getMinutes() + t2.getMinutes(), t1.getSeconds() + t2.getSeconds());
    hora_final= agregarCero(t1.getHours()) +":"+agregarCero(t1.getMinutes()) +":"+agregarCero(t1.getSeconds());
    document.getElementById("cirugiaprogramada-hora_fin").value = hora_final;

 }
function onEnviarQuir(val1,val2,val3)
 {
     $.ajax({
         url: '<?php echo Url::to(['/cirugiaprogramada/tiempoajax']) ?>',
        type: 'post',
        data: {id: val1, dia:val2 ,id_model:val3},
        success: function (data) {
            var content = JSON.parse(data);
           document.getElementById("cirugiaprogramada-hora_inicio").value= content[0];
           horarioFinal(document.getElementById("cirugiaprogramada-cant_tiempo").value);
        }

   });


 }

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
          document.getElementById("cirugiaprogramada-id_paciente").value= content['id'];
         }
        }
   });

}
function medicoba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=medico/search' ?>',
        type: 'get',
        data: {
              "MedicoSearch[num_documento]":$("#medicobuscar").val() ,
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
            'Se agrego el medico' ,
            'PRESIONAR OK',
            'success'
            )
          document.getElementById("cirugia-medico").value= content['apellido']+" "+content['nombre'];
          document.getElementById("cirugiaprogramada-id_medico").value= content['id'];
        }
        }
   });

}


///script agregar y quitar paciente desde la busqueda avanzada

function agregarFormularioPac (){

console.log($("tr.success").find("td:eq(1)").text());
  document.getElementById("cirugia-paciente").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("cirugiaprogramada-id_paciente").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el paciente' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}
function agregarFormularioMed (){
  document.getElementById("cirugia-medico").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("cirugiaprogramada-id_medico").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();

  swal({
       title: "Confirmado!",
       text: "Se agrego el medico",
       type: "success",
       timer: 1800
       })

  $('button.btn.btn-default').click();

}

</script>
<style>
  #asterisco{
    content: "*";
    margin-left: 3px;
    font-weight: normal;
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    color: tomato;
    }
  }

</style>


</div>
