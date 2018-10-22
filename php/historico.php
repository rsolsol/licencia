<?php
define('CONTROLADOR', TRUE);            
require_once("../clases/conexion.php");
require_once '../modelos/Expediente.php';
require_once '../modelos/licenciasGDE.php';

$numero = filter_input(INPUT_POST, 'txtNumeroExpediente');
$valor=filter_input(INPUT_POST, 'tipo');
$numerotxt = (strlen($numero)>5) ? $numero : null ;
//Obtener nro de licencias y nro de resolución
/*
$expediente = new Expediente();
$expe = $expediente->buscaPorExpediente($numero);
$licencia = new Licencia();
$lice = $licencia->buscarImpresion($expe->getIdSolicSol());
echo "dddd ".$lice->getNLicenciaGDE();*/

//Fin Obtener nro de licencias y nro de resolución
    
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
            echo utf8_decode("<div class='mock-table'>
                    <div>
                        <span>Nro. Expediente</span>
                        <!--span>Folio</span-->
                        <span>Fecha de Ingreso</span>
                        <!--span>Tipo de Tramite</span-->
                        <!--span>Area</span-->
                        <span>Administrado</span>
                        <span>Direccion</span>
                        <span>Nro. Licencia</span>
                        <span>Nro. Resolución</span>                       
                    </div>");
            while($fila=@mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
                //AQUI VA EL CÓDIGO
                $expediente = Expediente::buscaPorExpediente($fila['nNUMERO_EXP_SOL']);
                //echo "expediente ".$expediente->getIdSolicSol();
                $licencia = new Licencia();
                $lice = $licencia->buscarImpresion($expediente->getIdSolicSol());
                $l = '';
                $nreso = '';
                if(!empty($lice)){
                    $l = $lice->getNLicenciaGDE();    
                    $nreso = $lice->getNResolGDE();
                }
                else{
                    $l = '-'; 
                    $nreso = '-';
                }
                
                echo "<div>
                    <span data-label='Nro. Expediente'>".$fila['nNUMERO_EXP_SOL']."</span>".
                    "<span data-label='Fecha de Ingreso'>".$fila['dFECHA_INGRESO']."</span>".
                    "<span data-label='Administrado'>".$fila['vNOM_RAZON_SOL']."</span>"    .
                    "<span data-label='Direccion'>".$fila['direccion']."</span>" .
                    "<span data-label='Licencia'>".$l."</span>" .
                    "<span data-label='Resolucion'>".$nreso."</span>" .
                  "</div> ";
            }
            echo    "</div><form action='../fpdf/reporteLicencias.php' method='POST'>
                                    <p class='action'>
                                        <input type='text' style='display:none;' name='txtNumeroExpe' value='{$numero}'  class='btn'>
                                        <input type='text' style='display:none;' name='tip' value='{$valor}'  class='btn'>  
                                        <input type='submit' value='Ver Reporte'  class='btn'> 
                                    </p>
                            </form>";
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
		
?>