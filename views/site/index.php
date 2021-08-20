<style>
  .x_title h2 {
      margin: 5px 0 6px;
      float: left;
      display: block;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
  }
  .x_title {
    border-bottom: 2px solid #E6E9ED;
    padding: 0px;
    margin-bottom: 10px;
    height:45;
}
</style>

<?php
use kartik\icons\Icon;
Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Inicio';
?>

  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-home"></i> INICIO  </h2>


    <div class="clearfix">
  </div>
  </div>

  <div class="body-content">

  <div class="row">

    <div class="row top_tiles">
      <?  if (Yii::$app->user->identity->id_pantalla==2){ ?>

      <a href=<?=Yii::$app->homeUrl."?r=cirugiaprogramada/calendario"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="icon-calendarthree"></i>
            </div>
            <div class="count">2</div>
            <h3>CALENDARIO</h3>
            <p>Información de las plantillas - ABM.</p>


        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=cirugiaprogramada"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-location-arrow"></i>
            </div>
            <div class="count">3</div>

            <h3>CIR. PROGRAMADA</h3>
            <p>Permisos-cambio de clave-roles.</p>
          </div>
        </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=paciente"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-group"></i>
          </div>
          <div class="count"><?=$cantidadPacientes ?></div>

          <h3>PACIENTES </h3>
          <p>Información de los pacientes - ABM.</p>
        </div>
      </div>
      </a>
      <!-- <a href=<?//=Yii::$app->homeUrl."?r=medico"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user-md"></i>
          </div>
          <div class="count"><?=$cantidadMedicos ?></div>

          <h3>MEDICOS</h3>
          <p>Información de los medicos - ABM.</p>
        </div>
      </div>
    </a> -->

      <a href=<?=Yii::$app->homeUrl."?r=parametrizacion/update&id=1"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-file-text-o"></i>
          </div>
          <div class="count">32</div>

          <h3> PARAMETRIZACIÓN </h3>
          <p>Información de las solicitudes - ABM.</p>
        </div>
      </div>
      </a>

     <a href=<?=Yii::$app->homeUrl."?r=site/administracion"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-gears"></i>
          </div>
          <div class="count">3</div>

          <h3>ADMINISTRACION</h3>
          <p>Usuarios-Roles-Modulos-Acciones- ABM.</p>
        </div>
      </div>
    </a>
  <? }  else {  ?>
      <a href=<?=Yii::$app->homeUrl."?r=biopsia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"> <?  echo Icon::show('microscope', ['class'=>'fa-2x', 'framework' => Icon::WHHG]); ?>

          </div>
          <div class="count"><?=$cantidadBiopsias ?></div>

          <h3>BIOPSIAS</h3>
          <p>Información de las biopsias - ABM.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=pap"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-flask"></i>
          </div>
          <div class="count"><?=$cantidadPaps ?></div>

          <h3>PAPS</h3>
          <p>Información de los paps - ABM..</p>
        </div>
      </div>
      </a>
  <?  }  ?>
    </div>
  </div>

</div>
</div>
</br>
</br>
</br>
<div id="detalleIndex" >
  <?
  // $db = Yii::$app->db;
  // $protocolo = $db->createCommand('SELECT protocolo FROM solicitud  WHERE anio =2020 order by protocolo DESC')
  //             ->queryColumn();
  //             echo($protocolo[0]);
              ?>
    <?  echo Icon::show('microscope', ['class'=>'fa-2x', 'framework' => Icon::WHHG]);
     ?>
     <span>SERVICIO DE QUIROFANO HOSPITAL ARTÉMIDES ZATTI </span>

  <?  echo Icon::show('microscope', ['class'=>'fa-2x', 'framework' => Icon::WHHG]);
  ?>
</div>
