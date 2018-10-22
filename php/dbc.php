<br> 
<br>
<h2>HISTORICOS ENCONTRADOS</h2>

		<div class="form_box form">
            <div class="hide">
                <input type="hidden" name="id56_hf_0" id="id56_hf_0">
            </div>
            <h4>Aviso</h4>
            <p class="fields">
                <label class="label1">RECUERDA: Estos historicos son el avance actual de el expediente y puedes ver su estado y en que area que se encuentra</label>
            </p>
	    </div>

        <div class='mock-table'>
            <div>
                <span>Nro. Expediente</span>
                <span>Fecha de Ingreso</span>
                <span>Estado</span>
                <span>Observacion</span>
                <span>Area</span>
                <span>Administrado</span>					
            </div>
<?php
        $x=filter_input(INPUT_GET, 'c');
        require_once("../clases/conexion.php");
        if (!mysqli_set_charset($con, "utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
            exit();
        } else {
            printf("", mysqli_character_set_name($con));
        } 
        $peticion = "SELECT r.cdgo_trmte_dcmnto,p.cdgo_dto_trmte as codih, p.nu_expe_todo,r.fe_rcbdo_trmte, a.de_estdo_trmte,r.de_obse,s.de_area,u.no_crto 
                FROM p_dto_trmtes p,a_estdos_trmtes a,a_areas s, p_usrios u , r_trmtes_dcmntos r
                where r.cdgo_dto_trmte=p.cdgo_dto_trmte and r.cdgo_estdo_trmte=a.cdgo_estdo_trmte
                and p.cdgo_area=s.cdgo_area
                and p.cdgo_usrios=u.cdgo_usrios and p.cdgo_dto_trmte='".$x."';";
        $resultado =@mysqli_query($con,$peticion);
        while($fila=@mysqli_fetch_array($resultado,MYSQLI_ASSOC))
    {
        $x=$fila['codih'];			
        echo "<div>
                <span data-label='Nro. Expediente'>".$fila['nu_expe_todo']."</span>
                <span data-label='Folio'>".$fila['fe_rcbdo_trmte']."</span>
                <span data-label='Fecha de Ingreso'>".$fila['de_estdo_trmte']."</span>
                <span data-label='Tipo de Tramite'>".$fila['de_obse']."</span>
                <span data-label='Area'>".$fila['de_area']."</span>
                <span data-label='Administrado'>".$fila['no_crto']."</span>					
              </div>";
    } 
    echo "</div><br><p class='action'>
    <a class='btn btn-primary btn-block' href='javascript:abrir(".$x.")'  value='".$x."' onchange='muestracliente(this.value)'>Imprimir</a>
    </form></p>";
?>