<?php

class model_productos extends CI_Model
{
    public $sucess, $error,$mensaje;


    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        //desarrollo
        $this->db_autenticacion = $this->load->database('autenticacion', TRUE);
        //produccion
      // $this->db_vue_gateway = $this->load->database('vue_gateway', TRUE);
    }


    function obtener_productos()
    {
        $sql= "call sp_obtenerproductos();" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }

   function obtener_productos_por_empresa($id_empresa)
    {
        $sql= "call sp_ObtenerProductosPorEmpresa(".$id_empresa.");" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }

   

    function guardar_producto($arr_productos,$descripcion,$empresa)
    {

        $sql= ' ';
  
   

            $this->db_autenticacion->trans_start();

            $sql="call sp_AgregarProducto (".$empresa.",'".$descripcion."','".$estado."','0'); " ;
            $query = $this->db_autenticacion->query($sql);

            $row = $query->row();

            if (isset($row))
            {
                $id_producto=$row->idPro;

            $query->free_result();
            $query->next_result();
            $sql=' ';

             foreach ($arr_productos as $clave=>$valor){

                $sql= "call sp_AgregarProductoComponente ('".$id_producto."','".$valor[0]["id_componente"]."',".$valor[1]["cantidad"].",'".$valor[2]["unidad"]."');" ;
                      
                $sqlx= $sqlx.' '. $sql;

                $query = $this->db_autenticacion->query($sql);

                }

            }


            if ($this->db->trans_status() === FALSE)
            {
                $this->db_autenticacion->trans_rollback();  
            }
            else
            {
                $this->db_autenticacion->trans_commit();
            }
            

        return ($query);    
    }

    function obtener_producto_por_id_porrevisar($id_producto)
    {
      //  $sucess="true";
      //  $error= " ";

      //  $sql= "call sp_ObtenerProductoPorId('".$id_producto."');";

      //  $query = $this->db_autenticacion->query($sql)->row_array(); 

     /*   if ($query)
        {
           $data['estado']=$sucess;
           $data['producto']=$query; 

           //$query->free_result();
           $query->next_result();
           $sql=' ';
           $sql= "call sp_ObtenerProductoComponente('".$id_producto."');";

           $query = $this->db_autenticacion->query($sql)->result_array(); 
           if ($query)
            {
              $data['estado']=$sucess;
              $data['producto_componente']=$query;  
            }
           else
            {
              $sucess="false";
              $error= "Error :" . mysql_error();
           }

        } 
        else
        {
         $sucess="false";
         $error= "Error :" . mysql_error();
        }*/
    }

    function obtener_producto_componente_por_id_calculado($id_producto,$cantidad_requerida)
    {
        $sql="call sp_ObtenerProductoComponenteDiferencias ('".$id_producto."',".$cantidad_requerida."); " ;

        $result = $this->db_autenticacion->query($sql); 
        return $result->result_array();
    }

    function obtener_producto_componente_por_id($id_producto)
    {

        $sql="call sp_ObtenerProductoComponente ('".$id_producto."'); " ;

        $result = $this->db_autenticacion->query($sql); 
        return $result->result_array();
    }

    function saldo_simulacion($id_producto){
        
        $sql="call sp_ObtenerProductoComponenteSaldo ('".$id_producto."'); " ;
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }

    function obtener_productos_componente_por_id()
    {
        $sql= "call sp_ObtenerProductoComponente();" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }

    function eliminar_producto($id_producto,$id_empresa,$estado)
    {
        $sql= "call sp_EliminarProducto('".$id_producto."',".$id_empresa.",'".$estado."');" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query;
    }

    function obtener_unidades_por_id($unidad){
        $sql= "call sp_ObtenerUnidadesPorMateria('".$unidad."') ;" ;
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
     }

}
?>
