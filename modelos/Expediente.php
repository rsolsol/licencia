<?php   

if (!defined('CONTROLADOR'))
    exit;

require_once 'conexion.php';

 class Expediente {
     private $idSolicitud_Sol;
     private $idTTR;
     private $expediente;
     private $nomRazonSol; /*Razon social*/ 
     private $ruc;
     private $idTipoTramite; /*Tipo de Autorizacion*/ 
     private $giro;
     private $detalleGiro;
     private $actividadEconomica;
     private $direEst;
     private $numeroEst;
     private $inteEst;
     private $mzEst;
     private $ltEst;
     private $nroPuestoEst;
     private $stndEst;
     private $areaTotal;
     private $denoDesEst;
     private $nomDenomiEst;
  
     const TABLA = 'lic_solicitud';

     public function  __construct($idSolicitud_Sol = null, $idTTR = null, $expediente = null, $nomRazonSol = null, $ruc = null, $idTipoTramite = null, $giro = null, $detalleGiro = null, $actividadEconomica = null, $direEst = null, $numeroEst=null, $inteEst=null, $mzEst=null, $ltEst=null, $nroPuestoEst=null, $stndEst=null, $areaTotal = null, $denoDesEst=null, $nomDenomiEst=null ){
         $this->idSolicitud_Sol = $idSolicitud_Sol; /*ok */
         $this->idTTR = $idTTR;
         $this->expediente = $expediente; /*ok */
         $this->nomRazonSol = $nomRazonSol; /*ok */
         $this->ruc = $ruc; /*ok */
         $this->idTipoTramite = $idTipoTramite; 
         $this->giro = $giro;
         $this->detalleGiro = $detalleGiro;
         $this->actividadEconomica = $actividadEconomica;
         $this->direEst = $direEst;
         $this->numeroEst = $numeroEst;
         $this->inteEst = $inteEst;
         $this->mzEst = $mzEst;
         $this->ltEst = $ltEst;
         $this->nroPuestoEst = $nroPuestoEst;
         $this->stndEst = $stndEst;
         $this->areaTotal = $areaTotal;
         $this->denoDesEst = $denoDesEst;
         $this->nomDenomiEst = $nomDenomiEst;
     }
     public function getIdSolicSol(){ return $this->idSolicitud_Sol;}
     public function getIdTTR(){return $this->idTTR;}
     public function getExpediente(){ return $this->expediente;}
     public function getNonRazonSocial(){ return $this->nomRazonSol;}
     public function getRuc(){ return $this->ruc;}
     public function getTipoTramite(){ return $this->idTipoTramite;}
     public function getGiro(){ return $this->giro;}
     public function getDetalleGiro(){ return $this->detalleGiro;}
     public function getActividadEconomica(){ return $this->actividadEconomica;}
     public function getDirecEst(){ return $this->direEst;}
     public function getNumeroEst(){return $this->numeroEst;}
     public function getInteEst(){return $this->inteEst;}
     public function getMzEst(){return $this->mzEst;}
     public function getLtEst(){return $this->ltEst;}
     public function getNunPuestoEst(){return $this->nroPuestoEst;}
     public function getStndEst(){return $this->stndEst;}
     public function getAreatotal(){ return $this->areaTotal;}
     public function getDenoDesEst(){return $this->denoDesEst;}
     public function getNomDenomiEst(){return $this->nomDenomiEst;}
    
     public function setExpediente($expediente){$this->expediente = $expediente;}
     /*funcion que busca por expediente*/
     public function buscaPorExpediente($expediente){
         $conexion = new Conexion();
        // $conexion->Conexion::Conectar();
         $consulta = $conexion->prepare('SELECT lic_solicitud.ID_SOLICITUD_SOL,
                                                lic_solicitud.ID_TRAMITE_TTR,
                                                lic_solicitud.nNUMERO_EXP_SOL, 
                                                lic_solicitud.vNOM_RAZON_SOL, 
                                                lic_solicitud.vRUC_SOL, 
                                                lic_tipo_tramite.vDESC_TTR as Tipo_Tramite,
                                                lic_giro.vDESC_GIRO as Giros,
				                                lic_clasifica_giro.de_espcfcion_giro as detalle_Giro,
                                                lic_actividad_economica.vDESC_AEO as Act_Economica,
                                                lic_establecimiento.vDIRECCION_EST,
                                                lic_establecimiento.nNUMERO_EST,
                                                lic_establecimiento.nINT_EST,
                                                lic_establecimiento.vMZ_EST,
                                                lic_establecimiento.nLOTE_EST,
                                                lic_establecimiento.vNUM_PUESTO_SOL,
                                                lic_establecimiento.vNUM_STAND_SOL,
                                                lic_establecimiento.nAREA_TOTAL_EST,
                                                lic_establecimiento.vDENODES_EST,
                                                lic_denomina_loc_est.vNOM_DENOMI AS vNOM_DENOMI_EST
                                                FROM '. self::TABLA . ' INNER JOIN lic_tipo_tramite 
                                                                            ON lic_tipo_tramite.ID_TRAMITE_TTR = lic_solicitud.ID_TRAMITE_TTR 
                                                                        LEFT JOIN lic_clasifica_giro 
                                                                            ON lic_solicitud.ID_SOLICITUD_SOL = lic_clasifica_giro.ID_SOLICITUD_SOL
                                                                        LEFT JOIN lic_giro 
                                                                            ON lic_clasifica_giro.ID_GIRO = lic_giro.ID_GIRO
                                                                        INNER JOIN lic_actividad_economica 
                                                                            ON lic_actividad_economica.ID_AEC = lic_solicitud.ID_AEC
                                                                        LEFT JOIN lic_establecimiento
                                                                            ON lic_solicitud.ID_ESTABLEC_EST = lic_establecimiento.ID_ESTABLEC_EST
                                                                        INNER JOIN lic_denomina_loc AS lic_denomina_loc_est 
                                                                            ON lic_establecimiento.ID_DENOMI = lic_denomina_loc_est.ID_DENOMI
                                                                        WHERE nNUMERO_EXP_SOL = :expediente');
         $consulta->bindParam(':expediente', $expediente);
         $consulta->execute();
         $registro = $consulta->fetch();
         $conexion = null;
         if($registro){
             return new self($registro['ID_SOLICITUD_SOL'], $registro['ID_TRAMITE_TTR'], $registro['nNUMERO_EXP_SOL'], $registro['vNOM_RAZON_SOL'], $registro['vRUC_SOL'], $registro['Tipo_Tramite'], $registro['Giros'], $registro['detalle_Giro'], $registro['Act_Economica'], $registro['vDIRECCION_EST'], $registro['nNUMERO_EST'], $registro['nINT_EST'], $registro['vMZ_EST'], $registro['nLOTE_EST'], $registro['vNUM_PUESTO_SOL'], $registro['vNUM_STAND_SOL'], $registro['nAREA_TOTAL_EST'], $registro['vDENODES_EST'], $registro['vNOM_DENOMI_EST']);
         }else {
             echo "No se puedo encontrar informacion del Expediente solicitado";
         }     
    }
 }
?>