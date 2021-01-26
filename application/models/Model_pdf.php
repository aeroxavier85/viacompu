<?php

class model_pdf extends CI_Model
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

function orden_cabecera_pdf($guia){
        $sql="SELECT company,u.email,u.phone,concat(u.first_name,' ',u.last_name)as usuario,b.nombre,e.direccion,c.observaciones
        FROM inventario.tbl_egresocab c
        inner join inventario.users u on c.usuario=u.id
        inner join inventario.tbl_bodega b on c.id_bodega=b.id_bodega
        inner join inventario.tbl_empresa e on c.id_empresa=e.id_empresa
        where id_egresocab='".$guia."'";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
    }


function orden_detalle_pdf($guia){
        $sql="SELECT d.cod_barras,c.fecha,p.detalle,d.precio_venta,
case
when d.estado_producto='B' then 'Buen Estado' else 'Defectuoso'
end  estado_producto,p.id_modelo as modelo,p.imagen,b.nombre ,cat.descripcion as tipo,ma.descripcion as marca,
concat(cat.descripcion,'-',ma.descripcion,'-',p.id_modelo)as producto_completo
FROM inventario.tbl_egresocab c
inner join inventario.tbl_egresodet d on c.id_egresocab=d.id_egresocab
inner join inventario.tbl_producto p on p.id_producto=d.id_producto
inner join inventario.tbl_categoria cat on cat.id_categoria=p.id_categoria
inner join inventario.tbl_marca ma on ma.id_marca=p.id_marca
inner join inventario.tbl_bodega b on c.id_bodega=b.id_bodega
where c.id_egresocab='".$guia."'
and d.estado='A' ";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
    }
    



}
?>
