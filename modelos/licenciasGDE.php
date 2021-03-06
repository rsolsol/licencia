<?php 
if (!defined('CONTROLADOR'))
    exit;
require_once 'conexion.php';
class Licencia {
    private $id;
    private $idExpediente;
    private $nResolGDE;
    private $nLicenciaGDE;
    private $razonSocial;
    private $domicilioEst;
    private $areaEst;
    private $fechalicencia;

    
    private $nExpediente; /*no hay */
    const TABLA = 'lic_desa_econo';

    public function __construct($id = null, $idExpediente = null, $nResolGDE = null, $nLicenciaGDE = null, $razonSocial = null, $domicilioEst = null, $areaEst = null, $fechalicencia = null){
    $this->id = $id;
    $this->idExpediente = $idExpediente;
    $this->nResolGDE = $nResolGDE;
    $this->nLicenciaGDE = $nLicenciaGDE;
    $this->razonSocial = $razonSocial;
    $this->domicilioEst = $domicilioEst;
    $this->areaEst = $areaEst;
    $this->fechalicencia = $fechalicencia;

    }
    public function getId() {return $this->id;}
    public function getIdExpediente() {return $this->idExpediente;}
    public function getNResolGDE() {return $this->nResolGDE;}
    public function getNLicenciaGDE() {return $this->nLicenciaGDE;}
    public function getRazonSocial() {return $this->razonSocial;}
    public function getDomicilioEst() {return $this->domicilioEst;}
    public function getAreaEst() {return $this->areaEst;}
    public function getFechalicencia() {return $this->fechalicencia;}

    public function setId($id) { $this->id = $id;}
    public function SetIdExpediente($idExpediente) {$this->idExpediente = $idExpediente;}
    public function SetNResolGDE($nResolGDE) {$this->nResolGDE = $nResolGDE;}
    public function SetNLicenciaGDE($nLicenciaGDE) {$this->nLicenciaGDE = $nLicenciaGDE;}
    public function SetRazonSocial($razonSocial) {$this->razonSocial = $razonSocial;}
    public function SetDomicilioEst($domicilioEst) {$this->domicilioEst = $domicilioEst;}
    public function SetAreaEst($areaEst) {$this->areaEst = $areaEst;}
    public function SetFechalicencia($fechalicencia) {$this->fechalicencia = $fechalicencia;}

/*buscar primero si exsite el expedite para grabar o actualizar*/
public function guardar(){
    $verificadorExistencia = $this->buscarImpresion($this->idExpediente);
    $conexionlic = new Conexion_licencias();
        if ($verificadorExistencia) {
            $consulta = $conexionlic->prepare('UPDATE ' . self::TABLA .' SET res_deseco = :nResolGDE, lic_desa_eco = :nLicenciaGDE, razon_social_desaeco= :razonSocial, direccion_desaeco = :domicilioEst, area_desaeco = :areaEst, fecha_des_eco = now() where id_solicitud_sol = :idExpediente');
            $consulta->bindParam(':nResolGDE', $this->nResolGDE);
            $consulta->bindParam(':nLicenciaGDE', $this->nLicenciaGDE);
            $consulta->bindParam(':razonSocial', $this->razonSocial);
            $consulta->bindParam(':domicilioEst', $this->domicilioEst);
            $consulta->bindParam(':areaEst', $this->areaEst);
            $consulta->bindParam(':idExpediente', $this->idExpediente);
            $consulta->execute();
        } else /*inserta*/ {
            $consulta = $conexionlic->prepare('INSERT INTO ' . self::TABLA . ' (id_solicitud_sol, res_deseco, lic_desa_eco, razon_social_desaeco, direccion_desaeco, area_desaeco, fecha_des_eco) VALUES(:idExpediente, :nResolGDE, :nLicenciaGDE, :razonSocial, :domicilioEst, :areaEst, now())');
            $consulta->bindParam(':idExpediente', $this->idExpediente);
            $consulta->bindParam(':nResolGDE', $this->nResolGDE);
            $consulta->bindParam(':nLicenciaGDE', $this->nLicenciaGDE);
            $consulta->bindParam(':razonSocial', $this->razonSocial);
            $consulta->bindParam(':domicilioEst', $this->domicilioEst);
            $consulta->bindParam(':areaEst', $this->areaEst);
            $consulta->execute();
            $this->id = $conexionlic->lastInsertId();
        }
        $conexionlic = null;
    }
    public function buscarImpresion($idExpediente){
        $conexionlic = new Conexion_licencias();
        $consulta = $conexionlic->prepare('SELECT id_desa_eco, id_solicitud_sol, res_deseco, lic_desa_eco, razon_social_desaeco, direccion_desaeco, area_desaeco, fecha_des_eco FROM ' . self::TABLA . ' WHERE id_solicitud_sol = :idExpediente LIMIT 1');
        $consulta->bindParam(':idExpediente', $idExpediente);
        $consulta->execute();
        $registro = $consulta->fetch();
        $conexionlic = null;
        if ($registro) {
            return new self($registro['id_desa_eco'],$registro['id_solicitud_sol'],$registro['res_deseco'],$registro['lic_desa_eco'],$registro['razon_social_desaeco'],$registro['direccion_desaeco'],$registro['area_desaeco'],$registro['fecha_des_eco'],  $idExpediente);
        }else {
            return false;
        }
    }
}
?>