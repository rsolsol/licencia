<?php
define('FPDF_FONTPATH','font/');
define('CONTROLADOR', TRUE);            
require_once('fpdf.php');
require_once("../clases/conexion.php");
require_once '../modelos/Expediente.php';
require_once '../modelos/licenciasGDE.php';
/*
require_once('gisp_admincon.php');
require_once('qrcode.class.php');
require_once("Connections/coneccionRatania.php");
require_once("Connections/funciones_pg.php");*/
//include_once('rotation.php');

class PDF extends FPDF{

	var $angle=0;
	var $javascript;
	var $n_js;
	public $p_codPredio;
	var $y;
	var $valor;

		function get_y(){
			return $this->y;
		}
		function set_y($y){
			$this->y=$y;		
		}
		function get_valor(){
			return $this->valor;
		}
		function set_valor($valor){
			$this->valor=$valor;
		}
		function IncludeJS($script) {
			$this->javascript=$script;
		}

		function _putjavascript() {
			$this->_newobj();
			$this->n_js=$this->n;
			$this->_out('<<');
			$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
			$this->_out('>>');
			$this->_out('endobj');
			$this->_newobj();
			$this->_out('<<');
			$this->_out('/S /JavaScript');
			$this->_out('/JS '.$this->_textstring($this->javascript));
			$this->_out('>>');
			$this->_out('endobj');
		}


	function AutoPrint($dialog=false)
	{
		//Open the print dialog or start printing immediately on the standard printer
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";
		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		$script = "var pp = getPrintParams();";
		if($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
			$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
		$script .= "print(pp);";
		$this->IncludeJS($script);
	}


		function _putresources() {
			parent::_putresources();
			if (!empty($this->javascript)) {
				$this->_putjavascript();
			}
		}

		function _putcatalog() {
			parent::_putcatalog();
			if (!empty($this->javascript)) {
				$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
			}
		}
		

	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}

	function RotatedText($x,$y,$txt,$angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}

	function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
	
	function Header(){
		//datos SQL
		global $nrovalor; 
		global $nombreContrib;
		global $codigoContrib;
		global $documento;
		global $direccionContrib;
		global $codPredio2 ;
		global $dirPredio;
		global $tributo;
		$lw = 10;
		$ln = 10;
		
		$ls = 3;
		$lh = 0;
		//MArca de Agua
		$marcaAguaL3 = 0;
		$marcaAguaL4 = 0;
		$this->Image('../images/escudomarcaagua4.png',65,100,$marcaAguaL3+75,$marcaAguaL4+75,'PNG');
		/*
		//Logo
		$this->SetFont('narrow','',8);
		//$this->SetFillColor(206,232,212); //verde agua
		$this->SetFillColor(188,217,190); //verde agua
		$this->SetXY($lw-10,$lh);
		$this->Cell(220,6,"",0,1,'L',true);
		$this->SetFillColor(243);
		$this->SetFont('arial','B',9);
		$this->SetXY($lw-10,$lh);
		$this->MultiCell(50,6,'Calle 9 de Junio Nro 100',1,'C');
		$this->SetXY($lw+40,$lh);
		$this->MultiCell(50,6,'Puente Piedra - Lima - Peru',1,'C');
		$this->SetXY($lw+90,$lh);
		$this->MultiCell(50,6,'www.munipuentepiedra.gob.pe',1,'C');
		$this->SetXY($lw+140,$lh);
		$this->MultiCell(60,6,'Telefono 219 6200 - 219 6201',1,'C');
		//$this->RoundedRect(-10, 0, 220, 8, 1,'S');*/
		$this->Image('../images/munipuentepiedra.png',$lw,$ln-3,45,13,'PNG');
		
		/*
		$lh+=11;
		$this->SetXY(0,$lh);
		$this->SetFont('arial','B',7);
		$this->MultiCell(90,10,utf8_decode("Gerencia de Administración Tributaria"),0,'C');
		$lh+=2;
		$this->SetXY(0,$lh);
		$this->SetFont('arial','B',7);
		$this->MultiCell(90,10, utf8_decode("Subgerencia de Fiscalización Tributaria"),0,'C');
		*/
		$lh+=15;
		$this->SetFillColor(255); 
		$this->SetFont('arial','B',10);
		$this->SetXY($lw,$lh);
		$this->MultiCell(200,0, utf8_decode("REPORTE DE LICENCIAS N° "),0,'C'); 

		$lh+=8;

		
                
	}	#FIN DE CABECERA
	
	function Footer(){                 
	}	#FIN DE PIE DE PAGINA
	
	function WriteResumen($x,$h1, $corte,$topmar){
		//datos SQL
		global $Coneccion;
		global $lp;

	}
	
	function CheckPageBreak($h){
		if($h >= 95){
			$this->AddPage('L','A4');	
			return 1;
		} 
	}
	
}

