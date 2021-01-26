<?php

class model_servicios extends CI_Model
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
function   obtener_producto_marcas_consula($producto){
    $sql="CALL inventario.sp_obtener_marca_por_categoria('".$producto."') ";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function obtener_ciudades(){
    $sql="select * from inventario.tbl_ciudad  where estado=1";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}


function obtener_modelo_marcas_consulta($categoria,$marca){
        $sql="CALL inventario.sp_obtener_modelo_por_marca('".$categoria."','".$marca."') ";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function obtener_datos_empresas(){
        $sql="SELECT e.*,c.nombre as nombre_ciudad FROM inventario.tbl_empresa e
        inner join inventario.tbl_ciudad c on e.ciudad=c.id_ciudad
        where e.estado='A' ";
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
           }

function eliminar_datos_empresa($id_empresa){
        $sql="update inventario.tbl_empresa set estado='I' where id_empresa='".$id_empresa."' ";
        if($query = $this->db_autenticacion->query($sql)){
                return 1;
        }else{
                return 0;
        }
        
        }

function modificar_empresa_x_id($id_empresa,$nombre_comercial,$contacto,$correo,$telefono,$direccion,$ciudad,$detalles){
         $sql="update inventario.tbl_empresa set nombre='".$nombre_comercial."',contacto='".$contacto."',correo='".$correo."',telefono='".$telefono."',direccion='".$direccion."',ciudad='".$ciudad."',detalles='".$detalles."' where id_empresa='".$id_empresa."' ";
        if($query = $this->db_autenticacion->query($sql)){
                return 1;
        }else{
                return 0;
        }
        
}

function obtener_datos_empresas_por_id($id_empresa){
     $sql="select * from inventario.tbl_empresa where id_empresa='".$id_empresa."' ";
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function obtener_datos_categoria_productos(){
        $sql="select * from inventario.tbl_categoria 
        where estado='A' order by descripcion ; ";
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
           }

function obtener_datos_marca_productos(){
        $sql="select * from inventario.tbl_marca 
        where estado='A' order by descripcion ; ";
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
           }


function obtener_datos_bodegas(){
        $sql="SELECT b.id_bodega,e.nombre as empresa, b.nombre, b.direccion, b.telefono, b.direccion, b.codigo, b.estado
            FROM inventario.tbl_bodega b 
            inner join inventario.tbl_empresa e  on b.id_empresa=e.id_empresa
            where b.estado='A'  ";
        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
           }


function guardar_registro_bodega_ingreso($empresa,$bodega,$producto,$cod_barras, $guia ,
                                        $referencia,$estado )
{  

    $user_id = $this->session->userdata('user_id');

            $sql="call sp_IngresoDetalle_agregar ('".$guia."','".$referencia."','".$producto."','".$cod_barras."','".$estado."') ";
            
            if ($query=$this->db_autenticacion->query($sql))
            {
                 $sql=' ';
                 $sql="call inventario.sp_ObtenerDetalleIngresos('".$guia."');";
                 $query = $this->db_autenticacion->query($sql);
                 return $query->result_array();
            }  
            else   {  return 0;   } 
}

function guardar_registro_bodega_egreso($empresa,$bodega,$producto,$cod_barras ,$guia ,  $estado ,$ppp)
{  

 $user_id = $this->session->userdata('user_id');
 $sql="call sp_EgresoDetalle_agregar ('".$guia."','".$producto."','".$cod_barras."','".$estado."','".$ppp."') ";
            
      if ($query=$this->db_autenticacion->query($sql))
            {
                 $sql=' ';
                 $sql="call inventario.sp_ObtenerDetalleEgresos('".$guia."');";
                 
                 $query = $this->db_autenticacion->query($sql);
                 return $query->result_array();
            }  
       else   {  return 0;   }

}


function cerrar_guia_ingreso($empresa,$guia,$bodega)
{

    $user_id = $this->session->userdata('user_id');

    $sql="call sp_registro_movimientos_agregar('".$empresa."','".$guia."','".$bodega."','".$user_id."');";
    if( $query = $this->db_autenticacion->query($sql))
       {    
        $data=$query->result_array();   
       
         $query->free_result();  
         $query->next_result();  
       
       foreach ($data as $row)
        {
        
         $sql2= "call sp_inventarioBodega_Agregar ('".$row["id_empresa2"]."','".$row["id_producto"]."',".$row["id_bodega2"].",1,'".$row["usuario2"]."');" ;
          $query2 = $this->db_autenticacion->query($sql2);
          $query2->free_result();     
        //  $query2->next_result();
        
        }   
         $sql3="call sp_Ingreso_actualizar_tipo('".$guia."');";
         $query3 = $this->db_autenticacion->query($sql3);
        return 1;        
       }
              else { return 0; }
}

function cerrar_guia_egreso($empresa,$guia,$bodega,$observaciones)
{
   


    $user_id = $this->session->userdata('user_id');

    $sql="call sp_registro_movimientos_agregar_egreso('".$empresa."','".$guia."','".$bodega."','".$user_id."');";
   
    if( $query = $this->db_autenticacion->query($sql))
       {    

         
        $data=$query->result_array();   
       
         $query->free_result();  
         $query->next_result();  
       
       foreach ($data as $row)
        {
        //var_dump('ingesooo 2');
         $sql2= "call sp_inventarioBodega_Egresar ('".$row["id_empresa2"]."','".$row["id_producto"]."',".$row["id_bodega2"].",1,'".$row["usuario2"]."');" ;
          $query2 = $this->db_autenticacion->query($sql2);
          $query2->free_result();     
        //  $query2->next_result();
        
        }   
         $sql3="call sp_Egreso_actualizar_tipo('".$guia."','".$observaciones."');";
         $query3 = $this->db_autenticacion->query($sql3);
        return 1;        
       }
              else {  return 0; }
}

function cerrar_guia_cotizacion($guia,$observaciones)
{

     $user_id = $this->session->userdata('user_id');
     $sql="update inventario.tbl_cotizacionescab set tipo='CC', observaciones='".$observaciones."' where id_cotizacionescab='".$guia."' ";
         if ( $this->db_autenticacion->query($sql)){
                return 1;            
         }
         else {  return 0; }
}

function guardar_registro_bodega_movimiento_interno($cod_barras ,$guia,$estado){        
        $sql="call inventario.sp_AgregarMovimientoDet_producto('".$cod_barras."','".$guia."','".$estado."');";
        $query2 = $this->db_autenticacion->query($sql);
        return $query2->result_array();
        
}

function abrir_guia_ingreso($empresa,$bodega){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_ingresocab(id_empresa,tipo,id_bodega,usuario)values('".$empresa."','IA','".$bodega."','".$user_id."') ";
   
        if($this->db_autenticacion->query($sql)){
            $last_id = $this->db_autenticacion->insert_id();
            return $last_id;
        }else{
         return 0; }
            }


function abrir_guia_egreso($empresa,$bodega){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_egresocab(id_empresa,tipo,id_bodega,usuario)values('".$empresa."','EA','".$bodega."','".$user_id."') ";
   
        if($this->db_autenticacion->query($sql)){
            $last_id = $this->db_autenticacion->insert_id();
            return $last_id;
        }else{
         return 0; }
            }



function guardar_registro_empresa($nombre_comercial,$contacto,$telefono,$correo,$direccion,$ciudad,$detalles){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_empresa(nombre,contacto,correo,telefono,direccion,ciudad,detalles)values('".$nombre_comercial."','".$contacto."','".$correo."','".$telefono."','".$direccion."','".$ciudad."','".$detalles."') ";
   
        if($this->db_autenticacion->query($sql)){          
            return 1;
        }else{
         return 0; }
}

function abrir_guia_movimiento_bodegas($empresa,$bodega_origen,$bodega_destino){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_movimientocab(id_empresa,tipo,id_bodega_origen,id_bodega_destino,usuario)values('".$empresa."','MA','".$bodega_origen."','".$bodega_destino."','".$user_id."') ";
   
        if($this->db_autenticacion->query($sql)){
            $last_id = $this->db_autenticacion->insert_id();
            return $last_id;
        }else{
         return 0; }
}

function  listar_guias_ingreso(){
    $sql='SELECT id_ingresocab,nombre, fecha,tipo FROM  inventario.tbl_ingresocab cab
        inner join inventario.tbl_bodega b on cab.id_bodega=b.id_bodega where cab.estado="A";';
    $query = $this->db_autenticacion->query($sql); 
    return $query->result_array();
}

function  listar_guias_egreso(){
    $sql='SELECT id_egresocab,nombre, fecha,tipo ,concat(u.first_name," ",u.last_name)as usuario
          FROM  inventario.tbl_egresocab cab
         inner join inventario.tbl_bodega b on cab.id_bodega=b.id_bodega 
         inner join inventario.users u on cab.usuario=u.id
         where cab.estado="A";';
    $query = $this->db_autenticacion->query($sql); 
    return $query->result_array();
}

function  listar_cotizaciones(){
    $sql='SELECT id_cotizacionescab,cliente,concat(u.first_name," ",u.last_name)as usuario, fecha_cotizacion,cab.email,tipo
 FROM inventario.tbl_cotizacionescab cab
 inner join inventario.users u on cab.usuario=u.id
 where cab.estado="A"';
    $query = $this->db_autenticacion->query($sql); 
    return $query->result_array();
}


function  listar_guias_movimientos_internos(){
    $sql="call inventario.sp_obtener_movimientos();";
    $query = $this->db_autenticacion->query($sql); 
    return $query->result_array();
}


function  obtener_cab_ingreso_guia($id_registro){
    
     $sql="SELECT cab.id_ingresocab,cab.id_empresa,e.nombre 'empresa',cab.id_bodega,b.nombre 'bodega',det.referencia,tipo
            FROM inventario.tbl_ingresocab cab 
            inner join tbl_empresa e on cab.id_empresa= e.id_empresa 
            inner join tbl_bodega b on cab.id_bodega= b.id_bodega
            left join inventario.tbl_ingresodet det on cab.id_ingresocab=det.id_ingresocab
            where cab.id_ingresocab='".$id_registro."' limit 1;";
     $query = $this->db_autenticacion->query($sql); 
     return $query->result_array();
     $query->next_result();
    
}

function  obtener_det_ingreso_guia($id_registro){
   
     $sql="call inventario.sp_ObtenerDetalleIngresos('".$id_registro."');";
     $query = $this->db_autenticacion->query($sql);  
     return $query->result_array();
    
     
}

function  buscar_codigo_barra($cod_barras,$bodega_origen){
   
    $sql="select p.id_producto, concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,
p.precio,p.detalle as descripcion_producto,p.imagen,p.estado,t.estado_producto,p.costo_maximo,p.costo_minimo,p.costo_standar
from inventario.tbl_producto p
inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
inner join inventario.tbl_marca m on p.id_marca=m.id_marca
inner join (select r.id_producto,r.estado_producto
from inventario.tbl_registro_movimiento r
inner join inventario.tbl_producto p on r.id_producto=p.id_producto
where r.cod_barras='".$cod_barras."' and r.id_bodega='".$bodega_origen."' and tipo='I')t on p.id_producto=t.id_producto
where p.estado='A' and c.estado='A' and m.estado='A' ;";

     $query = $this->db_autenticacion->query($sql);  
     return $query->result_array();
    
     
}
function   obtener_lista_productos(){
    $sql="select p.id_producto,c.descripcion as categoria,m.descripcion as marca,
p.id_modelo as modelo,p.precio,p.detalle as descripcion_producto,p.imagen,p.estado,
case
when  t1.saldo_actual is null then '0' else t1.saldo_actual
end as saldo_actual
from inventario.tbl_producto p
inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
inner join inventario.tbl_marca m on p.id_marca=m.id_marca
left join 
(SELECT sum(saldo_actual) as saldo_actual,id_producto FROM inventario.tbl_inventario_bodega
group by id_producto)t1 on t1.id_producto=p.id_producto
where p.estado='A' and c.estado='A' and m.estado='A' ";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function   obtener_lista_productos_para_ingreso(){
    $sql="select p.id_producto, concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,
    p.precio,p.detalle as descripcion_producto,p.imagen,p.estado
    from inventario.tbl_producto p
    inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
    inner join inventario.tbl_marca m on p.id_marca=m.id_marca
    where p.estado='A' and c.estado='A' and m.estado='A'";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function obtener_producto_por_id_para_ingreso($id_producto){
  $sql="select p.id_producto, concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,
p.precio,p.detalle as descripcion_producto,p.imagen,p.estado
from inventario.tbl_producto p
inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
inner join inventario.tbl_marca m on p.id_marca=m.id_marca
where p.estado='A' and c.estado='A' and m.estado='A' and p.id_producto='".$id_producto."'";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}


function obtener_producto_por_id_para_cotizar($id_producto){
  $sql="select p.id_producto,c.descripcion as categoria,m.descripcion as marca,
p.id_modelo as modelo,p.precio,p.costo_minimo,p.costo_standar,p.detalle as descripcion_producto,p.imagen,p.estado,
case
when  t1.saldo_actual is null then '0' else t1.saldo_actual
end as saldo_actual
from inventario.tbl_producto p
inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
inner join inventario.tbl_marca m on p.id_marca=m.id_marca
left join 
(SELECT sum(saldo_actual) as saldo_actual,id_producto FROM inventario.tbl_inventario_bodega
group by id_producto)t1 on t1.id_producto=p.id_producto
where p.estado='A' and c.estado='A' and m.estado='A'
and p.id_producto='".$id_producto."'";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}

function obtener_producto_por_id($id_producto){
  $sql="select p.id_producto,c.descripcion as categoria,m.descripcion as marca,
p.id_modelo as modelo,p.precio,p.detalle as descripcion_producto,p.imagen,p.estado,p.costo_minimo,p.costo_maximo,p.costo_standar
from inventario.tbl_producto p
inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
inner join inventario.tbl_marca m on p.id_marca=m.id_marca
where  p.id_producto='".$id_producto."'";

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
}


function crear_bodega_nueva($empresa,$nom_bodega,$telefono,$correo,$direccion,$ciudad,$detalles){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_bodega(id_empresa,nombre,direccion,correo,telefono,ciudad,observaciones)values('".$empresa."','".$nom_bodega."','".$direccion."','".$correo."','".$telefono."','".$ciudad."','".$detalles."') ";
   
        if($this->db_autenticacion->query($sql)){          
            return 1;
        }else{
         return 0; }
}

function actualizar_producto_data($data){
   $sql="update inventario.tbl_producto   set precio='".$data['precio']."', detalle='".$data['descripcion']."', imagen='".$data['ruta']."', costo_minimo='".$data['costo_minimo']."', costo_standar='".$data['costo_standar']."', costo_maximo='".$data['costo_maximo']."' where id_producto='".$data['id_producto']."' ";
       //  var_dump($sql);//die;
   if($query = $this->db_autenticacion->query($sql)){
                return 1;
        }else{
                return 0;
        }
            
}

function actualizar_producto_data_sin_imagen($data){
   $sql="update inventario.tbl_producto set precio='".$data['precio']."', detalle='".$data['descripcion']."', costo_minimo='".$data['costo_minimo']."', costo_standar='".$data['costo_standar']."', costo_maximo='".$data['costo_maximo']."' where id_producto='".$data['id_producto']."' ";         
       $this->db_autenticacion->query($sql);        
}


function actualizar_imagen($data){
   $sql="update inventario.tbl_producto set  imagen='".$data['ruta']."' where id_producto='".$data['id_producto']."' ";
       //  var_dump($sql);//die;
       $this->db_autenticacion->query($sql);        
}


function crear_producto_data($data){
    
     $user_id = $this->session->userdata('user_id');
   $sql="insert into  inventario.tbl_producto(id_categoria,id_marca,id_modelo,precio,detalle,usuario,costo_minimo,costo_maximo,costo_standar) values('".$data['producto']."','".$data['marca']."','".$data['modelo']."','".$data['precio']."','".$data['detalle']."','".$user_id."','".$data['costo_minimo']."','".$data['costo_maximo']."','".$data['costo_standar']."') ";        

        if($query = $this->db_autenticacion->query($sql)){
                $last_id = $this->db_autenticacion->insert_id();
              return $last_id;
        }else{
                return 0;
        }       
}
 function obtener_bodegas_por_empresa($id_empresa)
    {
        $sql= "SELECT * FROM inventario.tbl_bodega where id_empresa=".$id_empresa." and estado='A';" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }
    
function eliminar_bodega_empresa($id_bodega){
        $sql="update inventario.tbl_bodega set estado='I' where id_bodega='".$id_bodega."' ";
        if($query = $this->db_autenticacion->query($sql)){
                return 1;
        }else{
                return 0;
        }
        
        }

 function eliminar_guia_egreso($id_egresocab){
        $sql="update inventario.tbl_egresocab set estado='I'  where id_egresocab='".$id_egresocab."' ";
        $sql2="update inventario.tbl_egresodet set estado='I'  where id_egresocab='".$id_egresocab."' ";
        if( $this->db_autenticacion->query($sql) && $this->db_autenticacion->query($sql2) ){
                
               $this->listar_guias_egreso();
        }else{
                return 0;
        }
        
        }

function abrir_guia_cotizacion($cliente,$email){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_cotizacionescab(cliente,tipo,email,usuario)values('".$cliente."','CA','".$email."','".$user_id."') ";
   
        if($this->db_autenticacion->query($sql)){
            $last_id = $this->db_autenticacion->insert_id();
            return $last_id;
        }else{
         return 0; }
            }

function  obtener_cab_cotizacion_guia($id_cotizacion){
    
     $sql="SELECT concat(u.first_name,' ',u.last_name)as cotizador,cab.*
            FROM inventario.tbl_cotizacionescab cab 
            inner join inventario.users u on cab.usuario=u.id
            where cab.id_cotizacionescab='".$id_cotizacion."' ";

     $query = $this->db_autenticacion->query($sql); 
     return $query->result_array();
     $query->next_result();
    
}      

function  obtener_det_cotizacion_guia($id_cotizacion){
    
     $sql="select  concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,p.detalle,cot.*
                    from inventario.tbl_producto p
                    inner join inventario.tbl_cotizacionesdet cot on p.id_producto=cot.id_producto
                    inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
                    inner join inventario.tbl_marca m on p.id_marca=m.id_marca
                    where cot.estado='A' and cot.id_cotizacionescab='".$id_cotizacion."'";
     $query = $this->db_autenticacion->query($sql); 
     return $query->result_array();
     $query->next_result();
    
}         
 
  function obtener_clientes_cotizar()
    {
        $sql= "SELECT distinct(cliente) FROM inventario.tbl_cotizacionescab where estado='A'" ;

        $query = $this->db_autenticacion->query($sql); 
        return $query->result_array();
    }      
        
  function guardar_registro_cotizacion($id_cotizacion,$id_producto,$costo_cotizado,$cantidad,$subtotal){
        $user_id = $this->session->userdata('user_id');
        $sql="insert into inventario.tbl_cotizacionesdet(id_producto,costo_cotizado,cantidad,subtotal,user_registro,id_cotizacionescab)
        values('".$id_producto."','".$costo_cotizado."','".$cantidad."','".$subtotal."','".$user_id."','".$id_cotizacion."') ";
   
        if($this->db_autenticacion->query($sql)){
             $sql="select  concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,cot.*
                    from inventario.tbl_producto p
                    inner join inventario.tbl_cotizacionesdet cot on p.id_producto=cot.id_producto
                    inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
                    inner join inventario.tbl_marca m on p.id_marca=m.id_marca
                    where cot.estado='A' and cot.id_cotizacionescab='".$id_cotizacion."'   ";
             $query = $this->db_autenticacion->query($sql); 
             return $query->result_array();
        }else{
         return 0; }
            }      

} ?>
