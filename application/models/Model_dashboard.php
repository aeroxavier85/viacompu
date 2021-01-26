<?php

class model_dashboard extends CI_Model
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



function donut_producto_mas_vendido(){
     $sql2=" SELECT concat(c.descripcion,'-',m.descripcion,'-',p.id_modelo)as label,count(*)as value
            FROM inventario.tbl_egresodet d 
            inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
            inner join inventario.tbl_producto p on d.id_producto=p.id_producto
            inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
            inner join inventario.tbl_marca m on p.id_marca=m.id_marca
            where d.estado='A' and cab.tipo='EC'
            group by d.id_producto; ;";
             if($query2=$this->db_autenticacion->query($sql2)){
                    return $query2->result_array();
             }else{
                return  0;
             }  
       
}

function donut_producto_mas_vendido_matriz(){
     $sql2=" SELECT concat(c.descripcion,'-',m.descripcion,'-',p.id_modelo)as label,count(*)as value
            FROM inventario.tbl_egresodet d 
            inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
            inner join inventario.tbl_producto p on d.id_producto=p.id_producto
            inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
            inner join inventario.tbl_marca m on p.id_marca=m.id_marca
            where d.estado='A' and cab.id_bodega='5' and cab.tipo='EC'
            group by d.id_producto ";
             if($query2=$this->db_autenticacion->query($sql2)){
                    return $query2->result_array();
             }else{
                return  0;
             }  
       
}

function donut_producto_mas_vendido_fortin(){
     $sql2="SELECT concat(c.descripcion,'-',m.descripcion,'-',p.id_modelo)as label,count(*)as value
            FROM inventario.tbl_egresodet d 
            inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
            inner join inventario.tbl_producto p on d.id_producto=p.id_producto
            inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
            inner join inventario.tbl_marca m on p.id_marca=m.id_marca
            where d.estado='A' and cab.id_bodega='6' and cab.tipo='EC'
            group by d.id_producto ;";
             if($query2=$this->db_autenticacion->query($sql2)){
                    return $query2->result_array();
             }else{
                return  0;
             }  
       
}

function bar_gastos_ingresos_matriz(){
           $sql2="  select 
                  case t1.mes 
                  when '12' then 'Diciembre'  when '11' then 'Noviembre'  when '10' then 'Octubre' 
                  when '9' then 'Septiembre'  when '8' then 'Agosto'      when '7' then 'Julio'
                  when '6' then 'Junio'       when '5' then 'Mayo'        when '4' then 'Abril'
                  when '3' then 'Marzo'       when '2' then 'Febrero'     when '1' then 'Enero'
                  end as mes, t1.precio_base,t2.ppp from 
                   (select extract(month from d.fecha) as mes,sum(p.precio)as precio_base from inventario.tbl_egresodet d 
                   inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
                   inner join inventario.tbl_producto p on d.id_producto=p.id_producto
                   where d.estado='A' and tipo='EC' and cab.id_bodega='5'
                   and extract(year from d.fecha)=extract(year from now())
                   group by extract(month from d.fecha))t1
                   left join
                   (select extract(month from d.fecha) as mes,sum(d.precio_venta)as ppp from inventario.tbl_egresodet d 
                   inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
                   where d.estado='A' and tipo='EC' and cab.id_bodega='5'
                   and extract(year from d.fecha)=extract(year from now())
                   group by extract(month from d.fecha))t2 on t1.mes=t2.mes ;    ";
             if($query2=$this->db_autenticacion->query($sql2)){
                    return $query2->result_array();
             }else{
                return  0;
             }
}

function bar_gastos_ingresos_fortin(){
           $sql2="  select 
                  case t1.mes 
                  when '12' then 'Diciembre'  when '11' then 'Noviembre'  when '10' then 'Octubre' 
                  when '9' then 'Septiembre'  when '8' then 'Agosto'      when '7' then 'Julio'
                  when '6' then 'Junio'       when '5' then 'Mayo'        when '4' then 'Abril'
                  when '3' then 'Marzo'       when '2' then 'Febrero'     when '1' then 'Enero'
                  end as mes, t1.precio_base,t2.ppp from 
                   (select extract(month from d.fecha) as mes,sum(p.precio)as precio_base from inventario.tbl_egresodet d 
                   inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
                   inner join inventario.tbl_producto p on d.id_producto=p.id_producto
                   where d.estado='A' and tipo='EC' and cab.id_bodega='6'
                   and extract(year from d.fecha)=extract(year from now())
                   group by extract(month from d.fecha))t1
                   left join
                   (select extract(month from d.fecha) as mes,sum(d.precio_venta)as ppp from inventario.tbl_egresodet d 
                   inner join inventario.tbl_egresocab cab on d.id_egresocab=cab.id_egresocab
                   where d.estado='A' and tipo='EC' and cab.id_bodega='6'
                   and extract(year from d.fecha)=extract(year from now())
                   group by extract(month from d.fecha))t2 on t1.mes=t2.mes ;
             ";
             if($query2=$this->db_autenticacion->query($sql2)){
                    return $query2->result_array();
             }else{
                return  0;
             }
}



} ?>
