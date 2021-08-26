<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspecialidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Especialidads';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0u" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> ESPECIALIDADES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/parametrizacion/update','id'=>1], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<div class="especialidad-index">
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
                    ['role'=>'modal-remote','title'=> 'Create new Especialidads','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Especialidads listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).
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

function submitAdddia(id_especialidad){
    var keys = $('#cruddetalle-datatable').yiiGridView('getSelectedRows');


    $.ajax({
        url: '<?php echo Url::to(['adddia']) ?>',
        dataType: 'json',
        type:"POST",
        data:{
            keylist: keys,
            id_especialidad: id_especialidad

        },
        success: function(data) {
            if( data.status == 'success' ){
                $('#ajaxCrudModal').modal('hide');
                reloadDetalle(id_especialidad);
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
