
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
