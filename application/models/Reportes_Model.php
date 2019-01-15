<?php 
class Reportes_Model extends CI_Model
{
	public function ReporteIva()
	{
		//$sql = "SELECT dp.idDetallePago, dp.totalPago, dp.interes, dp.iva, c.idCredito, c.codigoCredito, c.tipoCredito, c.fechaVencimiento, cl.Codigo_Cliente, cl.Nombre_Cliente, cl.Apellido_Cliente FROM tbl_detallepagos as dp INNER JOIN tbl_creditos as c ON(dp.idCredito = c.idCredito) INNER JOIN tbl_amortizaciones as a ON(c.idAmortizacion = a.idAmortizacion) INNER JOIN tbl_solicitudes as s ON(a.idSolicitud = s.idSolicitud) INNER JOIN tbl_clientes as cl ON(s.idCliente = cl.Id_Cliente)";
		$sql = "SELECT SUM(dp.interes) as interes, SUM(dp.iva) as iva, c.idCredito, c.codigoCredito, c.tipoCredito, c.fechaVencimiento, cl.Codigo_Cliente, cl.Nombre_Cliente, cl.Apellido_Cliente FROM tbl_detallepagos as dp INNER JOIN tbl_creditos as c ON(dp.idCredito = c.idCredito) INNER JOIN tbl_amortizaciones as a ON(c.idAmortizacion = a.idAmortizacion) INNER JOIN tbl_solicitudes as s ON(a.idSolicitud = s.idSolicitud) INNER JOIN tbl_clientes as cl ON(s.idCliente = cl.Id_Cliente) GROUP BY dp.idCredito";
		$datos = $this->db->query($sql);
		return $datos;
	}
}
?>