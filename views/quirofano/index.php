<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
//TENGO QUE COMENTAR LA CLASE CRUDASSET DE johnitvn PARA QUE ME PERMITA ELIMINAR EL REGISTRO
use quidu\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuirofanoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quirofanos';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0u" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> QUIROFANO  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/parametrizacion/update','id'=>1], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<div class="quirofano-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['title'=> 'Crear quirofano','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de Quirofanos',
                'before'=>'<em>* NO CAMBIAR LOS QUIROFANOS, EL QUIROFANO A ESTA CONFIGURADO CON EL ID=2.</em>',

                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<script>
function reloadDetalle(id_maestro){
    $.ajax({
        url: '<?php echo Url::to(['listdetalle']) ?>',
        type:"POST",
        data:{
            expandRowKey: id_maestro,
        },
        success: function(detalle) {
            element = $("tr").find("div[data-key='" + id_maestro + "']");
            $(element).html(detalle);}
    });
}

function submitAddnombre(id_quirofano){
    var keys = $('#cruddetalle-datatable').yiiGridView('getSelectedRows');


    $.ajax({
        url: '<?php echo Url::to(['addnombre']) ?>',
        dataType: 'json',
        type:"POST",
        data:{
            keylist: keys,
            id_quirofano: id_quirofano

        },
        success: function(data) {
            if( data.status == 'success' ){
                $('#ajaxCrudModal').modal('hide');
                reloadDetalle(id_quirofano);
            }else{
                $('#ajaxCrudModal .modal-dialog').css({'width':'600px'});
                $('#ajaxCrudModal .modal-title')
                    .html('<p style="color:red">ERROR</p>');
                $('#ajaxCrudModal').modal('show')
                    .find('#cruddetalle-datatable')
                    .html(('<div style=" font-size: 14px">Errores en la operacion indicada. Verifique</div>'));
            }
        }
    });
}
</script>
