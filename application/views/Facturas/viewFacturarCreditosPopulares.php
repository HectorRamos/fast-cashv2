<!-- contenedor -->
<div class="content-page">
  <div class="content">
    <div class="container">
      <!-- Page-Title -->
    <div class="row">
            <div class="col-sm-12">
                <!-- <h4 class="pull-left page-title">Gestion de los estados de la solicitud</h4> -->
                <ol class="breadcrumb pull-right">
                    <li><a href="<?= base_url() ?>Home/Main">Inicio</a></li>
                    <li class="active">Facturas</li>
                </ol>
            </div>
    </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                    <!--Panel body aqui va la tabla con los datos-->
                    <div class="panel-heading">
                      <div class="table-title">
                        <div class="row">
                          <div class="col-sm-6">
                            <h3 class="panel-title">Facturar Créditos Populares</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="margn">
                              <div class="divBuscar">
                              <div id="div1">
                                <div style="margin-bottom:20px;">
                                <h4>Seleccione un crédito</h4>
                                <div class="margn">
                                  <div class="row">
                                    <div class="col-md-8">
                                      <input type="text" class="form-control" name="" id="txtBuscar" placeholder="Buscar por codigo de crédito">
                                    </div>
                                    <div class="col-md-4">
                                      <a class="btn btn-success" id="btnBuscar"><i class="fa fa-search"></i> Buscar</a>
                                      <a href="<?= base_url();?>Facturas/FacturarCreditosPopulares" class="btn btn-warning refres"><i class="fa fa-refresh"></i></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div id="Tabla">
                              <table id="datatable" class="table">
                                <thead class="thead-dark thead thead1">
                                <tr>
                                  <th>Código Crédito</th>
                                  <th>Cliente</th>
                                  <th>Agregar</th>
                                </tr>
                                </thead>
                                <tbody id="tableBody">
                                  <?php
                                  foreach ($populares->result() as $Cpopulares) {
                                  ?>
                                  <tr>
                                    <td><?= $Cpopulares->codigoCredito?></td>
                                    <td><?= $Cpopulares->Nombre_Cliente." ".$Cpopulares->Apellido_Cliente?></td>
                                    <td><a onclick="abrirFecha(<?= $Cpopulares->idCredito?>)" class="btn btn-info" id="btnFacturar"><i class="fa fa-file-text-o"></i> Facturar</a></td>
                                  </tr>
                                  <?php
                                   } 
                                   ?>
                                </tbody>
                              </table>
                              </div>
                              </div>

                              <div id="divFechas" style="display:none;">
                              <h4>Seleccione el rango de fechas para realizar la factura</h4>
                                <form class="form-inline" id="buscrPorFecha" method="post">
                                
                                  <div class="margn">
                                    <div class="form-group">
                                      <label for="fechaInicio">Inicio </label>
                                      <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control DateTime" name="fechaInicial" id="fechaInicio" placeholder="Fecha inicial" required data-parsley-required-message="Por favor, digite fecha de inicio" data-mask="9999/99/99">
                                      </div>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="form-group">
                                      <label for="fechaFinal">Final </label>
                                      <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control DateTime" name="fechaFinal" id="fechaFinal" placeholder="Fecha final" required data-parsley-required-message="Por favor, digite fecha final" data-mask="9999/99/99">
                                      </div>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a id="btnBuscarFecha" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</a>
                                  </div>
                                </form>
                                <br>
                                <div align="center">
                                  <a href="<?= base_url() ?>Facturas/FacturarCreditosPopulares" type="button" class="btn btn-default block waves-effect waves-light m-b-5"><i class="fa fa-chevron-left fa-lg"></i> Volver</a>
                                </div>

                              </form>
                              </div>
                              <div id="divFormularioFactura" style="display:none;">
                              <h4>Detalle de la factura</h4>
                                <form class="form" method="POST" id="frmFactura">
                                <input type="hidden" id="idCredito" name="idCredito">
                                <input type="hidden" name="fechaI" id="fechaI">
                                <input type="hidden" name="fechaF" id="fechaF">
                                 <div style="padding-left: 38px; padding-right: 38px; border: 1px solid #D5DBDB; border-radius: 5px;">
                                    <br>
                                    <div class="row">
                                    <!--CAMPOS OCULTOS-->
                                    <!--FIN DE LOS CAMPOS OCULTOS-->
                                      <div class="form-group col-sm-6">
                                          <div class="form-group">
                                            <label for="fechaFinal">Seleccione la fecha de aplicacion </label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                              <input type="text" class="form-control DateTime" name="fechaAplicacion" id="fechaAplicacion" placeholder="Fecha Aplicacion" required data-parsley-required-message="Por favor, digite fecha final" data-mask="9999/99/99">
                                            </div>
                                          </div>
                                      </div>                
                                      <div class="col-sm-6 noneIMG" align="right">
                                        <div style="padding-bottom: 7px; margin-top: -1px;">
                                          <img src="<?= base_url()?>plantilla/images/checked.png" class="img-responsive img-thumbnail" alt="Pago" style="width: 70px;">
                                        </div>
                                      </div>                
                                    </div>
                                  </div>
                                  <br>

                                  <div style="padding-left: 38px; padding-right: 38px; padding-top: 10px; border: 1px solid #D5DBDB; border-radius: 5px;">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label for="codigoPrestamo">Código de Prestamo:&nbsp;</label><span id="codigoPrestamoSpan"></span>
                                        <input type="hidden" id="codigoPrestamo" name="codigoPrestamo" value="" class="form-control">
                                      </div>
                                      <div class="col-md-6">
                                        <label for="Monto">Monto:&nbsp;</label><span id="MontoSpan"></span>
                                        <input type="hidden" id="Monto" name="Monto" value="" class="form-control">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <label for="Cliente">Cliente:&nbsp;</label>
                                        <span id="ClienteSpan"></span>
                                        <input type="hidden" id="Cliente" name="Cliente" value="" class="form-control">
                                        <input type="hidden" id="id_cliente" name="id_cliente" value="">
                                      </div>
                                      <div class="col-md-6">
                                        <label for="fechaOtorgamiento">Fecha de otorgamiento:&nbsp;</label><span id="fechaOtorgamientoSpan"></span>
                                        <input type="hidden" id="fechaOtorgamiento" name="fechaOtorgamiento" value="" class="form-control">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6">
                                        <label for="fechaVencimiento">Fecha de Vencimiento:&nbsp;</label><span id="fechaVencimientoSpan"></span>
                                        <input type="hidden" id="fechaVencimiento" name="fechaVencimiento" value="" class="form-control">
                                      </div>
                                      <div class="col-md-6">
                                        <label for="Cuota">Cuota:&nbsp;</label><span id="CuotaSpan"></span>
                                        <input type="hidden" id="Cuota" name="Cuota" value="" class="form-control">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6">
                                        <label for="fechaUltimoPago">Fecha de último pago:&nbsp;</label><span id="fechaUltimoPagoSpan"></span>
                                        <input type="hidden" id="fechaUltimoPago" name="fechaUltimoPago" value="" class="form-control">
                                      </div>
                                      <div class="col-md-6">
                                        <label for="noAfectas">no Afectas:&nbsp;</label><span id="noAfectasSpan"></span>
                                        <input type="hidden" id="noAfectas" name="noAfectas" value="" class="form-control">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                          <label for="ventasGravadas">Ventas Gravadas:&nbsp;</label><span id="ventasGravadasSpan"></span>
                                          <input type="hidden" id="ventasGravadas" name="ventasGravadas" value="" class="form-control">
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="Total">Total:&nbsp;</label>$<span id="TotalSpan"></span>
                                          <input type="hidden" id="Total" name="Total" value="" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                    <!-- <div class="col-md-12"> -->
                                  <div align="center">
                                    <br>
                                    <a href="javascript:void(0)" type="button" id="btnVolverAFecha" class="btn btn-default" ><i class="fa fa-chevron-left fa-lg"></i> Volver</a>
                                    <a id="btnGuardarFactura" class="btn btn-success">Generar factura</a>
                                  </div>
                                    <!-- </div> -->
                                  <!-- </div> -->
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

