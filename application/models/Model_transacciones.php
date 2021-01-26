<?php

class Model_transacciones extends CI_Model
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



function obtener_transacciones_por_criterios($empresa,$fecha_ini,$fecha_fin){
     $sql="SELECT r.fecha,r.guia,r.fecha,
        case
        when r.tipo='I' then 'Ingreso' else 'Egreso'
        end as tipo_guia,
        case
        when r.estado_producto='B' then 'Buen Estado' else 'Defectuoso'
        end as estado,
        r.cod_barras,e.nombre as empresa,bo.nombre as bodega,p.id_modelo as modelo,
        p.detalle,m.descripcion as marca,c.descripcion as tipo,concat(u.first_name,' ',u.last_name)as usuario
        FROM inventario.tbl_registro_movimiento r
        inner join inventario.tbl_empresa e on r.id_empresa=e.id_empresa
        inner join inventario.tbl_bodega bo on r.id_bodega=bo.id_bodega
        inner join inventario.tbl_producto p on r.id_producto=p.id_producto
        inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
        inner join inventario.tbl_marca m on p.id_marca=m.id_marca
        inner join inventario.users u on p.usuario=u.id
        where r.estado='A' and r.id_empresa='".$empresa."'
         and cast(r.fecha as date) >='".$fecha_ini."' and cast(r.fecha as date) <='".$fecha_fin."' ";             
   
        if($query = $this->db_autenticacion->query($sql)){
                return $query->result_array();
        }else{
                 return 0;
        }       
       
}




} ?>
