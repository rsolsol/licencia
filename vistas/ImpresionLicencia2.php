<?php 
define('CONTROLADOR', TRUE);
require_once '../modelos/Expediente.php';
require '../modelos/licenciasGDE.php';
$participante = new Expediente();
$nExpediente = (isset($_POST['nExpediente'])) ? $_REQUEST['nExpediente'] : null;
session_start();
$nExpediente=$_SESSION['nExpediente'];
$participante->setExpediente($nExpediente);
//comensamoa a buscar los datos del expediente
if ($nExpediente) {
    $participante = Expediente::buscaPorExpediente($nExpediente);
    /*debo crear una funcion para llamar la direccion    */
    $av_est = $participante->getDirecEst();
    $participante->getNumeroEst() ? $num_est = ' N° ' . $participante->getNumeroEst() : $num_est = '';
    $participante->getInteEst() ? $inte_est = ' INT. '. $participante->getInteEst() : $inte_est = '';
    $participante->getMzEst() ? $mz_est = ' MZ. '. $participante->getMzEst() : $mz_est = '';
    $participante->getLtEst() ? $lt_est = ' LT. '. $participante->getLtEst() : $lt_est = '';
    $participante->getNunPuestoEst() ? $psto_est = ' PSTO. '. $participante->getNunPuestoEst() : $psto_est = '';
    $participante->getStndEst() ? $stnd_est = ' STND. '. $participante->getStndEst() : $stnd_est = '';
    $ah_est = $participante->getNomDenomiEst(). ' ' . $participante->getDenoDesEst();
    $direEst = utf8_encode($av_est) . $num_est . $inte_est . $mz_est . $lt_est . $psto_est . $stnd_est . ' - ' . $ah_est;
}else{
    header('Location: \licencia');
}
/*Sacar informacion de la BD SISDECI */
$participante2 = new Licencia();
$participante2 = Licencia::buscarImpresion($participante->getIdSolicSol());
/*
echo 'Nro de Licencia GDE:' . $participante2->getNLicenciaGDE() . ' <br>';
echo 'listo para imprimir el Nro de Expediente es :' . $nExpediente . ' <br>';
echo 'Nro Resolucion GDE :' . $participante2->getNResolGDE() . ' <br>';*/
switch ($participante->getIdTTR()) {
    case '1':
        $dtllTRR = 'INDEFINIDO';
        break;
    case '3':
        $dtllTRR = 'TEMPORAL';
        break;
    case '4':
        $dtllTRR = 'CESIONARIO';
        break;
    default:
        $dtllTRR = '';
        break;
}
/*if ($participante->getIdTTR() == 1) {
    $dtllTRR = 'INDETERMINADA';    
}else {
    $dtllTRR = 'TEMPORAL';
}*/
/*
echo 'Razon Social : ' . $participante->getNonRazonSocial() . ' <br>';
echo 'Direccion completa del establecimiento :'. mb_strtoupper($direEst) . ' <br>';
echo 'Giro del Establecimiento : ' . $participante->getGiro() . ' <br>';
echo 'Servicio del Establecimiento :' . mb_strtoupper($participante->getActividadEconomica()) . ' <br>';
echo 'Area del Establecimiento :' . $participante->getAreatotal()  . ' mt2. <br>';
echo 'RUC del Establecimiento :' . $participante->getRuc()  . ' <br>';
*/
$fechalic= strtotime($participante2->getFechalicencia());
switch(date("m",$fechalic)){
    case "1":
        $mesmuni="ENERO";
        break;
    case "2":
        $mesmuni="FEBRERO";
        break;
    case "3":
        $mesmuni="MARZO";
        break;
    case "4":
        $mesmuni="ABRIL";
        break;
    case "5":
        $mesmuni="MAYO";
        break;
    case "6":
        $mesmuni="JUNIO";
        break;
    case "7":
        $mesmuni="JULIO";
        break;
    case "8":
        $mesmuni="AGOSTO";
        break;
    case "9":
        $mesmuni="SETIEMBRE";
        break;
    case "10":
        $mesmuni="OCTUBRE";
        break;
    case "11":
        $mesmuni="NOVIEMBRE";
        break;
    case "12":
        $mesmuni="DICIEMBRE";
        break;
}
error_reporting(E_ALL);
set_include_path('../src/'.PATH_SEPARATOR.get_include_path());
date_default_timezone_set('UTC');
include '../PDF2/src/Cezpdf.php';
class Creport extends Cezpdf
{
    public function __construct($p, $o, $t, $op)
    {
        parent::__construct($p, $o, $t, $op);
    }
}
$pdf = new Creport('a4', 'landscape', 'color', array(1, 1, 1));
if (strpos(PHP_OS, 'WIN') !== false) {
    $pdf->tempPath = 'C:/temp';
}
$pdf->ezSetMargins(20, 20, 20, 20);
$mainFont = 'Times-Roman';
//$mainFont = 'Times-Bold';
// select a font
$pdf->selectFont($mainFont);
$size = 16;
$height = $pdf->getFontHeight($size);
// modified to use the local file if it can
$pdf->openHere('Fit');
//$pdf->addPngFromFile('../images/ocr.png', 60, 410, 120, 120);
$pdf->addJpegFromFile('../images/ocr.jpg', 60, 410, 120, 120);

