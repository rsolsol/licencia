<?php if (!defined('CONTROLADOR')) exit; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>GDE-Registrar Licencia</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
        <meta name="viewport" content="width=device-width; initial-scale=1">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/jquery-ui.min.css">
        <script src="./js/jquery.js"></script>
        <script src="./js/jquery-ui.min.js"></script>
        <script src="./js/datepicker-es.js"></script>
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
                        <h1 class="logoAyto"><a href="http://www.munipuentepiedra.gob.pe/"><img alt="Municipalidad de Puente Piedra" src="http://virtual.munipuentepiedra.gob.pe/consultatramite/img/logo_muni.png" style="height:48px;width:240px;margin-bottom:10px;"></a></h1>
                    </div>
                </section>
                <div class="banner">
                    <div class="center">
                        <img alt="" src="./images/fondo.jpg">
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
						<form method="POST" action="./vistas/busca_expediente2.php" class="form_box form">
							<h4>Buscar Expediente a Registrar</h4>
							<div class="fields" id="div1">
								<label for="" class="label">Expediente a Registrar : </label>
								<span class="field">
									<input type="text" class="form-control" placeholder="Ingrese el expediente" name="nExpediente" required>
								</span>
							</div>
							 <p class='action'>
                                <input type="submit" id="submit" name="submit" value="Buscar" class="btn" >
                                <input type="reset" id="submit" name="submit" value="Limpiar" class="btn" >
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
                    <li><img src="./images/logo_muni.gif"></li>
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
    <!-- scrip que llama a la formacion del calendario ademas aqui damos las caracteristicas del calendario -->
    <script>
        $("#fecha1").datepicker({
            changeMonth:true,   /*activa el selector de mes*/
            changeYear:true,    /*activa el selector de año*/
            showOn: "button",   /*activa el boton que activa el calendario*/
            buttonImage: "./images/calendar.gif", /*Muestra la imagen que representará al boton de calendario*/
            buttonImageOnly:true,
            showButtonPanel:true,
        });
    </script>
<!--contraseña: nathalyo-->
<!--   sotfware y sistemas del peru 20567230300-->
    <!--#http://www.htmlquick.com/es/-->
</html>