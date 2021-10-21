<? use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use quidu\ajaxcrud\CrudAsset;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\form\ActiveField;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Procedencia;
// use kartik\widgets\AlertBlock;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Listado cirugias programadas';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
.timeline .tagrojo {
    display: block;
    height: 30px;
    font-size: 13px;
    padding: 8px;
}
.tagrojo{
  /* background-color: rgb(158, 22, 48); */

line-height: 1;
background: rgb(158, 22, 48);
color: #fff !important;
}

.tagrojo::after {
    border-top-color: transparent;
    border-bottom-color: transparent;
    border-left-color: rgb(158, 22, 48);
}
.tagrojo::after {
    content: " ";
    height: 30px;
    width: 0;
    position: absolute;
    left: 100%;
    top: 0;
    margin: 0;
    pointer-events: none;
    border-top: 14px solid transparent;
        border-top-color: transparent;
    border-bottom: 14px solid transparent;
        border-bottom-color: transparent;
    border-left: 11px solid #1ABB9C;
        border-left-color:  rgb(158, 22, 48);
}
</style>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-list"></i> Listado cirugias programadas  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/cirugiaprogramada/calendario'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
</div>
<p>
<?= Html::a('Nueva Cirugia', "?r=cirugiaprogramada/create&dia=".$dia, ['class' => 'btn btn-success']) ?>
</p>


<div class="row" id="cirprogra">
  <div class="col-md-12 col-md-12  ">
    <div class="x_panel">
      <div class="x_title">
        <h2> Día <?=$fecha?> <small></small></h2>

        <div class="clearfix"></div>
      </div>
    <?
    $cant=1;
    // var_dump($arrayCirugias);
    if (!empty($arrayCirugias)){
     foreach ($arrayCirugias as $cirugiaprogramada) {
      ?>
      <!-- <legend class="text-info"><center>DATOS HISOPADO <?//echo $cirugiaprogramada->paciente->nombre; ?> </center></legend> -->


          <div class="x_content">
            <ul class="list-unstyled timeline">
              <li>
                <div class="block">
                  <div class="tags">
                    <? if ($cirugiaprogramada->estado->descripcion==="ANULADA"||$cirugiaprogramada->estado->descripcion==="REPROGRAMADA"){
                        echo   Html::a('<b>'.$cirugiaprogramada->hora_inicio.'</b>', ['/cirugiaprogramada/view','id'=>$cirugiaprogramada->id], ['class'=>'tagrojo','role'=>"modal-remote",'data-toggle'=>"tooltip",'data-pjax'=>"0" ]);
                      }else {
                        echo   Html::a('<b>'.$cirugiaprogramada->hora_inicio.'</b>', ['/cirugiaprogramada/view','id'=>$cirugiaprogramada->id], ['class'=>'tag','role'=>"modal-remote",'data-toggle'=>"tooltip",'data-pjax'=>"0" ]);

                      }

                         ?>
                    </a>
                  </div>
                  <div class="block_content">
                    <div class="col-sm-4 invoice-col">

                        <h5 class="title">
                                      <b>MEDICO: </b><?=$cirugiaprogramada->medico->nombre." ".$cirugiaprogramada->medico->apellido?>
                        </h5>
                        <h5 class="title">
                                 <b>  ESPECIALIDAD: </b><?=$cirugiaprogramada->medico->especialidad->profesion?>
                        </h5>
                        <h5 class="title">
                                      <b>PACIENTE: </b><?=$cirugiaprogramada->paciente->nombre." ".$cirugiaprogramada->paciente->apellido?>
                        </h5>
                        <h5 class="title">
                                      <b>PROCEDIMIENTO:</b> <?=$cirugiaprogramada->procedimiento?>
                        </h5>
                    </div>
                      <div class="col-sm-4 invoice-col">
                            <h5 class="title">
                                      <b> ANESTESIA: </b><?=$cirugiaprogramada->anestesia->descripcion?>
                            </h5>
                            <h5 class="title">
                                      <b> LADO: </b><?=$cirugiaprogramada->lado?>
                            </h5>
                            <h5 class="title">
                                      <b> AYUDANTES: </b><?=$cirugiaprogramada->ayudantes?>
                            </h5>
                            <!-- <h5 class="title"> -->
                                          <!-- Duración: <b><?//=$cirugiaprogramada->cant_tiempo?> hs</b> -->
                            <!-- </h5> -->
                      </div>
                      <div class="col-sm-4 invoice-col">
                            <h5 class="title">
                                      <b>DIAGNOSTICO: </b><?=$cirugiaprogramada->diagnostico?>
                            </h5>
                            <h5 class="title">
                                      <b>QUIROFANO: </b><?=$cirugiaprogramada->quirofano->nombre?>
                            </h5>
                            <h5 class="title">
                                      <b>  DURACIÓN: </b><?=$cirugiaprogramada->cant_tiempo?>
                            </h5>
                            <h5 class="title">
                                      <b>    HORA FINAL: </b><?=$cirugiaprogramada->hora_fin?> hs</b>
                            </h5>
                      </div>
                      <div class="col-sm-4 invoice-col">
                            <h5 class="title">
                                     <b>  ESTADO: </b><?=$cirugiaprogramada->estado->descripcion?>
                            </h5>


                      </div>


                  </div>
                </div>
              </li>
            </ul>

          </div>


      <?
    }
    }
    else{
         echo "<legend class='text-info'><center>NO HAY CIRUGIAS PROGRAMADAS </center></legend>";
    }
    ?>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
