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
		$datos = $this->Creditos_Model->ObtenerCreditos();
		$data = array('datos' => $datos );
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$this->load->view('Reportes/general', $data);
		$this->load->view('Base/footer');
	}
	public function ReporteGeneralPDF()
	{
	$datos = $this->Creditos_Model->ObtenerCreditos();
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
	

	public function ReporteGeneralEXCEL()
	{
    $creditos =  $this->Creditos_Model->ObtenerCreditos()->result();
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
        $this->excel->getActiveSheet()->setCellValue("B2", "REPORTE GENERAL DE CRÉDITOS");
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
								$html.= "<td colspan='9' class='text-center'><strong>ÚLTIMOS PROCESOS EFECTUADOS</strong></td>";
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

}
?>