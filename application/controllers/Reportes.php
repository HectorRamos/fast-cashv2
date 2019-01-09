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
		
	}
	
}

?>