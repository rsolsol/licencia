<?php
define('CONTROLADOR', TRUE);
require_once '../modelos/Expediente.php';
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
    $participante->getNumeroEst() ? $num_est = ' Nº ' . $participante->getNumeroEst() : $num_est = '';
    $participante->getInteEst() ? $inte_est = ' INT. '. $participante->getInteEst() : $inte_est = '';
    $participante->getMzEst() ? $mz_est = ' MZ. '. $participante->getMzEst() : $mz_est = '';
    $participante->getLtEst() ? $lt_est = ' LT. '. $participante->getLtEst() : $lt_est = '';
    $participante->getNunPuestoEst() ? $psto_est = ' PSTO. '. $participante->getNunPuestoEst() : $psto_est = '';
    $participante->getStndEst() ? $stnd_est = ' STND. '. $participante->getStndEst() : $stnd_est = '';
    $ah_est = $participante->getNomDenomiEst(). ' ' . $participante->getDenoDesEst();
    $direEst = $av_est . $num_est . $inte_est . $mz_est . $lt_est . $psto_est . $stnd_est . ' - ' . $ah_est;
}else{
    header('Location: \licencia');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modifica estado del Participante</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
        <meta name="viewport" content="width=device-width; initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/jquery-ui.min.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
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
                        <li><span><em>Registrar Licencia </em></span></li>
                    </ul>
                    <div class="content_int">
                        <header><h2>Datos del Expediente a Registrar su Licencia</h2></header>
						<form method="POST" action="grabar_Lic_Expediente.php" class="form_box form">
							<h4>Datos</h4>
							<div class="fields" id="div1">
									<input type ="text" name="idExpediente"  value ="<?php echo $participante->getIdSolicSol();?>" hidden >
								<label for="" class="label">N° de Expediente: </label>
								<span class="field">
									<input type="text" class="form-control" name="nExpediente" value="<?php echo $participante->getExpediente(); ?>" readonly>
								</span>
                                <label for="" class="label">Raz&oacute;n Social : </label>
								<span class="field">
									<input type="text" class="form-control" name="razonSocial" value="<?php echo utf8_encode($participante->getNonRazonSocial());?>" readonly>
								</span>
                                <label for="" class="label">RUC : </label>
								<span class="field">
									<input type="text" class="form-control" name="ruc" value="<?php echo $participante->getRuc();?>" readonly>
								</span>
                                <label for="" class="label">Domiciliado en : </label>
								<span class="field">
									<input type="text" class="form-control" name="domicilio" value="<?php echo $direEst; ?>" readonly>
								</span>
                                <label for="" class="label">Giro : </label>
                                <span class="field">
									<input type="text" class="form-control" name="giro" value="<?php echo $participante->getGiro();  ?>" readonly>
								</span>
                                <label for="" class="label">Detalle Giro : </label>
                                <span class="field">
									<input type="text" class="form-control" name ="dtlleGiro" value="<?php echo $participante->getDetalleGiro(); ?>" readonly>
								</span>
                               
                                <label for="" class="label">Act. Econ&oacute;mica : </label>
                                <span class="field">
                                    <input type="text" class="form-control" name ="actEcono" value="<?php echo $participante->getActividadEconomica(); ?>" readonly>
								</span>
                                <label for="" class="label">&Aacute;rea del Estab. : </label>
                                <span class="field">
                                   <input type="text" class="form-control" name ="areaEstab" value="<?php echo $areaEstab= $participante->getAreatotal() .' mt2.'; ?>" readonly>
                                </span>
                                <!--hay que crear  # de licencia, Resolucion, si es indeterminada o temporal ademas la fecha en que se creo la licencia  -->
                                <label for="" class="label">N° de Resolucion de Gerencia : </label>
                                <span class="field">
                                    <input type="text" class="form-control" name ="nResolGE" required>
                                </span>
                                <label for="" class="label">N° de Licencia : </label>
                                <span class="field">
                                    <input type="text" class="form-control" name ="nLicencia" required>
                                </span>
							</div>
							 <p class='action'>
                                <input type="submit" id="submit" name="submit" value="Guardar" class="btn" >
                                <input type="reset" id="submit" name="submit" value="Limpiar" class="btn" >
                                <input type="submit" value="Cancelar" class="btn" onclick = "window.location.href='../index.php'">
                            </p>  
						</form>
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
                <p>
         
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
    <!-- scrip que llama a la formacion del calendario ademas aqui damos las caracteristicas del calendario -->
    <script>
        $("#fechaEmp").datepicker({
            changeMonth:true,   /*activa el selector de mes*/
            changeYear:true,    /*activa el selector de año*/
            showOn: "button",   /*activa el boton que activa el calendario*/
            buttonImage: "../images/calendar.gif", /*Muestra la imagen que representará al boton de calendario*/
            buttonImageOnly:true,
            showButtonPanel:true,
        });
    </script>
<!--contraseña: nathalyo-->
<!--   sotfware y sistemas del peru 20567230300-->
    <!--#http://www.htmlquick.com/es/-->
</html>