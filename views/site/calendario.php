<?php
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

Icon::map($this, Icon::WHHG);
use yii\bootstrap\Modal;
// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Plantillas';
?>
<!-- 1. jQuery UI -->
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.17/jquery-ui.min.js"></script>
<?//= Html::jsFile('@web/js/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') ?>


<style>
.tile-stats{
background: #E6FDBD;
}


</style>

  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w022" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-calendar"></i> Calendario  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>
  <div class="x_panel" >
      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
      </ul>
      <legend class="text-info"><small>Datos de la solicitud</small></legend>
      <div class="x_content" style="display: block;">
        <div class="biopsia-search">

            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                // 'options' => [
                //     'data-pjax' => 1
                // ],
            ]); ?>

            <?
            echo $form->field($model, 'fecha_desde')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'id' => 'fecha1',
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    'startView' => 'year',
                ]
            ]);

            echo $form->field($model, 'fecha_hasta')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'id' => 'fecha1',
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy',
                    'startView' => 'year',
                ]
            ]);

            ?>


                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>

            <?php ActiveForm::end(); ?>

        </div>


      </div>
  </div>

  <div class="body-content">


  <div class="row">

<?
  $this->title = Yii::t('app', 'Calendario');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= yii2fullcalendar\yii2fullcalendar::widget([
    'header' => [
      'left' => 'prev,next today',
      'center' => 'title',
      //'right' => 'picker month,agendaWeek,agendaDay',
      'right' => 'picker month',
  ],
      'options' => [
        'lang' => 'es',

        //... more options to be defined here!
        // 'defaultView'=> 'month',
      ],
       // 'events' => Url::to(['/paciente']),
      // 'ajaxEvents' => Url::to(['/paciente']),
      'events'=> $events,
      'clientOptions' => [
        'theme' => true,
        'themeSystem' => 'jquery-ui',
       // 'themeSystem' => 'bootstrap3',
        'weekends'=> true, //ocultará sábados y domingos
          'selectable' => true,
         'eventLimit' => true,
         'dayClick'=>new JSExpression("function(date, allDay, jsEvent, view ) {
          window.location.href = 'index.php?r=cirugiaprogramada/fecha&dia='+ date.format();

        }"),
        'eventClick'=> new JSExpression("function(date, info, jsEvent ) {
          date.url;
        }"),


        // 'select' => new JSExpression("function(date, allDay, jsEvent, view ) {
        //   //console.log('hol');

        //   window.location.href = 'index.php?r=cirugiaprogramada/fecha&dia='+ date.format();

        //    // if (view.name == 'day')
        //    // return;
        //        // view.calendar.gotoDate(date);
        //        // view.calendar.changeView('agendaDay');
        // }"),
        // 'eventSources' => ['/eventcalendar/index'],
        // 'eventSources' => [
        //     $eventList,
        //     $icalList,
        // ],
    ],



    ]);
?>


</div>

</div>
</div>