//$pdf->addText(190,400,16,'HOLA',1, 'left');
//$pdf->ezText("\n\n\n\n\n", 15);
/*$pdf->addText(190,320,14, '<b>'. $participante2->getNLicenciaGDE(). '</b>                                <b>' . $nExpediente . '</b>                               <b>' . $participante2->getNResolGDE(). '</b>                      ' . $dtllTRR, 0, array('justification'=>'left'));*/
$pdf->addText(187,312,14, ' <b>'. $participante2->getNLicenciaGDE(). '</b>                                <b>' . $nExpediente . '</b>                                 <b>' . $participante2->getNResolGDE(). '</b>                <b>' . $dtllTRR .'</b>', 0, array('justification'=>'left'));
$pdf->addText(180,198,11, ' <b>'.utf8_encode($participante->getNonRazonSocial()). '</b>');
$pdf->addText(180,176,12, ' <b>'. mb_strtoupper($direEst). '</b>');
if ($participante->getDetalleGiro()) {
    $pdf->addText(180,156,11, ' <b>'.utf8_encode($participante->getDetalleGiro()). '</b>');
}else {
    $pdf->addText(180,156,11, ' <b>'.utf8_encode($participante->getGiro()). '</b>');
}
$pdf->addText(180,135,13, ' <b>'.mb_strtoupper($participante->getActividadEconomica()). '</b>');
$pdf->addText(180,114.5,14,' <b>'. $participante->getAreatotal() . ' m.'. '</b>');
$pdf->addText(180,91.5,14, ' <b>'.$participante->getRuc(). '</b>');
$pdf->addText(675,40.5,12,'<b>'. date("d", $fechalic) .' DE '. $mesmuni . ' DE '. date("Y", $fechalic) . ' ', array('justification' => 'right')).'</b>';
//$pdf->addText("\n\n\n\n\n", 15);
//$pdf->addText(190,300,16, $participante2->getNLicenciaGDE(). '                                      ' . $nExpediente . '                                      ' . $participante2->getNResolGDE(). '                       ' . $dtllTRR, 0, array('justification'=>'left'));
//$pdf->ezText("\n\n\n\n\n\n\n\n\n\n\n\n\n", 14);
//$pdf->ezImage('../images/ocr.png', 25, 120, 'none', 'left');
/*
$pdf->ezText('                                                '. $participante2->getNLicenciaGDE(). '                                      ' . $nExpediente . '                                      ' . $participante2->getNResolGDE(). '                       ' . $dtllTRR, 14, array('justification' => 'left'));
$pdf->ezText("\n\n\n\n\n", 15);
$pdf->ezText('                                         '. $participante->getNonRazonSocial(), 16, array('justification' => 'left'));
$pdf->ezText("\n", 2);
$pdf->ezText('                                         '. mb_strtoupper($direEst), 16, array('justification' => 'left'));
$pdf->ezText('                                         '. $participante->getGiro(), 16, array('justification' => 'left'));
$pdf->ezText("\n", 2);
$pdf->ezText('                                         '. mb_strtoupper($participante->getActividadEconomica()), 16, array('justification' => 'left'));
$pdf->ezText('                                         '. $participante->getAreatotal(), 16, array('justification' => 'left'));
$pdf->ezText("\n", 2);
$pdf->ezText('                                         '. $participante->getRuc(), 16, array('justification' => 'left'));
$pdf->ezText("\n",16);
$pdf->ezText("\n", 2);
$pdf->ezText(date("d", $fechalic) .' DE '. $mesmuni . ' DE '. date("Y", $fechalic) . ' ', 12, array('justification' => 'right'));
*/
$pdf->ezStream();
?>