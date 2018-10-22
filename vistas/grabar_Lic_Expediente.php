<?php 
	define('CONTROLADOR', false);
	require_once '../modelos/licenciasGDE.php';
//	$dni_participante = (isset($_REQUEST['Dni'])) ? $_REQUEST['Dni'] : null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$idExpediente = $_POST['idExpediente'];
	$nExpediente = $_POST['nExpediente'];
	$razonSocial = $_POST['razonSocial'];
	$ndirecEstab = $_POST['domicilio'];
	$aresEstab = $_POST['areaEstab'];
	$nResolGE = $_POST['nResolGE'];
	$nLicenciaGE = $_POST['nLicencia'];

	$participante2 = new Licencia();
	
	$participante2->setIdExpediente($idExpediente);
	$participante2->setRazonSocial($razonSocial);
	$participante2->setDomicilioEst($ndirecEstab);
	$participante2->setAreaEst($aresEstab);
	$participante2->SetNResolGDE($nResolGE);
	$participante2->SetNLicenciaGDE($nLicenciaGE);
	$participante2->guardar();
	
	//echo "<script language='javascript'>window.open('ImpresionLicencia2.php?nExpediente=$nExpediente','_blank', 'scrollbars=yes,width=950,height=700')</script>";
	echo "<script language='javascript'>window.open('ImpresionLicencia2.php?nExpediente=$nExpediente','_blank', 'scrollbars=yes,width=950,height=700');location.href='http://192.168.2.77/licencia/'</script>";
//	
}else{
	echo "HUBO PROBLEMAS AL ACTUALIZAR LOS DATOS, POR FAVOR COMUNICARSE CON INFORMATICA.";
}
?>