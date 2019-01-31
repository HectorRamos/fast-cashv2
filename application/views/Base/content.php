            <!-- ============================================================== -->
             <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
<!--                         <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Inicio</h4>
                                <ol class="breadcrumb pull-right">
                                    <li class="active"><i class="fa fa-bookmark fa-lg"></i></li>
                                </ol>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mini-stat clearfix bx-shadow">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="imgWrapper4">
                                                <div class="imgResponsiva">
                                                    <img src="<?= base_url()?>plantilla/images/fc_logo.png" class="img-responsive" alt="Logo" style="width: 170px;">
                                                </div>
                                                <div class="imgResponsiva">
                                                    <img src="<?= base_url()?>plantilla/images/fast_cash.png" class="img-responsive" alt="Logo" style="width: 300px;">
                                                </div>
                                                <div class="imgResponsiva pull-right">
                                                    <h3 style="margin-top: 40px;">GOCAJAA GROUP, S.A.DE C.V.</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start Widget -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-3">
                                <div class="bx-shadow" style="background: #FFF; padding: 2px; border-top-left-radius: 3px;border-top-right-radius: 3px; border-bottom: 1px solid #eee;">
                                    <center><p style="font-size: 17px; font-weight: bold; margin-top: 10px;">Crédito Popular</p></center>
                                </div>
                                <div class="mini-stat clearfix bx-shadow" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-info" style="background: #8D6E63;"><i class="ion-clipboard"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosAsignadosPopular;?></span>
                                            Créditos Asignados
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Asignados <span class="pull-right"><?= $cantidadCreditosAsignadosPopular;?>%</span></h5>
                                                    <div class="progress m-0">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="<?= $cantidadCreditosAsignadosPopular;?>" aria-valuemin="0" aria-valuemax="100"style="background: #8D6E63;"><?= $cantidadCreditosAsignadosPopular;?></div>
                                                    </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-info" style="background: #FFC107;"><i class="md md-description"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosEnMoraPopular;?></span>
                                            Créditos en Mora
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos en Mora <span class="pull-right"><?= $cantidadCreditosEnMoraPopular;?>%</span></h5>
                                                <div class="progress m-0">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="<?= $cantidadCreditosEnMoraPopular;?>" aria-valuemin="0" aria-valuemax="100"style="background: #FFC107;"><?= $cantidadCreditosEnMoraPopular;?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-info"><i class="ion-folder"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosAsignadosPopular - $cantidadCreditosEnMoraPopular;?></span>
                                            Créditos Solventes
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Solventes <span class="pull-right"><?= $cantidadCreditosAsignadosPopular - $cantidadCreditosEnMoraPopular;?>%</span></h5>
                                                <div class="progress m-0">
                                                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $cantidadCreditosAsignadosPopular - $cantidadCreditosEnMoraPopular;?>" aria-valuemin="0" aria-valuemax="100"><?= $cantidadCreditosAsignadosPopular - $cantidadCreditosEnMoraPopular;?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-3">
                                <div class="bx-shadow" style="background: #FFF; padding: 2px; border-top-left-radius: 3px;border-top-right-radius: 3px; border-bottom: 1px solid #eee;">
                                    <center><p style="font-size: 17px; font-weight: bold; margin-top: 10px;">Crédito Personal</p></center>
                                </div>
                                <div class="mini-stat clearfix bx-shadow"style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-purple" style="background: #CCCC33;"><i class="ion-ios7-paper"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosAsignadosPersonal;?></span>
                                            Créditos Asignados
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Asignados <span class="pull-right"><?= $cantidadCreditosAsignadosPersonal;?>%</span></h5>
                                                    <div class="progress m-0">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="<?= $cantidadCreditosAsignadosPersonal;?>" aria-valuemin="0" aria-valuemax="100"style="background: #CCCC33;"><?= $cantidadCreditosAsignadosPersonal;?></div>
                                                    </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-purple" style="background: #CC6600;"><i class="md md-assignment"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosEnMoraPersonal;?></span>
                                            Créditos en Mora
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos en Mora <span class="pull-right"><?= $cantidadCreditosEnMoraPersonal;?>%</span></h5>
                                                <div class="progress m-0">
                                                      <div class="progress-bar" role="progressbar" aria-valuenow="<?= $cantidadCreditosEnMoraPersonal;?>" aria-valuemin="0" aria-valuemax="100"style="background: #CC6600;"><?= $cantidadCreditosEnMoraPersonal;?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-success"><i class="fa fa-folder-open"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter"><?= $cantidadCreditosAsignadosPersonal - $cantidadCreditosEnMoraPersonal;?></span>
                                            Créditos Solventes
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Solventes <span class="pull-right"><?= $cantidadCreditosAsignadosPersonal - $cantidadCreditosEnMoraPersonal;?>%</span></h5>
                                                <div class="progress m-0">
                                                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $cantidadCreditosAsignadosPersonal - $cantidadCreditosEnMoraPersonal;?>" aria-valuemin="0" aria-valuemax="100"><?= $cantidadCreditosAsignadosPersonal - $cantidadCreditosEnMoraPersonal;?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-lg-3">
                                <div class="bx-shadow" style="background: #FFF; padding: 2px; border-top-left-radius: 3px;border-top-right-radius: 3px; border-bottom: 1px solid #eee;">
                                    <center><p style="font-size: 17px; font-weight: bold; margin-top: 10px;">Crédito Prendario</p></center>
                                </div>
                                <div class="mini-stat clearfix bx-shadow" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-success" style="background: #FF9966;"><i class="ion-document-text"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">20544</span>
                                            Créditos Asignados
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Asignados <span class="pull-right">60%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: #FF9966;">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-success" style="background: #33CC99;"><i class="ion-ios7-paper-outline"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">20544</span>
                                            Créditos en Mora
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos en Mora <span class="pull-right">60%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;background: #33CC99;">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-danger" style="background: #F44336;"><i class="md md-folder-shared"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">20544</span>
                                            Créditos Solventes
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Solventes <span class="pull-right">60%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: #F44336;">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-3">
                                <div class="bx-shadow" style="background: #FFF; padding: 2px; border-top-left-radius: 3px;border-top-right-radius: 3px; border-bottom: 1px solid #eee;">
                                    <center><p style="font-size: 17px; font-weight: bold; margin-top: 10px;">Crédito Mixto</p></center>
                                </div>
                                <div class="mini-stat clearfix bx-shadow" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-warning" style="background: #009688;"><i class="md   md-my-library-books"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">5210</span>
                                            Créditos Asignados
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Asignados <span class="pull-right">57%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%; background: #009688;">
                                                        <span class="sr-only">57% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-warning" style="background: #999966;"><i class=" ion-ios7-copy"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">5210</span>
                                            Créditos en Mora
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos en Mora <span class="pull-right">57%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%; background: #999966;">
                                                        <span class="sr-only">57% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                    <hr>
                                    <br>
                                    <a href="">
                                        <span class="mini-stat-icon bg-warning" style="background: #607D8B;"><i class="ion-filing"></i></span>
                                        <div class="mini-stat-info text-right text-muted">
                                            <span class="counter">5210</span>
                                            Créditos Solventes
                                        </div>
                                        <div class="tiles-progress">
                                            <div class="m-t-20">
                                                <h5 class="text-uppercase">Créditos Solventes <span class="pull-right">57%</span></h5>
                                                <div class="progress progress-sm m-0">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%; background: #607D8B;">
                                                        <span class="sr-only">57% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> 
                        <!-- End row-->

                    </div> <!-- container -->
                               
                </div> <!-- content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
<style type="text/css">
.imgWrapper4 {
    font-size: 0;
    /*text-align: center;*/
}
.imgWrapper4 .imgResponsiva {
    display: inline-block;
    font-size: inherit;
}
/*.imgWrapper4 .imgResponsiva {width: 50%; max-width: 345px;}*/

.imgResponsiva img {
    height: auto;
    width: 100%;
}
</style>
<script type="text/javascript">
    var delay = 500;
        $(".progress-bar").each(function(i){
            $(this).delay( delay*i ).animate( { width: $(this).attr('aria-valuenow') + '%' }, delay );

            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: delay,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now)+'%');
                }
            });
        });
</script>



