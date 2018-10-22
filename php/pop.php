<!DOCTYPE html>
<html xml:lang="es" xmlns="http://www.w3.org/1999/xhtml" lang="es"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
		<meta http-equiv="cache-control" content="no-cache">
	<meta content="Plataforma virtual" name="description">
	<meta content="informatica mdpp" name="author">
		<title>Consulta Tramite</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<meta name="viewport" content="width=device-width; initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<!--link rel="stylesheet" type="text/css" href="../css/style1.css"-->
	<link rel="stylesheet" type="text/css" href="../css/css-custom">
	<link rel="stylesheet" type="text/css" href="../css/lista.css">	

	<script> 
function cerrarse(){ 
action.style.visibility = 'hidden'; 
window.close() ;
} 
</script> 


	</head>

	
	<body><div id="_AF_HSS_extension_installed" style="display: none !important;"></div>

	<div class="wrapper">
		<header class="header">
		
           			<section class="topbar">
				<div class="center">
				
					<p class="sede">Plataforma virtual</p>
					
				</div>
			</section>
			
			<section class="navbar">
				<div class="center">
					<h1 class="logoAyto"><a href="index.html"><img alt="Municipalidad de puente piedra" src="http://virtual.munipuentepiedra.gob.pe/consultatramite/img/logo_muni.png" style="height:48px;width:240px;margin-bottom:10px;"></a></h1>
				</div>
			</section>
			<section>

	<div style="background: none" class="banner">
	</div>
</section>
		</header>
		
		<section class="content clearfix">
			<div class="center">				
				<div class="content_int">
					

	<header>
		<h2>
			HISTORICOS
		</h2>
	</header>

	<div id="id55">

		<div   class="form_box form">
		<div class="hide">
			<input type="hidden" name="id56_hf_0" id="id56_hf_0">
		</div>

		<h4>
			Datos
		</h4>

		<p class="fields">
			<label class="label1">
			
			<?php
              	            
				$o=filter_input(INPUT_GET, 'p');
				 require_once("../clases/conexion.php");
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    exit();
} else {
    printf("", mysqli_character_set_name($con));
}
				  
		$petici = "SELECT r.cdgo_trmte_dcmnto, p.nu_expe_todo,r.fe_rcbdo_trmte as fecha, a.de_estdo_trmte,p.nu_docu_trmte,r.de_obse,s.de_area,
		u.no_crto AS nombre ,tipo.de_tpo_trmte as tramite,p.de_obse_todo,p.cdgo_usrios coduser,u.nu_docu as dni
					FROM p_dto_trmtes p,a_estdos_trmtes a,a_areas s, p_usrios u , r_trmtes_dcmntos r ,a_tpo_trmtes tipo
					where r.cdgo_dto_trmte=p.cdgo_dto_trmte and r.cdgo_estdo_trmte=a.cdgo_estdo_trmte and p.cdgo_tpo_trmte=tipo.cdgo_tpo_trmte
                    and p.cdgo_area=s.cdgo_area
					and p.cdgo_usrios=u.cdgo_usrios and p.cdgo_dto_trmte='".$o."'  ORDER BY
   fecha ASC limit 1;";
        
        $rst =@mysqli_query($con,$petici);	
		while($filas=@mysqli_fetch_array($rst,MYSQLI_ASSOC))
        {
			echo "
			
			<table>
			 
			<tr>
			  <td style='width:20%'><strong>DNI	:</strong></td>			
			  <td>".$filas['dni']."</td>
			</tr>	
			<tr>
			  <td style='width:20%'><strong>Apellidos y Nombre		:</strong></td>
			  <td>".$filas['nombre']."</td>
			</tr>	
			<tr>
			  <td style='width:20%'><strong>Tipo de documento			:</strong></td>
			  <td>".$filas['tramite']."</td>
			</tr>	
			<tr>
			  <td style='width:20%'><strong>Asunto					:</strong></td>
			  <td>".$filas['de_obse_todo']."</td>
			</tr>	
			<tr>
			  <td style='width:20%'><strong>Fecha de Apertura			:</strong></td>
			  <td>".$filas['fecha']."</td>
			</tr>							
			
			
			
			
			
			</table>";
        		
		} 
		
			?>
			
			</label>
		</p>
		
	</div>
	</div>

				
	<!-- xxx -->	
				
<div class='mock-table'>
							<div>
								<span>Nro. Expediente</span>
								<span>Fecha de Ingreso</span>
								<span>Estado</span>
								<span>Folio</span>
								<span>Area</span>					
							</div>
            <?php    	            
				$o=filter_input(INPUT_GET, 'p');
				
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    exit();
} else {
    printf("", mysqli_character_set_name($con));
}
		$peticion = "SELECT r.cdgo_trmte_dcmnto, p.nu_expe_todo,r.fe_rcbdo_trmte, a.de_estdo_trmte,r.de_obse,s.de_area,u.no_crto ,p.nu_foli_trmte as folio
                    FROM p_dto_trmtes p,a_estdos_trmtes a,a_areas s, p_usrios u , r_trmtes_dcmntos r
                    where r.cdgo_dto_trmte=p.cdgo_dto_trmte and r.cdgo_estdo_trmte=a.cdgo_estdo_trmte
                    and p.cdgo_area=s.cdgo_area
					and p.cdgo_usrios=u.cdgo_usrios and p.cdgo_dto_trmte='".$o."';";
        
        $resultado =@mysqli_query($con,$peticion);	
		while($fila=@mysqli_fetch_array($resultado,MYSQLI_ASSOC))
        {
			
			
			echo "<div>
					<span>".$fila['nu_expe_todo']."</span>
				  <span>".$fila['fe_rcbdo_trmte']."</span>
				  <span>".$fila['de_estdo_trmte']."</span>
				  <span>".$fila['folio']."</span>
				  <span>".$fila['de_area']."</span>				
				  </div>";
        } echo    "</div>";
?>			

<p class='action'>



<input  class="btn" type='submit' value='IMPRIMIR' onClick='window.print();'>



</p>
			</div>

		</div>
		

</section>
	
	</div>
	<footer>
			
	<div class="center">
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
			<a target="_blank" href="http://www.munipuentepiedra.gob.pe/">http://www.munipuentepiedra.gob.pe/</a>
		</p>
	</div><!-- center -->
        
        
        
        
</footer>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> 
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/customjs.js"></script>
	</body>
</html>