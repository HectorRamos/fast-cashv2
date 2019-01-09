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
		// $this->load->model('Reportes_Model');
		// $fechaI = $_POST['fechaInicialTrabajos'];
		// $fechaF = $_POST['fechaFinalTrabajos'];
		// $datos = $this->Reportes_Model->seleccionarTrabajos($fechaI, $fechaF);

		// if (sizeof($datos->result())!=0) 
		// {
		// 	$this->load->library('M_pdf');

	 //        $data = [];

	 //        $hoy = date("dmyhis");
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

     $pdfFilePath = "resumen.pdf";
     //load mPDF library
    $this->load->library('M_pdf');
     $mpdf = new mPDF('c', 'A4'); 

     $estilos=file_get_contents(base_url()."plantilla/css/bootstrap.min.css");
     //echo $estilos;
     $mpdf->SetDisplayMode('fullpage');
     $mpdf->WriteHTML($estilos,1);

    $mpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
   // $mpdf->SetFont('','',40); 
     $mpdf->shrink_tables_to_fit = 1;
   
    $mpdf->WriteHTML($html);


    $mpdf->Output($pdfFilePath, "I");

	}
	
}

?>