<script type="text/javascript">
    $(document).on('ready', function(){
      $('#btnVolverAFecha').on('click', function(){
      document.getElementById('divFormularioFactura').style.display='none';
      document.getElementById('divFechas').style.display='block';
    });

    $('#btnBuscar').on('click', function(){
      //alert('sssss');
      var codigo = $('#txtBuscar').val();
      if(codigo ==""){
        // alert('vacio');
          $(document).ready(function(){
            $.Notification.autoHideNotify('error', 'top center', 'Aviso!', 'Por favor digite un código de crédito.');
          });
      }
      else{
        //document.getElementById('tableBody').innerHTML=HTML;
        //$('#tableBody').remove();
        $.ajax({
          url:"<?= base_url()?>Facturas/ObtenerCreditoCodigo",
          type:"GET",
          data:{Codigo:codigo},
          success:function(respuesta){
            var registro = eval(respuesta);
            if (registro.length > 0)
              {
                document.getElementById('Tabla').innerHTML="";
                var HTML="";
                HTML+='<table class="table">';
                HTML+='<tr>';
                HTML+='<th>Codigo Credito</th>';
                HTML+='<th>Cliente</th>';
                HTML+='<th>Agregar</th>';
                HTML+='</tr>';
                HTML+='<tbody>';
                //alert('funciona');
                for (var i =0 ; i<registro.length ; i++){
                  //alert('sssss'+i);
                  HTML+='<tr>';
                  HTML+='<td>'+registro[i]['codigoCredito']+'</td>';
                  HTML+='<td>'+registro[i]['Nombre_Cliente']+' '+registro[i]['Apellido_Cliente']+'</td>';
                  HTML+='<td><a onclick="abrirFecha('+registro[i]['idCredito']+')" class="btn btn-info">facturar</a></td>';
                  HTML+='</tr>';
                }
                HTML+='</tbody>';
                HTML+='</table>';
                document.getElementById('Tabla').innerHTML=HTML;
                //$('#tableBody').apend(HTML);*/
              }
            else{
              // alert('NO se ecnontro un credito con el codigo insertado por verifique');
              $(document).ready(function(){
                $.Notification.autoHideNotify('error', 'top center', 'Aviso!', 'NO se econtro un crédito con el código insertado por favor verifique.');
              });
            }
          }
        });
      }
    });//fin del primer filtro

    //INICIO DEL SEGUNDO FILTRO
    $('#btnBuscarFecha').on('click', function(){
     // alert('fechas');
      var fecha1 = $('#fechaInicio').val();
      var fecha2 = $('#fechaFinal').val();
      var ide = $('#idCredito').val();
      $('#fechaI').val(fecha1);
      $('#fechaF').val(fecha2);
      $.ajax({
          url:"<?= base_url()?>Facturas/calcularFactura",
          type:"GET",
          data:{Id:ide,fechaInicio:fecha1,fechaFin:fecha2},
          success:function(respuesta){
            var registro = eval(respuesta);
            if (registro.length > 0)
              {
                document.getElementById('divFormularioFactura').style.display='block';
                document.getElementById('divFechas').style.display='none';
                for (var i =0 ; i<registro.length ; i++){
                  // alert(registro[i]['codigoCredito']);
                  $('#codigoPrestamo').val(registro[i]['codigoCredito']);
                  $('#codigoPrestamoSpan').text(registro[i]['codigoCredito']);
                  $('#Cliente').val(registro[i]['Nombre_Cliente']+" "+registro[i]['Apellido_Cliente']);
                  $('#ClienteSpan').text(registro[i]['Nombre_Cliente']+" "+registro[i]['Apellido_Cliente']);
                  $('#Monto').val(registro[i]['capital']);
                  $('#MontoSpan').text(registro[i]['capital']);
                  $('#fechaOtorgamiento').val(registro[i]['fechaApertura']);
                  $('#fechaOtorgamientoSpan').text(registro[i]['fechaApertura']);
                  $('#fechaVencimiento').val(registro[i]['fechaVencimiento']);
                  $('#fechaVencimientoSpan').text(registro[i]['fechaVencimiento']);
                  $('#Cuota').val(registro[i]['pagoCuota']);
                  $('#CuotaSpan').text(registro[i]['pagoCuota']);
                  $('#fechaUltimoPago').val(registro[i]['fechaPago']);
                  $('#fechaUltimoPagoSpan').text(registro[i]['fechaPago']);
                  $('#noAfectas').val(registro[i]['noAfectas']);
                  $('#noAfectasSpan').text(registro[i]['noAfectas']);
                  $('#ventasGravadas').val(registro[i]['ventasGravadas']);
                  $('#ventasGravadasSpan').text(registro[i]['ventasGravadas']);
                  var Total = parseFloat(registro[i]['noAfectas'])+parseFloat(registro[i]['ventasGravadas']);
                  $('#Total').val(Total);
                  $('#TotalSpan').text(Total);
                }
              }
            else{
              // alert('No hay pagos en este rango de fechas, para mas informacion rebise la seccion de creditos y vea el detalle del credito');
              $(document).ready(function(){
                $.Notification.autoHideNotify('info', 'top center', 'Aviso!', 'No hay pagos en este rango de fechas, para mas informacion rebise la seccion de creditos y vea el detalle del credito.');
              });
            }
          }
       })
    });//fin
    //inicio

    $('#btnGuardarFactura').on('click', function(){
      // alert('qqqq')
      var fechaAplicacion=$('#fechaAplicacion').val();
      if(fechaAplicacion!=""){
        //alert('sunciona para inserta');

        $.ajax({
                url:"<?= base_url()?>Facturas/InsertarFactura",
                type:"POST",
                
                data:$('#frmFactura').serialize(),
                success:function(respuesta){
                  swal({   
                      imageUrl: "<?= base_url()?>plantilla/images/loading.gif", 
                      title: "Pago realizado con exito!",   
                      text: "A continuacion se imprimira el comprobante de pago",   
                      timer: 6099,   
                      showConfirmButton: false 
                  });
                  // alert('Pago realizado con exito, se imprimira el comprobante de pago');
                  setTimeout(function(){

                  //var cliente = $('select[name="idCredito"] option:selected').text();
                  //arregloNombre = cliente.split(" - ");
                  var HTML ='<div  style="width:100%; height:368.5px;">'

                  HTML+='<div id="divEncabezado" style="width: 100%; height: 85.04px;  padding: 2px; margin: 1px;"></div>';
                  HTML+=' <div id="divDetalle" style="width: 100%; height: 226.77px; padding: 5px;">';
                  HTML+='<table style="width:100%; font-size:10px;">';
                  HTML+='<tr>';
                  //LINEA DEL NUMERO DE PRESTAMO
                  HTML+='<td>No. Prestamo : '+$('#codigoPrestamo').val()+'</td><td>Monto: '+$('#Monto').val()+'</td><td>Fecha Aplicación: '+$('#fechaAplicacion').val()+'</td>'
                  HTML+='</tr>'
                  //LINEA DEL CLIENTE
                  HTML+='   <tr><td>Nombre del cliente: '+$('#Cliente').val()+'</td><td>Fecha de Otorgamiento: '+$('#fechaOtorgamiento').val()+'</td><td>Fecha de Vencimiento: '+$('#fechaVencimiento').val()+'</td></tr>';

                  HTML+='<tr><td>Cuota: '+$('#Cuota').val()+'</td><td>Fecha Ultimo Pago: '+$('#fechaUltimoPago').val()+'</td></tr>';

                  HTML+=' </table>';
                  //DIV DETALLE
                  HTML+='<div style="border:solid; border-width:1px; border-radius:15px; padding:10px;"><table style="width:100%; font-size:10px;">';

                  HTML+='<tr><td>Pago &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td><td>No Afectas</td><td>Ventas Excentas</td> <td>Ventas Gravadas</td></tr>';

                  HTML+='<tr><td>Capital &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td><td> '+$('#noAfectas').val()+'</td><td></td> <td></td></tr>';

                  HTML+='<tr><td>Interes &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td><td></td><td></td><td>'+$('#ventasGravadas').val()+'</td> </tr>';

                  HTML+='<tr><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Sumas</td><td>'+$('#noAfectas').val()+'</td><td>0</td><td>'+$('#ventasGravadas').val()+'</td></tr>';

                  HTML+='<tr><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Total</td><td></td><td></td><td>'+$('#Total').val()+'</td></tr>';
                  HTML+='</table></div></div><div id="divFooter" style="width: 100%; height: 56.69px;"></div></div>';

                    var pantalla=window.open(' ','popimpr');
                    pantalla.document.write('<link href="<?= base_url() ?>plantilla/css/bootstrap.min.css" rel="stylesheet" />');
                  pantalla.document.write(HTML);
                  pantalla.document.close();
                  self.location ="<?= base_url()?>Facturas/FacturarCreditosPopulares";
                  //pantalla.print();
                  //pantalla.close();

        //pantalla.document.write(elemento.innerHTML);
     // pantalla.document.write('</body></html>');
      //pantalla.document.close();
      pantalla.focus();
      pantalla.onload = function() {
        pantalla.print();
        pantalla.close();
      };
      }, 6000);
                }//fin success
              });

      }
      else{
        // alert('seleccione una fecha de aplicacion');
          $(document).ready(function(){
            $.Notification.autoHideNotify('info', 'top center', 'Aviso!', 'seleccione una fecha de aplicacion.');
          });
      }
    });
  });
  function abrirFecha(id){
    // alert(id);
    document.getElementById('div1').style.display='none';
    document.getElementById('divFechas').style.display='block';
    //document.getElementById('divBuscar').style.display='none';
    $('#idCredito').val(id);
  }
</script>
