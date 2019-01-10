<style>
  #tablaImprimir{
    display: none;
  }
</style>
<div class="content-page">
  <div class="content">
    <div class="container">
      <!-- Page-Title -->
      <div class="row">
        <div class="col-md-12">
          <ol class="breadcrumb pull-right">
            <li><a href="<?= base_url() ?>Reportes/">Reportes</a></li>
            <li class="active">reporte general</li>
          </ol>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="table-title">
                <div class="row">
                  <div class="col-md-5">
                    <h3 class="panel-title">Reporte general de créditos</h3>                 
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div class="margn">
                <table class="table">
                  <div class="pull-left"></div>
                  <div class="pull-right">
                    <a title='Ver en PDF' href="<?= base_url() ?>Reportes/ReporteGeneralPDF" target="_blank" type='button' class='btn btn-danger block waves-effect waves-light m-b-5'><i class='fa fa-file fa-lg'></i> Ver en PDF </a> 
                    <a title='Aprobar Solicitud'  href="<?= base_url() ?>Reportes/ReporteGeneralEXCEL" target="_blank" type='button' class='btn btn-success block waves-effect waves-light m-b-5'><i class='fa fa-file fa-lg'></i> Excel </a>
                    <a title="Imprimir Solicitud" type="button" onclick="imprimirTabla()" class="btn btn-info block waves-effect waves-light m-b-5" data-toggle="tooltip" data-dismiss="modal"><i class="fa fa-print  fa-lg"></i> Imprimir</a>
                  </div>
               </table>
                <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="margn">
                                <table id="datatable" class="table">
                                  <thead class="thead-dark thead thead1">
                                    <tr class="tr tr1">
                                      <th class="th th1" scope="col">#</th>
                                      <th class="th th1" scope="col">Código de Cliente</th>
                                      <th class="th th1" scope="col">Cliente</th>
                                      <th class="th th1" >Tipo de Crédito</th>
                                      <th class="th th1" >Total a Pagar</th>
                                      <th class="th th1" >Total Abonado</th>
                                      <th class="th th1" >Estado</th>
                                      <!-- <th  class="th th1">Acción</th> -->
                                    </tr>
                                  </thead>
                                  <tbody class="tbody tbody1">
                                   <?php  
                                    $i = 0;
                                    if(!empty($datos)){
                                    foreach ($datos->result() as $creditos) {
                                    $i = $i +1;
                                    // if($creditos->estadoCredito=="Finalizado"){
                                    ?>
                                     <tr class="tr tr1">
                                      <td class="td td1" data-label="#" style="min-width: 10px; width: auto;"><b><?= $i;?></b></td>
                                      <td class="td td1" data-label="Código de Cliente"><?= $creditos->Codigo_Cliente?></td>
                                      <td class="td td1" data-label="Cliente"><?= $creditos->Nombre_Cliente?>  <?=  $creditos->Apellido_Cliente?></td>
                                      <td class="td td1" data-label="Tipo de Crédito"><?= $creditos->tipoCredito?></td>
                                      <td class="td td1" data-label="Total a Pagar"><span class="label label-default" style="font-size: 1.2rem; font-family: Arial;">$ <?= $creditos->capital?></span></td>
                                      <td class="td td1" data-label="Total Abonado"><span class="label label-warning" style="font-size: 1.2rem; font-family: Arial;">$ <?= $creditos->totalAbonado?></span></td>
                                      <td class="td td1" data-label="Total Abonado"><span class="" style="font-size: 1.2rem; font-family: Arial;"> <?= $creditos->estadoCredito?></span></td>
                                      <!-- <td class="td td1" data-label="Acción" style="min-width: 90px;">
                                        <a href="<?= base_url()?>Creditos/DetalleCredito?id=<?= $creditos->idCredito?>&cc=<?= $creditos->codigoCredito?>" title='Ver crédito' data-toggle="tooltip" class='waves-effect waves-light ver'><i class='fa fa-folder'></i></a>
                                         <a style="display: none;" href="<?= base_url()?>Pagos/PagarCredito?Id=<?= $creditos->idCredito?>" title='Realizar&nbsp;pago' data-toggle="tooltip" class='waves-effect waves-light agregar'><i class='fa fa-money'></i></a>
                                      </td> -->
                                    </tr>
                                  <?php }} ?>
                                  </tbody>
                                </table>

                                <div id="tablaImprimir">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-md-push-2 pull-left">
                                        <img src="<?= base_url() ?>plantilla/images/fc_logoR.png" width="100" height="100">
                                      </div>
                                      <div class="col-md-4 col-md-pull-2 text-center">
                                        <p><strong>GOCAJAA GROUP SA DE CV</strong></p>
                                        <p><strong>MERCEDES UMAÑA, USULUTAN</strong></p>
                                        <p><strong>REPORTE GENERAL DE CRÉDITOS</strong></p>
                                      </div>
                                      <div class="col-md-4  pull-right"></div>
                                    </div>
                                  </div>
                                  <table class="table">
                                      <thead class="">
                                        <tr>
                                          <th>#</th>
                                          <th>Código de Cliente</th>
                                          <th>Cliente</th>
                                          <th>Tipo de Crédito</th>
                                          <th>Total a Pagar</th>
                                          <th>Total Abonado</th>
                                          <th>Estado</th>
                                          <!-- <th  class="th th1">Acción</th> -->
                                        </tr>
                                      </thead>
                                      <tbody class="tbody tbody1">
                                         <?php  
                                          $i = 0;
                                          if(!empty($datos))
                                          {
                                            foreach ($datos->result() as $creditos)
                                            {
                                              $i = $i +1;
                                              ?>
                                               <tr>
                                                <td><b><?= $i;?></b></td>
                                                <td><?= $creditos->Codigo_Cliente?></td>
                                                <td><?= $creditos->Nombre_Cliente?>  <?=  $creditos->Apellido_Cliente?></td>
                                                <td><?= $creditos->tipoCredito?></td>
                                                <td>$ <?= $creditos->capital?></td>
                                                <td>$ <?= $creditos->totalAbonado?></td>
                                                <td><?= $creditos->estadoCredito?></td>
                                              </tr>
                                        <?php }} ?>
                                        </tbody>
                                  </table>
                                </div>


                              </div>
                            </div>
                        </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div> <!-- End Row -->

    </div>
  </div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

<script>
    function imprimirTabla()
    {
      // $(".ocultarImprimir").hide();
      var elemento=document.getElementById('tablaImprimir');
      var pantalla=window.open(' ','popimpr');

      pantalla.document.write('<html><head><title>' + document.title + '</title>');
      pantalla.document.write('<link href="<?= base_url() ?>plantilla/css/bootstrap.min.css" rel="stylesheet" />');
      pantalla.document.write('</head><body >');

      pantalla.document.write(elemento.innerHTML);
      pantalla.document.write('</body></html>');
      pantalla.document.close();
      pantalla.focus();
      pantalla.onload = function() {
        pantalla.print();
        pantalla.close();
      };
       $(".ocultarImprimir").show();
    }
</script>