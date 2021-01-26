<?php

class model_inventario extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        //desarrollo
        $this->db_autenticacion = $this->load->database('autenticacion', TRUE);
        //produccion
      // $this->db_vue_gateway = $this->load->database('vue_gateway', TRUE);
    }

    //******************************************
    //******************************************



function obtener_inventario_por_criterios($empresa,$bodega){
     $sql="SELECT b.saldo_actual,e.nombre as empresa,bo.nombre as bodega,p.id_modelo as modelo,
    p.detalle,m.descripcion as marca,c.descripcion as tipo
    FROM inventario.tbl_inventario_bodega b
    inner join inventario.tbl_empresa e on b.id_empresa=e.id_empresa
    inner join inventario.tbl_bodega bo on b.id_bodega=bo.id_bodega
    inner join inventario.tbl_producto p on b.id_producto=p.id_producto
    inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
    inner join inventario.tbl_marca m on p.id_marca=m.id_marca
    where b.id_empresa='".$empresa."' and b.id_bodega='".$bodega."' ";             
    
        if($query = $this->db_autenticacion->query($sql)){
                return $query->result_array();
        }else{
                 return 0;
        }       
       
}




} ?>
