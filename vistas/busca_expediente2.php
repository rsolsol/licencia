<?php 
// if (!defined('CONTROLADOR')) exit;
    define('CONTROLADOR', TRUE);
    require_once '../modelos/Expediente.php';
    
    $participante = new Expediente();
    $nExpediente = (isset($_POST['nExpediente'])) ? $_REQUEST['nExpediente'] : null;
    $participante->setExpediente($nExpediente);
    if ($nExpediente) {
        $participante = Expediente::buscaPorExpediente($nExpediente);
        /*
        echo 'estoy en busca_expediente2 <br>';
        echo 'codigo id_sol: '. $participante->getIdSolicSol(). '<br>';
        echo 'expediente   : '. $participante->getExpediente(). '<br>';
        echo 'Razon Social : '. $participante->getNonRazonSocial(). '<br>';
        echo 'RUC          : '. $participante->getRuc(). '<br>';
        echo 'Tipo_Tramite : '. $participante->getTipoTramite(). '<br>';
        echo 'Giros        : '. $participante->getGiro(). '<br>';
        echo 'Detalle Giro : '. $participante->getDetalleGiro(). '<br>';
        echo 'Act. Economi : '. $participante->getActividadEconomica(). '<br>';
        echo 'Direc  Estb  : '. $participante->getDirecEst(). '<br>';
        echo 'Numero Estab : '. $participante->getNumeroEst(). '<br>';
        echo 'Interi Estab : '. $participante->getInteEst(). '<br>';
        echo 'Mzana  Estab : '. $participante->getMzEst(). '<br>';
        echo 'Lote   Estab : '. $participante->getLtEst(). '<br>';
        echo 'Puesto Estab : '. $participante->getNunPuestoEst(). '<br>';
        echo 'Stand  Estab : '. $participante->getStndEst(). '<br>';
        echo 'Area  Estb   : '. $participante->getAreatotal(). '<br>';
        echo 'vDENODES_EST : '. $participante->getDenoDesEst(). '<br>';
        echo 'Ndeno Estb   : '. $participante->getNomDenomiEst(). '<br>';*/
        /*#########se forma la direcion del establecimiento*/

		if (! $participante){ //verifica que si no encontrado un expediente regresa a su index
			header('Location: \licencia');		
        }
                $av_est = $participante->getDirecEst();
        $participante->getNumeroEst() ? $num_est = ' Nº ' . $participante->getNumeroEst() : $num_est = '';
        $participante->getInteEst() ? $inte_est = ' INT. '. $participante->getInteEst() : $inte_est = '';
        $participante->getMzEst() ? $mz_est = ' MZ. '. $participante->getMzEst() : $mz_est = '';
        $participante->getLtEst() ? $lt_est = ' LT. '. $participante->getLtEst() : $lt_est = '';
        $participante->getNunPuestoEst() ? $psto_est = ' PSTO. '. $participante->getNunPuestoEst() : $psto_est = '';
        $participante->getStndEst() ? $stnd_est = ' STND. '. $participante->getStndEst() : $stnd_est = '';
        $ah_est = $participante->getNomDenomiEst(). ' ' . $participante->getDenoDesEst();
        $direEst = $av_est . $num_est . $inte_est . $mz_est . $lt_est . $psto_est . $stnd_est . ' - ' . $ah_est;
       // echo 'Direccion completa del establecimiento :'. $direEst;
        /*#########*#####################*/
        /*BUsca el id del Expediente en la Bd_SISDECI */
        $idExpedienteImpreso=$participante->getIdSolicSol();
       // echo '$idExpedienteImpreso' . $idExpedienteImpreso .' <br>';
        require '../modelos/licenciasGDE.php';
        $participante2 = new Licencia();
        $participante2 = Licencia::buscarImpresion($idExpedienteImpreso);
        /*echo 'id de la bd SISDECI :' . $participante2['id_desa_eco'] . '<br>';*/
       // echo 'id de la bd SISDECI :' . $participante2->getId() . '<br>';
        /*
        $tngo = $participante2->getId();
        */
        /*if ($participante2->getId() == false) {*/
       /* if (!$participante2) {            
            echo "No se encontro el ID del Expediente en la BD de SISDECI";
        }else {
            echo 'se encontro el ID del Expediente en la Bd de SISDECI';
        }*/
		session_start();
		$_SESSION['nExpediente'] = $participante->getExpediente($nExpediente);
    }else{
    header('Location: \licencia');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GDE-Registrar Licencia</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
        <meta name="viewport" content="width=device-width; initial-scale=1">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header class="header">
                <section class="topbar">
                    <div class="center">
                        <p class="sede">GDE - Registrar Licencia</p>
                    </div>
                </section>
                <section class="navbar">
                    <div class="center">
                        <h1 class="logoAyto"><a href="http://www.munipuentepiedra.gob.pe/"><img alt="Municipalidad de puente piedra" src="http://virtual.munipuentepiedra.gob.pe/consultatramite/img/logo_muni.png" style="height:48px;width:240px;margin-bottom:10px;"></a></h1>
                    </div>
                </section>
                <div class="banner">
                    <div class="center">
                        <img alt="" src="../images/fondo.jpg">
                    </div>
                </div>
            </header>
            <section class="content">
                <div class="center">
                    <ul class="breadcrumbs">
                        <li><a href="http://www.munipuentepiedra.gob.pe/">Inicio</a></li>
                        <li><a href="http://virtual.munipuentepiedra.gob.pe/">GDE</a></li>
                        <li><span><em>Busqueda de Expediente para Registrar su Licencia</em></span></li>
                        <li><a href="http://virtual.munipuentepiedra.gob.pe/licencia/vistas/busqueda_licencia.php">Busqueda de Licencia</a></li>
                    </ul>
                    <div class="content_int">
                        <header><h2>Busqueda del Expediente</h2></header>
						<form method="POST" action="../vistas/busca_expediente2.php" class="form_box form">
							<h4>Buscar Expediente a Registrar</h4>
							<div class="fields" id="div1">
								<label for="" class="label">Expediente a Registrar : </label>
								<span class="field">
									<input type="text" class="form-control" placeholder="Ingrese el expediente" name="nExpediente" value="<?php echo $participante->getExpediente() ?>" required>
								</span>
							</div>
							 <p class='action'>
                                <input type="submit" id="submit" name="submit" value="Buscar" class="btn" >
                                <input type="reset" id="submit" name="submit" value="Limpiar" class="btn" >
                            </p>  
						</form>
                    </div>
                    <div class="content_int">
                        <div class="mock-table">
                            <div class="">
                                <?php
                                 if (!$participante2) {            
                                        echo '<span class="field">Expedie.</span>';
                                        echo '<span class="field">Raz&oacute;n Social</span>';
                                        echo '<span class="field">Direcci&oacute;n</span>';
                                        echo '<span class="field">Giro</span>';
                                        echo '<span class="field">Dtlle. Giro</span>';
                                    }else {
                                        echo '<span class="field">Expedie.</span>';
                                        echo '<span class="field">Raz&oacute;n Social</span>';
                                        echo '<span class="field">Direcci&oacute;n</span>';
                                        echo '<span class="field">Giro</span>';
                                    } 
                                ?>
                                </div>
                            <div class=""> 
                                <?php
                                 if (!$participante2) {
                                        echo '<span class="field">' . $participante->getExpediente() . '</span>';
                                        echo '<span class="field">' . utf8_encode($participante->getNonRazonSocial()) . '</span>';
                                        echo '<span class="field">' . $direEst . '</span>';
                                        echo '<span class="field">' . $participante->getGiro() . '</span>';
                                        echo '<span class="field">' . $participante->getDetalleGiro() . '</span>';
                                        echo '<span class="social-icons icon-circle icon-zoom list-unstyled list-inline"><a href="./estado_expediente.php" ><i class="fa fa-pencil" ></i></a></span>';  
                                    }else {
                                        echo '<span class="field">' . $participante->getExpediente() . '</span>';
                                        echo '<span class="field">' . utf8_encode($participante->getNonRazonSocial()) . '</span>';
                                        echo '<span class="field">' . $direEst . '</span>';
                                        echo '<span class="field">' . $participante->getGiro() . '</span>';
                                        echo '<span class="social-icons icon-circle icon-zoom list-unstyled list-inline">'.'<a href="./estado_expediente.php" ><i class="fa fa-pencil" ></i></a></span>';
                                        echo '<span class="social-icons icon-circle icon-zoom list-unstyled list-inline">'.'<a href="./ImpresionLicencia2.php" target="_blank"><i class="fa fa-print" ></i></a></span>';
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <br><br>
        <footer>
            <div class="center">
                <ul class="logos">
                    <li><img src="../images/logo_muni.gif"></li>
                </ul>
                <div class="stamp"><img alt="" src="../images/blank.png"></div>
                <p class="info">
                    Calle 9 de Junio N° 100 - Cercado de Puente Piedra
                    <br>
                    Tlf.:
                    219 - 6200
                    Línea Gratuita:
                    0800-26200
                    <br>
                    Email:
                    <a target="_blank" href="mailto:webmaster@munipuentepiedra.gob.pe">webmaster@munipuentepiedra.gob.pe</a>
                    Dirección web:
                    <a target="_blank" href="http://www.munipuentepiedra.gob.pe">http://www.munipuentepiedra.gob.pe</a>
                </p>
                <div class="footer_right">
                    <ul class="footer_links">
                        <li><a href="http://www.munipuentepiedra.gob.pe/index.php?option=com_content&view=article&id=12">Procedimientos Administrativos</a></li>
                        <li><a href="http://www.munipuentepiedra.gob.pe/index.php?option=com_content&view=article&id=167">Sistema de control interno</a></li>
                        <li><a href="http://www.munipuentepiedra.gob.pe/index.php?option=com_content&view=article&id=45">Libro de reclamaciones</a></li>
                    </ul>
                </div>
            </div>
        </footer>    
    </body>
</html>
