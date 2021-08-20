<?php
use kartik\widgets\AlertBlock;
$this->title = 'Actualizacion reporte';

// <!-- Begin page content -->

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="card card-plain">
        <div class="card-header card-header-danger">
          <h3 class="card-title">ACTUALIZACIÓN DEL ARCHIVO REPORTE</h3>
          <p class="card-category">Handcrafted by our friends from
            <a target="_blank" href="#">Google</a>
          </p>
        </div>
<!--  -->

  <h3 >Mientras más grande sea el registro de inicio, más rápido terminara el proceso.</h3>
  <h3 > Espere el mensaje de confirmación para saber si se ha actualizado con exito.</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12">
      <!-- Contenido -->

    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Indique desde que registro actualizar</label>
                <input type="number"  class="form-control"  name="registro" id="registro" value=0>
              </br>
                <button type="submit" id="submit" name="import" class="btn btn-danger">ACTUALIZAR REPORTE</button>

            </div>

        </form>

    </div>

      <!-- Fin Contenido -->
    </div>
  </div>

<!--  -->
      </div>
    </div>
  </div>
</div>


  <!-- Fin row -->


<script src="assets/jquery-1.12.4-jquery.min.js"></script>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="dist/js/bootstrap.min.js"></script>
