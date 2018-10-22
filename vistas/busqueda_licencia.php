<!DOCTYPE html>
<html lang="es">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />
        <title>Plataforma virtual</title>
        <link rel="shortcut icon" href="../images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/css_de_consultatramite/css-custom.css">
        <link rel="stylesheet" type="text/css" href="../css/css_de_consultatramite/lista.css">	
        <link rel="stylesheet" type="text/css" href="../css/css_de_consultatramite/form.css">
        <script src="../js/jquery-latest.min.js" type="text/javascript"></script>	
        <script type="text/javascript">
            function muestracliente(str){
                var xmlhttp; 
                if (str=="")
                  {
                  document.getElementById("txtHint").innerHTML="";
                  return;
                  }
              if (window.XMLHttpRequest)
                  {// code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                     {
                     document.getElementById("cliente").innerHTML=xmlhttp.responseText;
                     }
                  }
              xmlhttp.open("GET","../php/dbc.php?c="+str,true);
                xmlhttp.send();
            }
        </script>
        <script type="text/javascript">
            function abrir(k) { 
                open("../php/pop.php?p="+k,'','top=100,left=200,width=1500,height=700'); 
            } 
        </script>
    </head>

	<body><div id="_AF_HSS_extension_installed" style="display: none !important;"></div>
	    <!-- modificacion del consulta tramite -->
	    <div class="wrapper">
	       <header class="header">
                <section class="topbar">
                    <div class="center">
                        <p class="sede">Plataforma virtual</p>
                        <div class="topbar_options">
                            <ul>
                                <!--<li class="webmap"><a href="http://www.munipuentepiedra.gob.pe/obras-iniciadas/portal-de-transparencia"><span>Transparencia</span></a></li>-->
                            </ul>
                        </div>
                    </div>
                </section>			
                <section class="navbar">
                    <div class="center">
                        <h1 class="logoAyto"><a href="index.php"><img alt="Municipalidad de puente piedra" src="http://virtual.munipuentepiedra.gob.pe/consultatramite/img/logo_muni.png" style="height:48px;width:240px;margin-bottom:10px;"></a></h1>
                    </div>
                </section>
                <section>
                    <div style="background: none" class="banner">
                        <div class="center"><img alt="" src="../images/fondo.jpg"></div>
                    </div>
                </section>
		    </header>
           <section class="content clearfix">
            <div class="center">
                <div>
                    <ul class="breadcrumbs">
                        <li><a href="http://www.munipuentepiedra.gob.pe/">Inicio</a></li>
                        <li><a href="http://virtual.munipuentepiedra.gob.pe/">Plataforma Virtual</a></li>
                        <li><a href="http://virtual.munipuentepiedra.gob.pe/licencia/">Busqueda de Expediente para Registrar su Licencia</a></li>
                        <li><span><em>Busqueda de Licencia</em></span></li>
                    </ul>
                </div>	
                <div class="content_int">
                    <header>
                        <h2>BUSQUEDA DE LICENCIAS</h2>
                    </header>
                    <div id="id55">
                        <div class="form_box form">
                            <div class="hide">
                                <input type="hidden" name="id56_hf_0" id="id56_hf_0">
                            </div>
                            <h4>Aviso</h4>
                            <p class="fields">
                                <label class="label1">RECUERDA: Los expedientes mostrados aqui cuentan con la informacion actualizada con un dia de retraso</label>
                            </p>
                        </div>
                        <form id="id56" name="formu" action="" method="post" class="form_box form">
                            <h4>Buscar</h4>
                            <p class="fields">
                                <label class="label">Expediente o numero de documento</label> 
                                <span class="field">
                                    <input type="text" name="txtNumeroExpediente" placeholder="ingrese numero de expediente o de documento" required>
                                </span>
                            </p>
                            <p class="fields" id='red123'>
                                    <input type="radio"  name="tipo" id="radio1" class="css-checkbox" value="nu_expe_todo" checked />
                                    <label for="radio1" class="css-label radGroup1">Nro. Expediente</label>
                                    <input type="radio" name="tipo" id="radio2" class="css-checkbox" value="nu_docu" />
                                    <label for="radio2" class="css-label radGroup1">DNI</label>	
                                    <input type="radio" name="tipo" id="radio3" class="css-checkbox" value="nu_ruc" />
                                    <label for="radio3" class="css-label radGroup1">RUC</label>
                            </p>
                            <p class='action'>
                                <input type='submit' value='Consultar'  class='btn' type='submit'> 
                            </p>
                        </form>
                        <?php include '../php/historico.php';?>
                    </div>
                    <!--No eliminar esta parte porque esto llama a la selecion hecha con radio -->
                     <div id="cliente"></div>
                     <!--fin de no borrar -->
                </div>
             </div>
            </section>       
        </div>
        <footer>
            <div class="center">
                <ul class="logos">
                    <li><img src="../images/logo_muni.gif"></li>
                </ul>
                <div class="stamp"><img alt="" src="../images/blank.png"></div>
                <p class="info">
                    <?php
                    echo utf8_decode("Calle 9 de Junio N° 100 - Cercado de Puente Piedra;
                    
                    <br>
                    Tlf.:
                    219 - 6200
                    Línea Gratuita:
                    0800-26200");
                    ?>
                    <br>
                    Email:
                    <a target="_blank" href="mailto:webmaster@munipuentepiedra.gob.pe">webmaster@munipuentepiedra.gob.pe</a>
                    <?php echo utf8_decode("Dirección web:"); ?>
                    <a target="_blank" href="http://www.munipuentepiedra.gob.pe/">http://www.munipuentepiedra.gob.pe/</a>
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
	   <!--fin de la modificaion de la nueva consulta tramite -->
		<!-- JavaScript includes -->

		<script src="js/jquery-1.11.0.min.js"></script> <!--script src="../js/jquery.js"></script-->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/customjs.js"></script>
	</body>
</html>