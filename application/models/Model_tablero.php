<?php

class model_tablero extends CI_Model
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

   
      /*   function produccion_cantera($id_cantera){
        $sql=" SELECT round(sum(m.cubicaje_total),2) as Total,ma.detalle as material,c.detalle as origen
              FROM falixso_master.tbl_movimientos m
              inner join tbl_canteras c on c.idtbl_canteras=m.origen
              inner join tbl_materiales ma on ma.idtbl_materiales=m.material
              where  m.estado>0 and m.origen='".$id_cantera."'
              group by m.origen,m.material";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
                }


    function genera_barras($id_contrato){
        $sql=" SELECT sum(m.viajes) as viajes, m.asociacion ,m.destino
FROM falixso_master.tbl_movimientos m
where m.estado>'0'   and m.material <> '9' 
and m.destino='".$id_contrato."'
group by m.asociacion  
order by viajes desc
limit 15
";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();

    }


    function genera_chart_canteras($id_cantera){
        $sql=" SELECT m.origen,c.nombre_contrato,ma.detalle,round(sum(m.cubicaje_total),2) as total
FROM falixso_master.tbl_movimientos m
inner join tbl_contratos c on c.idtbl_contrator=m.destino
inner join tbl_materiales ma on ma.idtbl_materiales=m.material
where m.origen='".$id_cantera."' 
and m.estado!='0'
and m.material !='9'
group by m.origen,m.destino,m.material
order  by total desc,m.destino;


";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();

    }


         function produccion_esperada_vs_recibida($id_contrato){
        $sql="CALL spMovimientosRutasporMaterial('".$id_contrato."')";
        //var_dump()
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
              
         }

    function canteras_activas(){
        $sql="SELECT m.origen as idtbl_canteras ,c.detalle
FROM falixso_master.tbl_movimientos m
inner join tbl_canteras c on c.idtbl_canteras=m.origen
where m.origen !=7 and m.origen !=8 
group by m.origen";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();

    }
*/

}
?>
