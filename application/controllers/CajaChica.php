<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CajaChica extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("CajaChica_Model");
	}
	public function index()
	{
		$datos = $this->CajaChica_Model->ObtenerCajaActiva();
		$tipoPago = $this->CajaChica_Model->ObtenerTiposDePago();
		$data = array('datos'=>$datos, 'tipoPago'=>$tipoPago);

		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$this->load->view("CajaChica/index", $data);
		$this->load->view('Base/footer');
	}

	public function AperturarCaja()
	{
		$datos = $this->input->post();
		$bool = $this->CajaChica_Model->AperturarCaja($datos);
		if($bool){
				$this->session->set_flashdata("guardar","Se aperturo caja chica, <b>proceso</b> con éxito.");
				redirect(base_url()."CajaChica/"); 
		}
		else{
			$this->session->set_flashdata("errorr","Error en el <b>preceso</b> de aperturar caja chica.");
			redirect(base_url()."CajaChica/");

		}
	}

	public function GuardarProcesoCC()
	{
		$datos = $this->input->post();
		$bool = $this->CajaChica_Model->GuardarProcesoCC($datos);
		if($bool){
				$this->session->set_flashdata("guardar","Proceso <b>registrado</b> correctamente en caja chica.");
				redirect(base_url()."CajaChica/"); 
		}
		else{
			$this->session->set_flashdata("errorr","Error al <b>registrar</b> el proceso en caja.");
			redirect(base_url()."CajaChica/");

		}
	}

	public function CerrarCajaChica()
	{
		$datos = $this->input->post();
		$id=$datos['id_cc'];
		$bool = $this->CajaChica_Model->CerrarCajaChica($datos);
		if($bool){
				$this->session->set_flashdata("informa","Se cerro caja chica !!!");
				redirect(base_url()."CajaChica/DetalleCajaChica/$id"); 
		}
		else{
			$this->session->set_flashdata("errorr","Error al registrar el proceso");
			redirect(base_url()."CajaChica/");

		}
	}

	public function DetalleCajaChica($id)
	{
		$datos = $this->CajaChica_Model->DetalleCajaChica($id);
		// $tipoPago = $this->CajaChica_Model->ObtenerTiposDePago();
		$data = array('datos'=>$datos);

		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$this->load->view("CajaChica/detalle_caja_chica", $data);
		$this->load->view('Base/footer');
	}

	public function HistorialCajas()
	{
		$datos = $this->CajaChica_Model->HistorialCajas();
		$data = array('datos'=>$datos);
		$this->load->view('Base/header');
		$this->load->view('Base/nav');
		$this->load->view("CajaChica/historial_cajas", $data);
		$this->load->view('Base/footer');
	}


}
?>