$pdf = new PDF('P','mm','A4');
$pdf->SetDisplayMode('default');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$numero = filter_input(INPUT_POST, 'txtNumeroExpe');
$valor=filter_input(INPUT_POST, 'tip');
//$valor = 'nu_expe_todo';
$numerotxt = (strlen($numero)>5) ? $numero : null ;
   
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    exit();
} else {
    printf("", mysqli_character_set_name($con));
}
    $peti = "";

    switch ($valor) {
        case 'nu_expe_todo':{
            $peti = "SELECT 
                        lic_solicitud.nNUMERO_EXP_SOL,
                        lic_solicitud.dFECHA_INGRESO,
                        lic_solicitud.vNOM_RAZON_SOL,
                        concat_ws('', lic_solicitud.vAVDA_SOL, lic_solicitud.nNUMCASA_SOL, lic_solicitud.nINT_SOL, lic_solicitud.vMZ_SOL, lic_solicitud.nLOTE_SOL) as direccion 
                FROM
                        lic_solicitud 
                WHERE
                        lic_solicitud.nNUMERO_EXP_SOL = '{$numero}'";
        }
            break;
        case 'nu_docu':{
            $peti = "SELECT 
                        lic_solicitud.nNUMERO_EXP_SOL,
                        lic_solicitud.dFECHA_INGRESO,
                        lic_solicitud.vNOM_RAZON_SOL,
                        concat_ws('', lic_solicitud.vAVDA_SOL, lic_solicitud.nNUMCASA_SOL, lic_solicitud.nINT_SOL, lic_solicitud.vMZ_SOL, lic_solicitud.nLOTE_SOL) as direccion 
                FROM
                        lic_solicitud 
                WHERE
                        lic_solicitud.vDNI_SOL = '{$numero}'";
        }
            break;    
        case 'nu_ruc':{
            $peti = "SELECT 
                        lic_solicitud.nNUMERO_EXP_SOL,
                        lic_solicitud.dFECHA_INGRESO,
                        lic_solicitud.vNOM_RAZON_SOL,
                        concat_ws('', lic_solicitud.vAVDA_SOL, lic_solicitud.nNUMCASA_SOL, lic_solicitud.nINT_SOL, lic_solicitud.vMZ_SOL, lic_solicitud.nLOTE_SOL) as direccion 
                FROM
                        lic_solicitud 
                WHERE
                        lic_solicitud.vRUC_SOL = '{$numero}'";
        }
            break;
        default:
                //
            break;
    }
        
    if($peti != ""){
        $result = mysqli_query($con,$peti);
        $rm=@mysqli_num_rows($result);
              
        if($rm!=0 && $rm<100 && isset($numero))
        {
            $arreglo_columnas = ['Nro Expediente', 'Fecha de Ingreso', 'Administrado', 'Direccion', 'Nro. Licencia', 'Nro. Resolución'];
            $x = 15;
            $y = 35;
            //Cabeceras
            for ($i=0; $i < 6; $i++) { 
                $pdf->SetFont('arial','B',4);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(30, 5, utf8_decode($arreglo_columnas[$i]),1,'C');
                $x = $x + 30;         
            }

            $x = 15;
           	$y = 40;
            while($fila=@mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
            	$arreglo_columnas_registro = ['nNUMERO_EXP_SOL', 'dFECHA_INGRESO', 'vNOM_RAZON_SOL', 'direccion', 'NLicenciaGDE', 'NResolGDE'];
				for ($i=0; $i < 6; $i++) { 
	                $pdf->SetFont('arial','B',4);
	                $pdf->SetXY($x,$y);
	                if($arreglo_columnas_registro[$i] == 'NLicenciaGDE'){
	                	//obtener filas y columnas
		            	$expediente = Expediente::buscaPorExpediente($fila['nNUMERO_EXP_SOL']);
		                //echo "expediente ".$expediente->getIdSolicSol();
		                $licencia = new Licencia();
		                $lice = $licencia->buscarImpresion($expediente->getIdSolicSol());
		                $l = '';
		                $nreso = '';
		                if(!empty($lice)){
		                    $l = $lice->getNLicenciaGDE();    
		                    //$nreso = $lice->getNResolGDE();
		                }
		                else{
		                    $l = '-'; 
		                    //$nreso = '-';
		                }
		            	//fin de obtener filas y columnas
	                	$pdf->MultiCell(30, 5, utf8_decode($l),1,'C');
	                }
	                elseif ($arreglo_columnas_registro[$i] ==  'NResolGDE') {
	                	//obtener filas y columnas
		            	$expediente = Expediente::buscaPorExpediente($fila['nNUMERO_EXP_SOL']);
		                //echo "expediente ".$expediente->getIdSolicSol();
		                $licencia = new Licencia();
		                $lice = $licencia->buscarImpresion($expediente->getIdSolicSol());
		                $l = '';
		                $nreso = '';
		                if(!empty($lice)){
		                    //$l = $lice->getNLicenciaGDE();    
		                    $nreso = $lice->getNResolGDE();
		                }
		                else{
		                    //$l = '-'; 
		                    $nreso = '-';
		                }
		            	//fin de obtener filas y columnas
	                	$pdf->MultiCell(30, 5, utf8_decode($nreso),1,'C');	
	                }
	                else{
	                	$pdf->MultiCell(30, 5, utf8_decode($fila[$arreglo_columnas_registro[$i]]),1,'C');	
	                }
	                $x = $x + 30;         
            	}
            	$x = 15;                
            	$y = $y + 5;
            }
        }
        else if ($rm>=200)  
        {
            ?>
              <span></span>           
            <?php
        }        
        else   
        {
            ?>
              <span></span>
            <?php
        }
    }

$pdf->Output();


?>



