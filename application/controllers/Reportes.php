<?php 
class Reportes extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	    if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Creditos_Model");
		$this->load->model("Reportes_Model");
	}
	public function index()
	{
		// $datos = $this->Creditos_Model->ObtenerCreditos();
		// $data = array('datos' => $datos );
		// $this->load->view('Base/header');
		// $this->load->view('Base/nav');
		// $this->load->view('Reportes/general', $data);
		// $this->load->view('Base/footer');
	}

	public function General($val)
	{
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		if ($val==1) 
		{
			$datos = $this->Creditos_Model->ObtenerCreditos();
			$data = array('datos' => $datos );
		}
		else{
			$datos = $this->input->post();
			$i = $datos['fechaInicial'];
			$f = $datos['fechaFinal'];
			$datos = $this->Reportes_Model->ObtenerCreditosFecha($i, $f);
			$data = array('datos' => $datos, 'i' => $i, 'f' => $f);
		}

		$this->load->view('Reportes/general', $data);
		$this->load->view('Base/footer');
	}


	public function ReporteGeneralPDF($val)
	{
	if ($val==1) 
	{
		$datos = $this->Creditos_Model->ObtenerCreditos();
	}
	else{
		$i = $_GET['i'];
		$f = $_GET['f'];
		$datos = $this->Reportes_Model->ObtenerCreditosFecha($i, $f);
	}
	if (sizeof($datos) != 0)
	{
	
	$html="
	<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
	<script src='".base_url()."plantilla/js/jquery.min.js'></script>
	<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
	<style>
	img {
	    text-align:left;
	    float:left;
	    width: 120px;
	    height: 100px;

	}

	#cabecera{
		width: 1000px;
	}
	#img{
		float:left;
		margin-left: 20px;
		width: 150px;

	}
	.textoCentral{
		color: #000;
		font-weight: bold;
		float:right;
		padding-left: 30px;
		margin: 0 auto;
		text-align: center;
		line-height:: 50;
		line-height: 26px;
		width: 400px
	}
	#creditos{
	font-size:12px;
}
</style>
	 <div class='container'>
	    <div class='row' id='cabecera'>
	            <div class='col-md-4 pull-left' id='img'>
	                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
	            </div>
	            <div class='col-md-4 textoCentral' id=''>
	                <p>GOCAJAA GROUP SA DE CV <br>
	                MERCEDES UMAÑA, USULUTAN <br>
	                REPORTE GENERAL DE CRÉDITOS<br> 
	            </div>
	    </div>
	    <strong style='font-weight: bold;'></strong><br><br>
	    <div>
	        <table class='table table-bordered' id='creditos'>
	            <thead class=''>
	            	<tr>";
	         if (isset($i) && isset($f))
	            {
	                $html.="<td colspan='9' class='text-center'><strong>PROCESOS EFECTUADOS ENTRE EL ".$i." Y ".$f."</strong></td>";
	            }
	            else
	            {
					$html.= "<td colspan='9' class='text-center'><strong>REPORTE GENERAL DE CRÉDITOS HASTA EL ".date('d-m-Y')."</strong></td>";
	            }   			
	       $html .= "</tr>
	       			<tr>
	                  <th class='text-center'>Código de Cliente</th>
	                  <th class='text-center'>Cliente</th>
	                  <th class='text-center'>Tipo de Crédito</th>
	                  <th class='text-center'>Total a Pagar</th>
	                  <th class='text-center'>Total Abonado</th>
	                  <th class='text-center'>Estado</th>
	                </tr>
	              </thead>
	            <tbody>
	            ";
	foreach ($datos->result() as $creditos) {
		$i = $i +1;
		$html .= "	<tr>";
        $html .= "      <td class='text-center'> $creditos->Codigo_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->Nombre_Cliente    $creditos->Apellido_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->tipoCredito</td>";
        $html .= "      <td class='text-center'> $  $creditos->capital</td>";
        $html .= "      <td class='text-center'> $  $creditos->totalAbonado</td>";
        $html .= "      <td class='text-center'> $creditos->estadoCredito</td>";
        $html .= "  </tr>";
	}
	    
	$html .= "</tbody>
	        </table>
	    </div>
	</div>";

     $pdfFilePath = "reporte_general_de_creditos.pdf";
     //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); //Orientacion
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "I");

    }
    else
    {
    	echo '<script type="text/javascript">
			alert("No hay datos que mostrar !!!");
			window.close();
			self.location ="'.base_url().'Reportes/General/1"
			</script>';
    }

	}
	

	public function ReporteGeneralEXCEL($val)
	{
		if ($val==1) 
	{
		$creditos = $this->Creditos_Model->ObtenerCreditos()->result();
	}
	else{
		$i = $_GET['i'];
		$f = $_GET['f'];
		$creditos = $this->Reportes_Model->ObtenerCreditosFecha($i, $f)->result();
	}
    if(count($creditos) > 0){
        //Cargamos la librería de excel.
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Creditos');
        //Contador de filas
        $contador = 4;

        //Cabecera
		$styleArray = array(
			'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		);

		$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($styleArray);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B1:E1');
        $this->excel->setActiveSheetIndex(0)->mergeCells('B2:E2');
        $this->excel->setActiveSheetIndex(0)->mergeCells('B3:E3');
        $this->excel->getActiveSheet()->setCellValue("B1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
        $this->excel->getActiveSheet()->setCellValue("B2", "REPORTE GENERAL DE CRÉDITOS");
        if (isset($i) && isset($f))
        {
    		$this->excel->getActiveSheet()->setCellValue("B3", "REPORTE GENERAL DE CREDITOS ENTRE LAS FECHAS ".$i." Y ".$f);
        }
        else
        {
    		$this->excel->getActiveSheet()->setCellValue("B3", "REPORTE GENERAL DE CREDITOS HASTA EL ". date('d-m-Y'));
        }
        // Fin cabecera

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        //Le aplicamos negrita a los títulos de la cabecera.
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código del cliente');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cliente');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Tipo de crédito');
        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Total a pagar');
        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Total abonado');
        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
        //Definimos la data del cuerpo.        
        foreach($creditos as $credito){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.
           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $credito->Codigo_Cliente);
           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $credito->Nombre_Cliente." ".$credito->Apellido_Cliente);
           $this->excel->getActiveSheet()->setCellValue("C{$contador}", $credito->tipoCredito); 
           $this->excel->getActiveSheet()->setCellValue("D{$contador}", $credito->capital);
           $this->excel->getActiveSheet()->setCellValue("E{$contador}", $credito->totalAbonado);
           $this->excel->getActiveSheet()->setCellValue("F{$contador}", $credito->estadoCredito);
        }
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "reporte_general_creditos.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
     }
     else
     {
        echo 'No se han encontrado creditos';
        exit;        
     }
	}

	public function ReporteIva($val)
	{
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$p = $val;
		if ($p == 1)
		{
			$datos = $this->Reportes_Model->ReporteIva(null, null);
			$data = array('datos' => $datos );
		}
		else
		{
			$datos = $this->input->post();
			$i = $datos['fechaInicial'];
			$f = $datos['fechaFinal'];
			$datos = $this->Reportes_Model->ReporteIva($i, $f);
			$data = array('datos' => $datos, 'i' => $i, 'f' => $f);
		}
		$this->load->view('Reportes/iva', $data);
		$this->load->view('Base/footer');
	}

	public function ReporteIvaPDF($val)
	{
		$p = $val;
		if ($p == 1)
		{
			$datos = $this->Reportes_Model->ReporteIva(null, null);
		}
		else
		{
			$i = $_GET['i'];
			$f = $_GET['f'];
			$datos = $this->Reportes_Model->ReporteIva($i, $f);
		}
		if (sizeof($datos->result())>0)
		{
			$html="
			<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
			<script src='".base_url()."plantilla/js/jquery.min.js'></script>
			<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
			<style>
			img {
			    text-align:left;
			    float:left;
			    width: 120px;
			    height: 100px;

			}

			#cabecera{
				width: 1000px;
			}
			#img{
				float:left;
				margin-left: 20px;
				width: 150px;

			}
			.textoCentral{
				color: #000;
				font-weight: bold;
				float:right;
				padding-left: 30px;
				margin: 0 auto;
				text-align: center;
				line-height:: 50;
				line-height: 26px;
				width: 400px
			}
			#creditos{
			font-size:12px;
		}
		</style>
			 <div class='container'>
			    <div class='row' id='cabecera'>
			            <div class='col-md-4 pull-left' id='img'>
			                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
			            </div>
			            <div class='col-md-4 textoCentral' id=''>
			                <p>GOCAJAA GROUP SA DE CV <br>
			                MERCEDES UMAÑA, USULUTAN <br>
			                REPORTE DE IVA<br> 
			            </div>
			    </div>
			    <strong style='font-weight: bold;'></strong><br><br>
			    <div>
			        <table class='table table-bordered' id='creditos'>
			            <thead class=''>
			            <tr>";
			            if (isset($i) && isset($f))
				            {
				                $html.="<td colspan='9' class='text-center'><strong>PROCESOS EFECTUADOS ENTRE EL ".$i." Y ".$f."</strong></td>";
				            }
				            else
				            {
								$html.= "<td colspan='9' class='text-center'><strong>ÚLTIMOS PROCESOS EFECTUADOS HASTA EL ".date('d-m-Y')."</strong></td>";
				            }
			      $html .= "</tr>
			      			<tr>
			                  <th class='text-center'>#</th>
                              <th class='text-center'>CÓDIGO CRÉDITO</th>
                              <th class='text-center'>CLIENTE</th>
                              <th class='text-center'>NETO</th>
                              <th class='text-center'>IVA</th>
                              <th class='text-center'>EXCENTO</th>
                              <th class='text-center'>IVA RETENIDO</th>
                              <th class='text-center'>TOTAL</th>
                              <th class='text-center'>OBSERVACIONES</th>
			                </tr>
			              </thead>
			            <tbody>
			            ";
			  $total = 0;
              $totalIVA = 0;
              $totalIntereses = 0;
			foreach ($datos->result() as $row) {
				$i = $i +1;
				$totalIVA = $totalIVA + $row->iva;
                $totalIntereses = $totalIntereses + $row->interes;
                $total = $total + $row->iva + $row->interes;
                $totalII = $row->iva + $row->interes; 
				$html .= "	<tr>";
		        $html .= "      <td class='text-center'> $i</td>";
		        $html .= "      <td class='text-center'> $row->codigoCredito</td>";
		        $html .= "      <td class='text-center'> $row->Nombre_Cliente    $row->Apellido_Cliente</td>";
		        $html .= "      <td class='text-center'> $".$row->interes."</td>";
		        $html .= "      <td class='text-center'> $".$row->iva."</td>";
		        $html .= "      <td class='text-center'> $0</td>";
		        $html .= "      <td class='text-center'> $0</td>";
		        $html .= "      <td class='text-center'>$".$totalII."</td>";
		        $html .= "      <td class='text-center'> --- </td>";
		        $html .= "  </tr>";
			}
			
			$html .= "	<tr>";
	        $html .= "      <td class='text-center' colspan='3'>TOTAL</td>";
	        $html .= "      <td class='text-center'>$ $totalIntereses</td>";
	        $html .= "      <td class='text-center'> $ $totalIVA</td>";
	        $html .= "      <td class='text-center'> </td>";
	        $html .= "      <td class='text-center'> </td>";
	        $html .= "      <td class='text-center'>$ $total</td>";
	        $html .= "      <td class='text-center'>".$row->iva + $row->interes."</td>";
	        $html .= "      <td class='text-center'> --- </td>";
	        $html .= "  </tr>";

			$html .= "</tbody>
			        </table>
			    </div>
			</div>";

		     $pdfFilePath = "reporte_iva.pdf";
		     //load mPDF library
		    $this->load->library('M_pdf');
		    $mpdf = new mPDF('c', 'A4-L'); //Orientacion
		    $mpdf->SetDisplayMode('fullpage');
		    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		    $mpdf->shrink_tables_to_fit = 1;
		    $mpdf->WriteHTML($html);
		    $mpdf->Output($pdfFilePath, "I");
		}
		else
		{
			echo '<script type="text/javascript">
				alert("No hay datos que mostrar !!!");
				window.close();
				self.location ="'.base_url().'Reportes/ReporteIva/1"
				</script>';
		}
	}
	public function ReporteIvaEXCEL($val)
	{
		$p = $val;
		if ($p == 1)
		{
			$datos = $this->Reportes_Model->ReporteIva(null, null)->result();
		}
		else
		{
			$i = $_GET['i'];
			$f = $_GET['f'];
			$datos = $this->Reportes_Model->ReporteIva($i, $f)->result();
		}
	    if(count($datos) > 0){
	        //Cargamos la librería de excel.
	        $this->load->library('excel');
	        $this->excel->setActiveSheetIndex(0);
	        $this->excel->getActiveSheet()->setTitle('Creditos');
	        //Contador de filas
	        $contador = 4;

	        //Cabecera
			$styleArray = array(
				'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ),
			);

			$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($styleArray);
	        $this->excel->setActiveSheetIndex(0)->mergeCells('B1:E1');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('B2:E2');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('B3:E3');
	        $this->excel->getActiveSheet()->setCellValue("B1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
	        $this->excel->getActiveSheet()->setCellValue("B2", "REPORTE DE IVA");
	        // Fin cabecera
	        if (isset($i) && isset($f))
	            {
	        		$this->excel->getActiveSheet()->setCellValue("B3", "REPORTE DE IVA ENTRE LAS FECHAS ".$i." Y ".$f);
	            }
	            else
	            {
	        		$this->excel->getActiveSheet()->setCellValue("B3", "REPORTE DE IVA EN LOS ÚLTIMOS PROCESOS EFECTUADOS");
	            }
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	        //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código crédito');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cliente');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Neto');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Iva');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Excento');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Iva retenido');
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Total');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Observaciones');
	        //Definimos la data del cuerpo.
	        $i = 0;
	        $total = 0;
	        $totalIVA = 0;
	        $totalIntereses = 0;        
	        foreach($datos as $row){
	           $contador++;
	           $totalIVA = $totalIVA + $row->iva;
	           $totalIntereses = $totalIntereses + $row->interes;
	           $total = $total + $row->iva + $row->interes;
	           $totalII = $row->iva + $row->interes; 
	           //Incrementamos una fila más, para ir a la siguiente.
	           //Informacion de las filas de la consulta.
	           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $row->codigoCredito);
	           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $row->Nombre_Cliente." ".$row->Apellido_Cliente);
	           $this->excel->getActiveSheet()->setCellValue("C{$contador}", "$".$row->interes); 
	           $this->excel->getActiveSheet()->setCellValue("D{$contador}", "$".$row->iva);
	           $this->excel->getActiveSheet()->setCellValue("E{$contador}", "$0");
	           $this->excel->getActiveSheet()->setCellValue("F{$contador}", "$0");
	           $this->excel->getActiveSheet()->setCellValue("G{$contador}", "$".$totalII);
	           $this->excel->getActiveSheet()->setCellValue("H{$contador}", "");
	        }
	        $contador = $contador + 1;
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", " ");
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", " ");
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", "$".$totalIntereses); 
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", "$".$totalIVA);
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", "$0");
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", "$0");
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", "$".$total);
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", "");

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "reporte_general_creditos.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
	     }
	     else
	     {
	       echo '<script type="text/javascript">
				alert("No hay datos que mostrar !!!");
				window.close();
				self.location ="'.base_url().'Reportes/ReporteIva/1"
				</script>';      
	     }
	}

	public function ResumenIva($val)
	{
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$p = $val;
		if ($p == 1)
		{
			$data = array('si' => false );
		}
		else
		{
			$datos = $this->input->post();
			$i = $datos['fechaInicial'];
			$f = $datos['fechaFinal'];
			$datos = $this->Reportes_Model->ReporteIva($i, $f)->result();
			$data = array('datos' => $datos, 'si' => true, 'fi' => $i, 'ff' => $f );
		}

		$this->load->view('Reportes/resumen_iva', $data);
		$this->load->view('Base/footer');
	}

	public function ResumenIvaPDF()
	{
		$i = $_GET['i'];
		$f = $_GET['f'];
		$datos = $this->Reportes_Model->ReporteIva($i, $f);
		if (sizeof($datos->result())>0)
			{
				$html="
				<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
				<script src='".base_url()."plantilla/js/jquery.min.js'></script>
				<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
				<style>
				img {
				    text-align:left;
				    float:left;
				    width: 120px;
				    height: 100px;

				}

				#cabecera{
					width: 1000px;
				}
				td, th{
					padding:10px;
				}
				#img{
					float:left;
					margin-left: 20px;
					width: 150px;

				}
				.textoCentral{
					color: #000;
					font-weight: bold;
					float:right;
					padding-left: 30px;
					margin: 0 auto;
					text-align: center;
					line-height:: 50;
					line-height: 26px;
					width: 400px
				}
				#creditos{
				font-size:12px;
			}
			</style>
				 <div class='container'>
				    <div class='row' id='cabecera'>
				            <div class='col-md-4 pull-left' id='img'>
				                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
				            </div>
				            <div class='col-md-4 textoCentral' id=''>
				                <p>GOCAJAA GROUP SA DE CV <br>
				                MERCEDES UMAÑA, USULUTAN <br>
				                REPORTE DE IVA<br> 
				            </div>
				    </div>
				    <strong style='font-weight: bold;'></strong><br><br>
				    <div class='col-md-12'>
	                  <p class='text-center'><strong>Libro de ventas a consumidores del $i al $f</strong></p>
	                </div>
				    <div>";
				  $contador=0;
                  $inicio = "";
                  $final = "";
                  $total = 0;
                  $totalIVA = 0;
                  $totalIntereses = 0;
                  foreach ($datos->result() as $row)
                  {
                    $totalIVA = $totalIVA + $row->iva;
                    $totalIntereses = $totalIntereses + $row->interes;
                    $total = $total + $row->iva + $row->interes; 
                    if ($contador == 0)
                    {
                      $inicio = $row->codigoSolicitud;
                    }
                    if ($contador == sizeof($datos))
                    {
                      $final = $row->codigoSolicitud;
                    }
                    $contador++;
                  }
				
				$html .= "<table class='table table-bordered' cellspacing='10'>
                  <thead>
                    <tr>
                      <th class='text-center' rowspan='2'>Fecha</th>
                      <th colspan='2' class='text-center'>Facturas</th>
                      <th class='text-center' rowspan='2'>Ventas no sujetas</th>
                      <th class='text-center' rowspan='2'>Ventas excentas</th>
                      <th colspan='4' class='text-center'>Ventas gravadas</th>
                      <th class='text-center' rowspan='2'>Ventas por terceros</th>
                    </tr>
                    <tr class='text-center'>
                      <td>Inicio</td>
                      <td>Fin</td>
                      <td>Locales</td>
                      <td>Exportaciones</td>
                      <td>IVA retenido</td>
                      <td>Venta Total</td>
                    </tr>
                    <tr class='text-center'>
                      <td>".date('d/m/Y')."</td>
                      <td>".$inicio ."</td>
                      <td>".$row->codigoSolicitud."</td>
                      <td>$ 0.00</td>
                      <td>$ 0.00</td>
                      <td>".$total."</td>
                      <td>$ 0.00</td>
                      <td>$ 0.00</td>
                      <td>$".$total."</td>
                      <td>---</td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Totales</strong></td>
                      <td>$ 0.00</td>
                      <td>$ 0.00</td>
                      <td>$".$total."</td>
                      <td>$ 0.00</td>
                      <td>$ 0.00</td>
                      <td>$".$total."</td>
                      <td>$0</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Ventas no sujetas</strong></td>
                      <td colspan='2'>$ 0.00</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Excentas</strong></td>
                      <td colspan='2'>$ 0.00</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Exportaciones</strong></td>
                      <td colspan='2'>$ 0.00</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Locales</strong></td>
                      <td colspan='2'>$".$total."</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Neto</strong></td>
                      <td colspan='2'>$".$totalIntereses."</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'>Impuesto</td>
                      <td colspan='2'><strong>$".$totalIVA."</strong></td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>(-) Iva retenido</strong></td>
                      <td colspan='2'>$000</td>
                      <td colspan='5'></td>
                    </tr>
                    <tr class='text-center'>
                      <td colspan='3'><strong>Total</strong></td>
                      <td colspan='2'>$".$total."</td>
                      <td colspan='4'></td>
                    </tr>
                  </tbody>
               </table>
               <!-- fin tabla -->
               <br><br><br>
              <p class='text-center'><strong>Nombre o firma del contribuyente </strong>________________________________________________</p>";

				$html .= "</div>
						</div>";

			     $pdfFilePath = "reporte_iva.pdf";
			     //load mPDF library
			    $this->load->library('M_pdf');
			    $mpdf = new mPDF('c', 'A4'); //Orientacion
			    $mpdf->SetDisplayMode('fullpage');
			    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			    $mpdf->shrink_tables_to_fit = 1;
			    $mpdf->WriteHTML($html);
			    $mpdf->Output($pdfFilePath, "I");
			}
			else
			{
				echo '<script type="text/javascript">
					alert("No hay datos que mostrar !!!");
					window.close();
					self.location ="'.base_url().'Reportes/ReporteIva/1"
					</script>';
			}		
	}

	public function ResumenIvaEXCEL()
	{
		$i = $_GET['i'];
		$f = $_GET['f'];
		$datos = $this->Reportes_Model->ReporteIva($i, $f)->result();
		if(count($datos) > 0)
		{
	        //Cargamos la librería de excel.
	        $this->load->library('excel');
	        $this->excel->setActiveSheetIndex(0);
	        $this->excel->getActiveSheet()->setTitle('Iva');
	        //Contador de filas
	        $contador = 4;

	        //Cabecera
			$styleArray = array(
				'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ),
			);

			$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($styleArray);
			for ($j=4; $j < 20; $j++)
			{ 
				$this->excel->getActiveSheet()->getStyle('A'.($j).':I'.($j))->applyFromArray($styleArray);
			}
	        $this->excel->setActiveSheetIndex(0)->mergeCells('D1:G1');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('D2:G2');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('D3:G3');
	        $this->excel->getActiveSheet()->setCellValue("D1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
	        $this->excel->getActiveSheet()->setCellValue("D2", "REPORTE DE IVA");
	        // Fin cabecera
        	$this->excel->getActiveSheet()->setCellValue("D3", "Libro de ventas a consumidores del ".$i." al ".$f);
            
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	        //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
	        
	        //Definimos los títulos de la cabecera.
	        $this->excel->setActiveSheetIndex(0)->mergeCells('B4:C4');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('F4:H4');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('D4:D5');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('E4:E5');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('J4:J5');

	        // primer fila
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Fecha');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Facturas');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Ventas excentas');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Ventas no sujetas');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Ventas gravadas');
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Ventas por terceros');
	        // fin primer fila
	        
	        // segunda fila
	        $this->excel->getActiveSheet()->setCellValue("B5", 'Inicio');
	        $this->excel->getActiveSheet()->setCellValue("C5", 'Fin');
	        $this->excel->getActiveSheet()->setCellValue("F5", 'Locales');
	        $this->excel->getActiveSheet()->setCellValue("G5", 'Exportaciones');
	        $this->excel->getActiveSheet()->setCellValue("H5", 'Iva retenido');
	        $this->excel->getActiveSheet()->setCellValue("I5", 'Venta total');
	        // fin segunda fila

	          $contador=0;
	          $inicio = "";
	          $final = "";
	          $total = 0;
	          $totalIVA = 0;
	          $totalIntereses = 0;
	          foreach ($datos as $row)
	          {
	            $totalIVA = $totalIVA + $row->iva;
	            $totalIntereses = $totalIntereses + $row->interes;
	            $total = $total + $row->iva + $row->interes; 
	            if ($contador == 0)
	            {
	              $inicio = $row->codigoSolicitud;
	            }
	            $contador++;
	          }
	         $final = $row->codigoSolicitud;
	        // tercera fila
	       	$this->excel->getActiveSheet()->setCellValue("A6", date('d/m/Y'));
	        $this->excel->getActiveSheet()->setCellValue("B6", $inicio);
	        $this->excel->getActiveSheet()->setCellValue("C6", $final);
	        $this->excel->getActiveSheet()->setCellValue("D6", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("E6", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("F6", "$".$total);
	        $this->excel->getActiveSheet()->setCellValue("H6", "$".$total);
	        $this->excel->getActiveSheet()->setCellValue("G6", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("I6", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("J6", '---');
	        // fin tercera fila

	        // cuarta fila
	        $this->excel->setActiveSheetIndex(0)->mergeCells('A7:C7');

	       	$this->excel->getActiveSheet()->setCellValue("A7", "Totales");
	        $this->excel->getActiveSheet()->setCellValue("D7", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("E7", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("F7", "$ ".$total);
	        $this->excel->getActiveSheet()->setCellValue("G7", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("H7", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("I7", "$ ".$total);
	        $this->excel->getActiveSheet()->setCellValue("J7", "---");
	        // fin cuarta fila

	        // Quinta fila
	        	for ($i=8; $i <= 15; $i++)
	        	{  
	        	$this->excel->setActiveSheetIndex(0)->mergeCells('A'.($i).':C'.($i)); 
	        	$this->excel->setActiveSheetIndex(0)->mergeCells('D'.($i).':E'.($i)); 
	        	$this->excel->setActiveSheetIndex(0)->mergeCells('F'.($i).':J'.($i)); 
	        	}
	        // fin quinta fila


	        $this->excel->getActiveSheet()->setCellValue("A8", 'Ventas no sujetas');
	        $this->excel->getActiveSheet()->setCellValue("A9", 'Excentas');
	        $this->excel->getActiveSheet()->setCellValue("A10", 'Exportaciones');
	        $this->excel->getActiveSheet()->setCellValue("A11", 'Locales');
	        $this->excel->getActiveSheet()->setCellValue("A12", 'Neto');
	        $this->excel->getActiveSheet()->setCellValue("A13", 'Impuesto');
	        $this->excel->getActiveSheet()->setCellValue("A14", '(-)Iva retenido');
	        $this->excel->getActiveSheet()->setCellValue("A15", 'Total');

	        $this->excel->getActiveSheet()->setCellValue("D8", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("D9", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("D10", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("D11", "$ ".$total);
	        $this->excel->getActiveSheet()->setCellValue("D12", "$ ".$totalIntereses);
	        $this->excel->getActiveSheet()->setCellValue("D13", "$ ".$totalIVA);
	        $this->excel->getActiveSheet()->setCellValue("D14", '$ 0.00');
	        $this->excel->getActiveSheet()->setCellValue("D15", "$ ".$total);	        

	        $this->excel->setActiveSheetIndex(0)->mergeCells('A19:J20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('B19:B20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('C19:C20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('D19:D20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('E19:E20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('F19:F20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('G19:G20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('H19:H20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('I19:I20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('J19:J20');
	        $this->excel->setActiveSheetIndex(0)->mergeCells('A20:J20');
	        $this->excel->getActiveSheet()->setCellValue("A19", "Nombre o firma del contribuyente_______________________________________________________");	        



	        //Definimos la data del cuerpo.
	        // $i = 0;
	        // $total = 0;
	        // $totalIVA = 0;
	        // $totalIntereses = 0;        
	        // foreach($datos as $row){
	        //    $contador++;
	        //    $totalIVA = $totalIVA + $row->iva;
	        //    $totalIntereses = $totalIntereses + $row->interes;
	        //    $total = $total + $row->iva + $row->interes;
	        //    $totalII = $row->iva + $row->interes; 
	        //    //Incrementamos una fila más, para ir a la siguiente.
	        //    //Informacion de las filas de la consulta.
	        //    $this->excel->getActiveSheet()->setCellValue("A{$contador}", $row->codigoCredito);
	        //    $this->excel->getActiveSheet()->setCellValue("B{$contador}", $row->Nombre_Cliente." ".$row->Apellido_Cliente);
	        //    $this->excel->getActiveSheet()->setCellValue("C{$contador}", "$".$row->interes); 
	        //    $this->excel->getActiveSheet()->setCellValue("D{$contador}", "$".$row->iva);
	        //    $this->excel->getActiveSheet()->setCellValue("E{$contador}", "$0");
	        //    $this->excel->getActiveSheet()->setCellValue("F{$contador}", "$0");
	        //    $this->excel->getActiveSheet()->setCellValue("G{$contador}", "$".$totalII);
	        //    $this->excel->getActiveSheet()->setCellValue("H{$contador}", "");
	        // }
	        // $contador = $contador + 1;
	        // $this->excel->getActiveSheet()->setCellValue("A{$contador}", " ");
	        // $this->excel->getActiveSheet()->setCellValue("B{$contador}", " ");
	        // $this->excel->getActiveSheet()->setCellValue("C{$contador}", "$".$totalIntereses); 
	        // $this->excel->getActiveSheet()->setCellValue("D{$contador}", "$".$totalIVA);
	        // $this->excel->getActiveSheet()->setCellValue("E{$contador}", "$0");
	        // $this->excel->getActiveSheet()->setCellValue("F{$contador}", "$0");
	        // $this->excel->getActiveSheet()->setCellValue("G{$contador}", "$".$total);
	        // $this->excel->getActiveSheet()->setCellValue("H{$contador}", "");

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "reporte_general_creditos.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
	     }
		else
		{
			echo '<script type="text/javascript">
				alert("No hay datos que mostrar !!!");
				window.close();
				self.location ="'.base_url().'Reportes/ReporteIva/1"
				</script>';
		}		
	}

	public function CreditosPendientes($val){
		$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosProceso();
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosAprobados', $data);
			$this->load->view('Base/footer');
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosProcesoFecha($fechaInicial, $fechaFinal);
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosAprobados', $data);
			$this->load->view('Base/footer');
		}
	}
	public function ReportePendientesPDF($val)
	{
		$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosProceso();
			$descripcion = "REPORTE DE CREDITOS PENDIENTES";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosProcesoFecha($fechaInicial, $fechaFinal);
			$descripcion = "REPORTE DE CREDITOS PENDIENTES OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		}
	$html="
	<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
	<script src='".base_url()."plantilla/js/jquery.min.js'></script>
	<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
	<style>
	img {
	    text-align:left;
	    float:left;
	    width: 120px;
	    height: 100px;

	}

	#cabecera{
		width: 1000px;
	}
	#img{
		float:left;
		margin-left: 20px;
		width: 150px;

	}
	.textoCentral{
		color: #000;
		font-weight: bold;
		float:right;
		padding-left: 30px;
		margin: 0 auto;
		text-align: center;
		line-height:: 50;
		line-height: 26px;
		width: 400px
	}
	#creditos{
	font-size:12px;
}
</style>
	 <div class='container'>
	    <div class='row' id='cabecera'>
	            <div class='col-md-4 pull-left' id='img'>
	                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
	            </div>
	            <div class='col-md-4 textoCentral' id=''>
	                <p>GOCAJAA GROUP SA DE CV <br>
	                MERCEDES UMAÑA, USULUTAN <br>
	                ".$descripcion."<br> 
	            </div>
	    </div>
	    <strong style='font-weight: bold;'></strong><br><br>
	    <div>
	        <table class='table table-bordered' id='creditos'>
	            <thead class=''>
	                <tr>
	                  <th class='text-center'>Código de Cliente</th>
	                  <th class='text-center'>Cliente</th>
	                  <th class='text-center'>Tipo de Crédito</th>
	                  <th class='text-center'>Total a Pagar</th>
	                  <th class='text-center'>Total Abonado</th>
	                  <th class='text-center'>Estado</th>
	                </tr>
	              </thead>
	            <tbody>
	            ";
	foreach ($datos->result() as $creditos) {
		$i = $i +1;
		$html .= "	<tr>";
        $html .= "      <td class='text-center'> $creditos->Codigo_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->Nombre_Cliente    $creditos->Apellido_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->tipoCredito</td>";
        $html .= "      <td class='text-center'> $  $creditos->capital</td>";
        $html .= "      <td class='text-center'> $  $creditos->totalAbonado</td>";
        $html .= "      <td class='text-center'> $creditos->estadoCredito</td>";
        $html .= "  </tr>";
	}
	    
	$html .= "</tbody>
	        </table>
	    </div>
	</div>";

     $pdfFilePath = "reporte_de_creditos_pendientes.pdf";
     //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); //Orientacion
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "I");

	}
public function ReportePendientesEXCEL()
	{
    $p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosProceso();
			$descripcion = "REPORTE DE CREDITOS PENDIENTES";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosProcesoFecha($fechaInicial, $fechaFinal);
			$descripcion = "REPORTE DE CREDITOS PENDIENTES OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		}
    if(count($creditos) > 0){
        //Cargamos la librería de excel.
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Creditos');
        //Contador de filas
        $contador = 3;

        //Cabecera
		$styleArray = array(
			'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		);
		$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B1:E1');
        $this->excel->setActiveSheetIndex(0)->mergeCells('B2:E2');
        $this->excel->getActiveSheet()->setCellValue("B1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
        $this->excel->getActiveSheet()->setCellValue("B2", $descripcion);
        // Fin cabecera

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        //Le aplicamos negrita a los títulos de la cabecera.
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código del cliente');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cliente');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Tipo de crédito');
        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Total a pagar');
        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Total abonado');
        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
        //Definimos la data del cuerpo.        
        foreach($creditos as $credito){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.
           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $credito->Codigo_Cliente);
           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $credito->Nombre_Cliente." ".$credito->Apellido_Cliente);
           $this->excel->getActiveSheet()->setCellValue("C{$contador}", $credito->tipoCredito); 
           $this->excel->getActiveSheet()->setCellValue("D{$contador}", $credito->capital);
           $this->excel->getActiveSheet()->setCellValue("E{$contador}", $credito->totalAbonado);
           $this->excel->getActiveSheet()->setCellValue("F{$contador}", $credito->estadoCredito);
        }
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "reporte_general_creditos.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
     }
     else
     {
        echo 'No se han encontrado creditos';
        exit;        
     }
	}

	public function CreditosSaldados($val){
		$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosSaldados();
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosSaldados', $data);
			$this->load->view('Base/footer');
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosSaldadosFecha($fechaInicial, $fechaFinal);
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosSaldados', $data);
			$this->load->view('Base/footer');
		}
	}

	public function ReporteSaldadosPDF($val)
	{
	$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosSaldados();
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosSaldadosFecha($fechaInicial, $fechaFinal);
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		};
	$html="
	<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
	<script src='".base_url()."plantilla/js/jquery.min.js'></script>
	<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
	<style>
	img {
	    text-align:left;
	    float:left;
	    width: 120px;
	    height: 100px;

	}

	#cabecera{
		width: 1000px;
	}
	#img{
		float:left;
		margin-left: 20px;
		width: 150px;

	}
	.textoCentral{
		color: #000;
		font-weight: bold;
		float:right;
		padding-left: 30px;
		margin: 0 auto;
		text-align: center;
		line-height:: 50;
		line-height: 26px;
		width: 400px
	}
	#creditos{
	font-size:12px;
}
</style>
	 <div class='container'>
	    <div class='row' id='cabecera'>
	            <div class='col-md-4 pull-left' id='img'>
	                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
	            </div>
	            <div class='col-md-4 textoCentral' id=''>
	                <p>GOCAJAA GROUP SA DE CV <br>
	                MERCEDES UMAÑA, USULUTAN <br>
	                ".$descripcion."<br> 
	            </div>
	    </div>
	    <strong style='font-weight: bold;'></strong><br><br>
	    <div>
	        <table class='table table-bordered' id='creditos'>
	            <thead class=''>
	                <tr>
	                  <th class='text-center'>Código de Cliente</th>
	                  <th class='text-center'>Cliente</th>
	                  <th class='text-center'>Tipo de Crédito</th>
	                  <th class='text-center'>Total a Pagar</th>
	                  <th class='text-center'>Total Abonado</th>
	                  <th class='text-center'>Estado</th>
	                </tr>
	              </thead>
	            <tbody>
	            ";
	foreach ($datos->result() as $creditos) {
		$i = $i +1;
		$html .= "	<tr>";
        $html .= "      <td class='text-center'> $creditos->Codigo_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->Nombre_Cliente    $creditos->Apellido_Cliente</td>";
        $html .= "      <td class='text-center'> $creditos->tipoCredito</td>";
        $html .= "      <td class='text-center'> $  $creditos->capital</td>";
        $html .= "      <td class='text-center'> $  $creditos->totalAbonado</td>";
        $html .= "      <td class='text-center'> $creditos->estadoCredito</td>";
        $html .= "  </tr>";
	}
	    
	$html .= "</tbody>
	        </table>
	    </div>
	</div>";

     $pdfFilePath = "reporte_de_creditos_pendientes.pdf";
     //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); //Orientacion
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "I");

	}
	public function ReporteSaldadosEXCEL($val)
	{
    $p = $val;
		if($p ==1){
			$creditos = $this->Reportes_Model->CreditosSaldados()->result();
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$creditos = $this->Reportes_Model->CreditosSaldadosFecha($fechaInicial, $fechaFinal)->result();
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		};
    if(count($creditos) > 0){
        //Cargamos la librería de excel.
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Creditos');
        //Contador de filas
        $contador = 3;
        //Cabecera
		$styleArray = array(
			'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		);
		$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B1:E1');
        $this->excel->setActiveSheetIndex(0)->mergeCells('B2:E2');
        $this->excel->getActiveSheet()->setCellValue("B1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
        $this->excel->getActiveSheet()->setCellValue("B2", $descripcion);
        // Fin cabecera

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        //Le aplicamos negrita a los títulos de la cabecera.
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código del cliente');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cliente');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Tipo de crédito');
        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Total a pagar');
        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Total abonado');
        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
        //Definimos la data del cuerpo.        
        foreach($creditos as $credito){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.
           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $credito->Codigo_Cliente);
           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $credito->Nombre_Cliente." ".$credito->Apellido_Cliente);
           $this->excel->getActiveSheet()->setCellValue("C{$contador}", $credito->tipoCredito); 
           $this->excel->getActiveSheet()->setCellValue("D{$contador}", $credito->capital);
           $this->excel->getActiveSheet()->setCellValue("E{$contador}", $credito->totalAbonado);
           $this->excel->getActiveSheet()->setCellValue("F{$contador}", $credito->estadoCredito);
        }
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "reporte_general_creditos.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
     }
     else
     {
        echo 'No se han encontrado creditos saldados';
        exit;        
     }
	}
	public function CreditosMorosos($val){
		$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosMorosos();
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosMorosos', $data);
			$this->load->view('Base/footer');
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosMorososFecha($fechaInicial, $fechaFinal);
			$data = array('datos' => $datos );
			$this->load->view('Base/header');
			$this->load->view('Base/nav');
			$this->load->view('Reportes/viewCreditosMorosos', $data);
			$this->load->view('Base/footer');
		}	
	}
	public function ReporteMorososPDF($val){
		$p = $val;
		if($p ==1){
			$datos = $this->Reportes_Model->CreditosMorosos();
			$descripcion = "REPORTE DE CREDITOS EN MORA";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$datos = $this->Reportes_Model->CreditosMorososFecha($fechaInicial, $fechaFinal);
			$descripcion = "REPORTE DE CREDITOS EN MORA OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		}
	$html="
	<link href='".base_url()."plantilla/css/bootstrap.min.css' rel='stylesheet' />
	<script src='".base_url()."plantilla/js/jquery.min.js'></script>
	<script src='".base_url()."plantilla/js/bootstrap.min.js'></script>
	<style>
	img {
	    text-align:left;
	    float:left;
	    width: 120px;
	    height: 100px;

	}

	#cabecera{
		width: 1000px;
	}
	#img{
		float:left;
		margin-left: 20px;
		width: 150px;

	}
	.textoCentral{
		color: #000;
		font-weight: bold;
		float:right;
		padding-left: 30px;
		margin: 0 auto;
		text-align: center;
		line-height:: 50;
		line-height: 26px;
		width: 400px
	}
	#creditos{
	font-size:12px;
}
</style>
	 <div class='container'>
	    <div class='row' id='cabecera'>
	            <div class='col-md-4 pull-left' id='img'>
	                <img class='' width='' src='".base_url()."plantilla/images/fc_logoR.png'>
	            </div>
	            <div class='col-md-4 textoCentral' id=''>
	                <p>GOCAJAA GROUP SA DE CV <br>
	                MERCEDES UMAÑA, USULUTAN <br>
	                ".$descripcion."<br> 
	            </div>
	    </div>
	    <strong style='font-weight: bold;'></strong><br><br>
	    <div>
	        <table class='table table-bordered' id='creditos'>
	            <thead class=''>
	                <tr>
	                  <th class='text-center'>Código de Cliente</th>
	                  <th class='text-center'>Cliente</th>
	                  <th class='text-center'>Tipo de Crédito</th>
	                  <th class='text-center'>Total a Pagar</th>
	                  <th class='text-center'>Total Abonado</th>
	                  <th class='text-center'>Estado</th>
	                </tr>
	              </thead>
	            <tbody>
	            ";
	foreach ($datos->result() as $creditos) {

		$tipoCredito = $creditos->tipoCredito;
		$fechaActual = date("Y-m-d");
		if($tipoCredito =="Crédito popular mixto" || $tipoCredito =="Crédito popular prendario" ||  $tipoCredito =="Crédito popular hipotecario" || $tipoCredito =="Crédito popular"){
			$fechaComparacion = $creditos->fechaVencimiento;
			if($fechaActual<$fechaComparacion){
				$html .= "	<tr>";
		        $html .= "      <td class='text-center'> $creditos->Codigo_Cliente</td>";
		        $html .= "      <td class='text-center'> $creditos->Nombre_Cliente    $creditos->Apellido_Cliente</td>";
		        $html .= "      <td class='text-center'> $creditos->tipoCredito</td>";
		        $html .= "      <td class='text-center'> $  $creditos->capital</td>";
		        $html .= "      <td class='text-center'> $  $creditos->totalAbonado</td>";
		        $html .= "      <td class='text-center'> En mora</td>";
		        $html .= "  </tr>";
			}
			}
			else if($tipoCredito =="Crédito personal mixto" || $tipoCredito =="Crédito personal prendario" ||  $tipoCredito =="Crédito personal hipotecario" || $tipoCredito =="Crédito personal"){
				$fechaComparacion = $creditos->fechaProximoPago;
				if($fechaActual<$fechaComparacion){
					$html .= "	<tr>";
			        $html .= "      <td class='text-center'> $creditos->Codigo_Cliente</td>";
			        $html .= "      <td class='text-center'> $creditos->Nombre_Cliente    $creditos->Apellido_Cliente</td>";
			        $html .= "      <td class='text-center'> $creditos->tipoCredito</td>";
			        $html .= "      <td class='text-center'> $  $creditos->capital</td>";
			        $html .= "      <td class='text-center'> $  $creditos->totalAbonado</td>";
			        $html .= "      <td class='text-center'> En mora</td>";
			        $html .= "  </tr>";

				}
			}
		$i = $i +1;
	}    
	$html .= "</tbody>
	        </table>
	    </div>
	</div>";

     $pdfFilePath = "reporte_de_creditos_pendientes.pdf";
     //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); //Orientacion
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "I");

	}
	public function ReporteMorososEXCEL($val)
	{
     $p = $val;
		if($p ==1){
			$creditos = $this->Reportes_Model->CreditosMorosos()->result();
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS";
		}
		else if($p == 2){
			$fechaInicial = $this->input->GET('fechaInicial');
			$fechaFinal = $this->input->GET('fechaFinal');
			$creditos = $this->Reportes_Model->CreditosMorososFecha($fechaInicial, $fechaFinal)->result();
			$descripcion = "REPORTE DE CREDITOS FINALIZADOS OTORGADOS DESDE LA FECHA: ".$fechaInicial." HASTA LA FECHA: ".$fechaFinal;
		};
    if(count($creditos) > 0){
        //Cargamos la librería de excel.
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Creditos');
        //Contador de filas
        $contador = 3;

        //Cabecera
		$styleArray = array(
			'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		);
		$this->excel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
        $this->excel->setActiveSheetIndex(0)->mergeCells('B1:E1');
        $this->excel->setActiveSheetIndex(0)->mergeCells('B2:E2');
        $this->excel->getActiveSheet()->setCellValue("B1", "GOCAJAA GROUP SA DE CV, MERCEDES UMAÑA, USULUTAN");
        $this->excel->getActiveSheet()->setCellValue("B2", $descripcion);
        // Fin cabecera

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        //Le aplicamos negrita a los títulos de la cabecera.
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código del cliente');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cliente');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Tipo de crédito');
        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Total a pagar');
        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Total abonado');
        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado');
        //Definimos la data del cuerpo.        
        foreach($creditos as $credito){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.

           	$tipoCredito = $credito->tipoCredito;
			$fechaActual = date("Y-m-d");
		if($tipoCredito =="Crédito popular mixto" || $tipoCredito =="Crédito popular prendario" ||  $tipoCredito =="Crédito popular hipotecario" || $tipoCredito =="Crédito popular"){
			$fechaComparacion = $creditos->fechaVencimiento;
			if($fechaActual<$fechaComparacion){
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $credito->Codigo_Cliente);
	           	$this->excel->getActiveSheet()->setCellValue("B{$contador}", $credito->Nombre_Cliente." ".$credito->Apellido_Cliente);
	           	$this->excel->getActiveSheet()->setCellValue("C{$contador}", $credito->tipoCredito); 
	           	$this->excel->getActiveSheet()->setCellValue("D{$contador}", $credito->capital);
	           	$this->excel->getActiveSheet()->setCellValue("E{$contador}", $credito->totalAbonado);
	           	$this->excel->getActiveSheet()->setCellValue("F{$contador}", "En mora");

			}
		}
		else if($tipoCredito =="Crédito personal mixto" || $tipoCredito =="Crédito personal prendario" ||  $tipoCredito =="Crédito personal hipotecario" || $tipoCredito =="Crédito personal"){
				$fechaComparacion = $credito->fechaProximoPago;
			if($fechaActual<$fechaComparacion){
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $credito->Codigo_Cliente);
	           	$this->excel->getActiveSheet()->setCellValue("B{$contador}", $credito->Nombre_Cliente." ".$credito->Apellido_Cliente);
	           	$this->excel->getActiveSheet()->setCellValue("C{$contador}", $credito->tipoCredito); 
	           	$this->excel->getActiveSheet()->setCellValue("D{$contador}", $credito->capital);
	           	$this->excel->getActiveSheet()->setCellValue("E{$contador}", $credito->totalAbonado);
	           	$this->excel->getActiveSheet()->setCellValue("F{$contador}", "En mora");
			}
        }
    }
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "reporte_creditos_morosos.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
     }
     else
     {
        echo 'No se han encontrado creditos saldados';
        exit;        
     }
	}


	public function Infored()
	{
		$datos = $this->Reportes_Model->ReporteInfored();
		$data = array('datos' => $datos );
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$this->load->view("Reportes/infored", $data);
		$this->load->view('Base/footer');
	}
	public function ReporteInfored()
	{

	}
	
}
?>