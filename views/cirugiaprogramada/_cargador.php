<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cirugiaprogramada */

$this->params['breadcrumbs'][] = ['label' => 'Cirugiaprogramadas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cirugiaprogramada-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
      'model' => $model,
      'searchModelPac' => $searchModelPac,
      'dataProviderPac' => $dataProviderPac,
      'searchModelMed' => $searchModelMed,
      'dataProviderMed' => $dataProviderMed,
       'cargador' => true,
      'paciente' => $modelPac,
      'dia'=>$dia,
      'tiempo' => $tiempo,
      'list'=> $list,
      'medico'=>$medico,
        // valor por defecto es 1 PENDIENTE
        'estado'=>1,
    ]) ?>


</div>
