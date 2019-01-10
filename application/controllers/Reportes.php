<?php 
class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Creditos_Model");
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
	        <table class='table' id='creditos'>
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
}
?>