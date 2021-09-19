<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Quirofano */

?>
<div class="quirofano-create">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModelAnes' => $searchModelAnes,
        'dataProviderAnes' => $dataProviderAnes,
    ]) ?>
</div>
