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
                    <a href="/hazquirofano/web/index.php?r=cirugiaprogramada%2Fview&amp;id=<?=$cirugiaprogramada->id; ?>" class="tag" title="" aria-label="Ver" data-pjax="0" role="modal-remote" data-toggle="tooltip" >
                      <span><?=$cirugiaprogramada->hora_inicio?></span>
                    </a>
                  </div>
                  <div class="block_content">
                    <div class="col-sm-4 invoice-col">

                        <h5 class="title">
                                      MEDICO: <a><?=$cirugiaprogramada->medico->nombre." ".$cirugiaprogramada->medico->apellido?></a>
                        </h5>
                        <h5 class="title">
                                      PACIENTE: <a><?=$cirugiaprogramada->paciente->nombre." ".$cirugiaprogramada->paciente->apellido?></a>
                        </h5>
                        <h5 class="title">
                                      PROCEDIMIENTO:<a> <?=$cirugiaprogramada->procedimiento?></a>
                        </h5>
                    </div>
                      <div class="col-sm-4 invoice-col">
                            <h5 class="title">
                                          ANESTESIA: <a><?=$cirugiaprogramada->anestesia->descripcion?></a>
                            </h5>
                            <h5 class="title">
                                          LADO: <a><?=$cirugiaprogramada->lado?></a>
                            </h5>
                            <h5 class="title">
                                          AYUDANTES: <a><?=$cirugiaprogramada->ayudantes?></a>
                            </h5>
                            <!-- <h5 class="title"> -->
                                          <!-- Duración: <a><?//=$cirugiaprogramada->cant_tiempo?> hs</a> -->
                            <!-- </h5> -->
                      </div>
                      <div class="col-sm-4 invoice-col">
                            <h5 class="title">
                                          DIAGNOSTICO: <a><?=$cirugiaprogramada->diagnostico?></a>
                            </h5>
                            <h5 class="title">
                                          QUIROFANO: <a><?=$cirugiaprogramada->quirofano->nombre?></a>
                            </h5>
                            <h5 class="title">
                                          DURACIÓN: <a><?=$cirugiaprogramada->cant_tiempo?></a>
                            </h5>
                            <!-- <h5 class="title"> -->
                                          <!-- Duración: <a><?//=$cirugiaprogramada->cant_tiempo?> hs</a> -->
                            <!-- </h5> -->
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
