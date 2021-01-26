<?php

class Administracion_model extends CI_Model
{
    
       

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
               $this->db_autenticacion = $this->load->database('autenticacion', TRUE);

      
       

    }


    function listar_informacion_usuario()
    {
        $query = $this->db->query("select 
        u.id,
        p.nombres,
        p.apellidos,
        p.telefono,
        u.email,
        p.cedula,
        case when u.estado = 1 then 'Activo' else 'Inactivo' end as estado,
        case when u.estado = 1 then 'success' else 'danger' end as clase 
        from falixso_master.users u 
        inner join falixso_master.persona p on p.user_id = u.id");
        return $query->result_array();
    }

    function cdu_data_carpetas($data, $op)
    {
        //$root .= "assets/rutas";
 
        $root_imagen = "http://".$_SERVER['HTTP_HOST'];
        $root_imagen .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        try{
            if($op == 1){
                $root ="/home/falixso/rotary.falixso.com/assets/rutas/".$data["nombre"];
                //var_dump($root); die;
                if(!mkdir($root, 0777, true)) {
                    $respuesta = ['op' => 1, 'mensaje' => "Fallo al crear las carpetas, intentelo en unos momentos"];
                }else {
                    $query = $this->db->query("select * from falixso_bd_rotary.rutas_carpetas where nombre = '" . $data["nombre"] . "' ");
                    $rs = $query->result_array();
                    if (count($rs) == 0) {
                        $data_tabla_user = array(
                            'id_relacion' => 0,
                            'nivel' => 0,
                            'nombre' => $data["nombre"],
                            'ruta' => '/rutas/'.$data["nombre"],
                            'open_close_div' => '{ "opened" : true }',
                            'fecha_crea' => date("Y-m-d"),
                            'estado' => 1,
                            'usuario_crea' => $this->session->userdata("id")
                        );
                        $this->db->insert('rutas_carpetas', $data_tabla_user);
                        $id = $this->db->insert_id();
                        $_SESSION["dta_id_ruta"] = $id;
                        $respuesta = ['op' => 0,'nueva_ruta_id' => $id, 'mensaje' => "Carpeta creada con éxito"];
                    } else {
                        $respuesta = ['op' => 1,  'mensaje' => "Ya existe una carpeta con el nombre " . $data["nombre"]];
                    }
                }
            }
            if($op == 2){
                $root ="/home/falixso/rotary.falixso.com/assets/rutas/".$data["nombre_texto"]."/". $data["nombre"];
                //var_dump($root); die;
                if(!mkdir($root, 0777, true)) {
                    $respuesta = ['op' => 1, 'mensaje' => "Fallo al crear las carpetas, intentelo en unos momentos"];
                }else {
                    $query = $this->db->query("select * from falixso_bd_rotary.rutas_carpetas where nombre = '" . $data["nombre"] . "' ");
                    $rs = $query->result_array();
                    if (count($rs) == 0) {
                        $data_tabla_user = array(
                            'id_relacion' => $data["opcion"],
                            'nivel' => 0,
                            'nombre' => $data["nombre"],
                            'ruta' => '/rutas/'.$data["nombre_texto"].'/'.$data["nombre"],
                            'open_close_div' => '{ "opened" : true }',
                            'fecha_crea' => date("Y-m-d"),
                            'estado' => 1,
                            'usuario_crea' => $this->session->userdata("id")
                        );
                        $this->db->insert('rutas_carpetas', $data_tabla_user);
                        $id = $this->db->insert_id();
                        $_SESSION["dta_id_ruta"] = $id;
                        $respuesta = ['op' => 0,'nueva_ruta_id' => $id, 'mensaje' => "Carpeta creada con éxito"];
                    } else {
                        $respuesta = ['op' => 1, 'mensaje' => "Ya existe una carpeta con el nombre " . $data["nombre"]];
                    }
                }
            }
        }catch (Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }

        return $respuesta;
    }

    function insertar_data_socio($data)
    {
        try{
            $rs = $this->validar_campos($data);
           // var_dump($rs["resp"]); die;
            if($rs["resp"]){
                $salt = False ? '' : FALSE;
                $clave = $this->genera_clave();
                $password = $this->hash_password($clave, $salt);
                //var_dump($password); die;
                $data_tabla_user = array(
                    'username' => $data["usuario"],
                    'password' => $password,
                    'email' => $data["correo"],
                    'created_on' => date("Y-m-d"),
                    'estado' => 1,
                    'id_empresa' => $this->session->userdata("id_empresa")
                );

                $this->db->insert('users', $data_tabla_user);
                $id = $this->db->insert_id();

                $data_tabla_persona = array(
                    'nombres' => $data["nombres"],
                    'apellidos' => $data["apellidos"],
                    'cedula' => $data["cedula"],
                    'user_id' => $id,
                    'fotografia' => '/images/usuarios/default.PNG',
                    'estado' => 1,
                    'usuario_crea' => $this->session->userdata("id"),
                    'direccion' => $data["direccion"],
                    'telefono' => $data["telefono"],
                    'celular' => $data["celular"],
                    'pagina' => $data["pagina"],
                    'ciudad' => $data["ciudad"],
                    'acerca_de_mi' => $data["acerca"],
                    'fecha_nace' => date("Y-m-d"), //$data["fecha_nace"],
                    'edad' => 30
                );
                $this->db->insert('persona', $data_tabla_persona);

                //Envio mail con la clave
                /*if ($this->config->item("envio_email")) {
                    $data = ["clave" => $clave, "nombres" => $data["nombres"], "apelidos" => $data["apellidos"],
                        "usuario" => $data["usuario"]];
                    //Envia Email Usuario
                    $this->load->library("email");
                    $this->email->from($this->config->item("correo_admin"));
                    $this->email->to("gabriel.huayamabe@controlsanitario.gob.ec");//poner mail del técnico
                    $this->email->subject("Notificación de creación de socio sistema rotary");
                    $message = $this->load->view('templates_mail/creacion_socio', $data, true);
                    $this->email->message($message);
                    $this->email->send();
                    $respuesta = ['op' => 0, 'mensaje' => "Correo enviado."];
                } else {
                    $respuesta = ['op' => 1, 'mensaje' => "Correo no ha sido enviado, consulte con el administrador."];
                }*/
                //
                $respuesta = ['op'=>0,'mensaje' => "Socio Ingresado con éxito"];
            }else{
                $respuesta = ['op'=>1,'mensaje' => $rs["mensaje"]];
            }

        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function validar_campos($data)
    {
        $query = $this->db->query("select * from falixso_bd_rotary.users where username = '".$data["usuario"]."'");
        $resp = $query->result_array();
        $respuesta = ['resp'=>true,'mensaje' => ""];
        if(count($resp) > 0){
            $respuesta = ['resp'=>false,'mensaje' => "Ya existe el nombre de usuario ".$data["usuario"]];
        }

        $query = $this->db->query("select * from falixso_bd_rotary.users where email = '".$data["correo"]."'");
        $resp = $query->result_array();
        $respuesta = ['resp'=>true,'mensaje' => ""];
        if(count($resp) > 0){
            $respuesta = ['resp'=>false,'mensaje' => "Ya existe el correo ".$data["correo"]];
        }

        $query = $this->db->query("select * from falixso_bd_rotary.persona where cedula = '".$data["cedula"]."'");
        $resp = $query->result_array();
        $respuesta = ['resp'=>true,'mensaje' => ""];
        if(count($resp) > 0){
            $respuesta = ['resp'=>false,'mensaje' => "Ya existe la cedula ".$data["cedula"]];
        }
        return $respuesta;
    }

    function data_cargar_menu_socios($data)
    {
        try{
            $query = $this->db->query("select 
            id,
            parent,
            name,
            slug
            from falixso_bd_rotary.menus m
            where m.status = 1 and parent is null
            order by id asc;");
            $resp_menu = $query->result_array();
            $query = $this->db->query("select * from falixso_bd_rotary.users_groups where user_id = ".$data["id_usuario"]);
            $resp_menu_user = $query->result_array();
            $respuesta = ['op'=>0,'mensaje' => "", 'res_menu' => $resp_menu , 'res_menu_user' => $resp_menu_user];
        }catch (Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }

        return $respuesta;
    }

    function guardar_asignar_menu_socio($data)
    {
        try{
            $data_split_t = explode("_",$data["id_group_t"]);
            $data_split_f = explode("_",$data["id_group_f"]);
            //primero eliminamos los gupos que se quitó al usuario
            for($i=0; $i< count($data_split_f); $i++) {
                if($data_split_f[$i] != ""){
                    $query = $this->db->query("delete from falixso_bd_rotary.users_groups where user_id = " . $data["socio_id"] . " 
                    and group_id = " . $data_split_f[$i]);
                }
            }
            //

            //segundo insertamos los gupos que se agregó al usuario
            for ($i = 0; $i < count($data_split_t); $i++) {
                if($data_split_t[$i] != "") {
                    $select = $this->db->query("select * from falixso_bd_rotary.users_groups where user_id = ".$data["socio_id"]." 
                    and group_id = ". $data_split_t[$i]);
                    $rs = $select->result_array();
                    if(count($rs) == 0){
                        $query = $this->db->query("insert into falixso_bd_rotary.users_groups(user_id,group_id)
                        select " . $data["socio_id"] . " , " . $data_split_t[$i]);
                    }
                }
            }
            //

            $respuesta = ['op'=>0,'mensaje' => "Datos guardados"];
        }catch (Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function genera_clave()
    {
        $opc_letras = TRUE; //  FALSE para quitar las letras
        $opc_numeros = TRUE; // FALSE para quitar los números
        $opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
        $opc_especiales = FALSE; // FALSE para quitar los caracteres especiales
        $longitud = 25;
        $password = "";

        $letras ="abcdefghijklmnopqrstuvwxyz";
        $numeros = "1234567890";
        $letrasMayus = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $especiales ="|@#~$%()=^*+[]{}-_";
        $listado = "";

        if ($opc_letras == TRUE) {
            $listado .= $letras; }
        if ($opc_numeros == TRUE) {
            $listado .= $numeros; }
        if($opc_letrasMayus == TRUE) {
            $listado .= $letrasMayus; }
        if($opc_especiales == TRUE) {
            $listado .= $especiales; }

        str_shuffle($listado);
        for( $i=0; $i<$longitud; $i++) {
            $password[$i] = $listado[rand(1,strlen($listado))];
            str_shuffle($listado);
        }

        $dato_password_ = "";

        foreach ($password as $dato_password) {
            $dato_password_ .= $dato_password;
        }

        return $dato_password_;
    }





    public function hash_password($password, $salt = false, $use_sha1_override = FALSE)
    {
        if (empty($password)) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
            return $this->bcrypt->hash($password);
        }

        return sha1($password . $salt);

    }

    function informacion_usuario_admin($id_socio)
    {
        $query = $this->db->query("select u.id, u.username,
        cast(u.created_on as date) as fecha_creacion,
        p.nombres, p.apellidos,
        p.fotografia,
        p.telefono,
        p.celular,
        p.acerca_de_mi,
        p.edad,
        p.fecha_nace,
        p.cedula,
        u.email,
        p.direccion,
        p.pagina,
        p.ciudad
        from falixso_bd_rotary.users u 
        inner join falixso_bd_rotary.persona p on p.user_id = u.id
        where u.id = ". $id_socio);
        return $query->result_array();
    }

    function editar_data_socio($data)
    {
        try{

            //var_dump($data); die;
            $query = $this->db->query("update falixso_bd_rotary.users set email = '".$data["correo"]."' 
            where id = ". $data["id_usuario"]);
            $query = $this->db->query("
            update falixso_bd_rotary.persona set nombres = '".$data["nombres"]."', apellidos = '".$data["apellidos"]."', 
            fecha_modificacion = '".date("Y-m-d")."' , usuario_modifica = '".$data["id_usu_modi"]."' ,
             direccion = '".$data["direccion"]."', telefono = '".$data["telefono"]."'
             , celular = '".$data["celular"]."', pagina = '".$data["pagina"]."'
             , ciudad = '".$data["ciudad"]."', acerca_de_mi = '".$data["acerca"]."', fecha_nace = '".date("Y-m-d")."'
            where user_id = ". $data["id_usuario"]);

            $respuesta = ['op'=>0,'mensaje' => 'Socio Editado'];


        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function desactiva_data_socio($data)
    {
        try{
            $this->db->query("update falixso_bd_rotary.users set estado = 0 where id = ". $data["id_socio_desactiva"]);
            $this->db->query("update falixso_bd_rotary.persona set estado = 0, fecha_inactiva = '".date("Y.m.d")."' 
            , usuario_elimina = ".$data["id_usu_desactiva"]."  where id = ". $data["id_socio_desactiva"]);
            $respuesta = ['op'=>0,'mensaje' => 'Socio Desactivado'];


        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function data_admin_carga_img_temporal($data)
    {
        try{
             
        $root_imagen = "http://".$_SERVER['HTTP_HOST'];
        $root_imagen .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            $query = $this->db->query("select * from falixso_bd_rotary.rutas_carpetas where id = ". $data["id_nuevo"]);
            $data_select = $query->result_array();
            //$root ="C:/wamp/www/rotary/assets/rutas/".$data["nombre_texto"]."/". $data["nombre"];
            $upload_folder  = "/home/falixso/rotary.falixso.com/assets".$data_select[0]["ruta"];
            $archivador = $data["nombre_archivo"];
            $tmp_archivo = $data["tmp_archivo"];
            //$carpetaAdjunta = $upload_folder . "/" . $nombreCarpeta;
            $rutaArchivo = $upload_folder."/".$archivador;
           // var_dump($rutaArchivo);var_dump($tmp_archivo); die;
            if (move_uploaded_file($tmp_archivo, $rutaArchivo)) {
                $data_tabla_user = array(
                    'id_relacion' => $data_select[0]["id"],
                    'nivel' => 1,
                    'nombre' => $data["nombre_archivo"],
                    'ruta' => $data_select[0]["ruta"] . "/" . $data["nombre_archivo"],
                    'open_close_div' => '{ "opened" : true }',
                    'fecha_crea' => date("Y-m-d"),
                    'estado' => 1,
                    'usuario_crea' => $this->session->userdata("id")
                );
                $this->db->insert('rutas_carpetas', $data_tabla_user);
            }
            $respuesta = ['op'=>0,'mensaje' => 'Socio Desactivado'];
        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function data_buscar_ruta_texto($data)
    {
        try{

            $query = $this->db->query("select id, ruta from falixso_bd_rotary.rutas_carpetas where nivel = 0 and  ruta like '%".$data["texto"]."%'
            and estado = 1");
            $data_select = $query->result_array();
            if(count($data_select) > 0){
                $html = "";
                foreach ($data_select as $row){
                    $html .= "<ul>";
                    $html .= "<il>";
                    if($data["op"] == 1){
                        $html .= "<a onclick='rutaSeleccion(id)' id='".$row["id"]."_".$row["ruta"]."' style='cursor: pointer'>".$row["ruta"]."</a>";
                    }else{
                        $html .= "<a onclick='rutaSeleccion2(id)' id='".$row["id"]."_".$row["ruta"]."' style='cursor: pointer'>".$row["ruta"]."</a>";
                    }

                    $html .= "</il>";
                    $html .= "</ul>";
                }
                $respuesta = ['op'=>0,'mensaje' => $html];
            }else{
                $html = "<ul>";
                $html .= "<il>";
                $html .= "No se encontraron coincidencias";
                $html .= "</il>";
                $html .= "</ul>";
              $respuesta = ['op'=>0,'mensaje' => $html];
            }
        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }


    function data_admin_carga_img_en_rutas($data)
    {
        try{
             
        $root_imagen = "http://".$_SERVER['HTTP_HOST'];
        $root_imagen .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            $upload_folder  = "/home/falixso/rotary.falixso.com/assets".$data["rtua_inserta"];
            $archivador = $data["nombre_archivo"];
            $tmp_archivo = $data["tmp_archivo"];
            //$carpetaAdjunta = $upload_folder . "/" . $nombreCarpeta;
            $rutaArchivo = $upload_folder."/".$archivador;
            // var_dump($rutaArchivo);var_dump($tmp_archivo); die;
            if (move_uploaded_file($tmp_archivo, $rutaArchivo)) {
                $data_tabla_user = array(
                    'id_relacion' => $data["id_nuevo"],
                    'nivel' => 1,
                    'nombre' => $data["nombre_archivo"],
                    'ruta' => $data["rtua_inserta"] . "/" . $data["nombre_archivo"],
                    'open_close_div' => '{ "opened" : true }',
                    'fecha_crea' => date("Y-m-d"),
                    'estado' => 1,
                    'usuario_crea' => $this->session->userdata("id")
                );
                $this->db->insert('rutas_carpetas', $data_tabla_user);
                $respuesta = ['op'=>0,'mensaje' => 'Directorio Creado'];
            }
            $respuesta = ['op'=>0,'mensaje' => 'Socio Desactivado'];
        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function data_guarda_carpetas_en_ruta($data)
    {
        try{
             
        $root_imagen = "http://".$_SERVER['HTTP_HOST'];
        $root_imagen .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            //$root ="C:/wamp/www/rotary/assets/rutas/".$data["nombre_texto"]."/". $data["nombre"];
            $upload_folder = "/home/falixso/rotary.falixso.com/assets".$data["ruta"]."/".$data["nombre_carpeta"];
            // var_dump($rutaArchivo);var_dump($tmp_archivo); die;

            if (!mkdir($upload_folder, 0777, true)) {
                $respuesta = ['op' => 1, 'mensaje' => "Fallo al crear las carpetas, intentelo en unos momentos"];
            }else{
                $data_tabla_user = array(
                    'id_relacion' => $data["id_ruta_carga"],
                    'nivel' => 0,
                    'nombre' => $data["nombre_carpeta"],
                    'ruta' => $data["ruta"] . "/" . $data["nombre_carpeta"],
                    'open_close_div' => '{ "opened" : true }',
                    'fecha_crea' => date("Y-m-d"),
                    'estado' => 1,
                    'usuario_crea' => $this->session->userdata("id")
                );
                $this->db->insert('rutas_carpetas', $data_tabla_user);
                $respuesta = ['op'=>0,'mensaje' => 'Directorio Creado'];
            }

        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

    function data_admin_cambiar_nombre($data)
    {
        try{
             
        $root_imagen = "http://".$_SERVER['HTTP_HOST'];
        $root_imagen .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            $split_data = explode("_",$data["id_name"]);
            $split_data_ruta = explode("/",$split_data[1]);
            //$root ="C:/wamp/www/rotary/assets/rutas/".$data["nombre_texto"]."/". $data["nombre"];
            $ruta_antigua =  "/home/falixso/rotary.falixso.com/assets".$split_data[1];

            $split_data_ruta[count($split_data_ruta)-1] = $data["txt_nuevo_nombre"];
            //var_dump(count($split_data_ruta));
            //var_dump($split_data_ruta);
           // var_dump($ruta_antigua);
            $ruta_nueva=  "/home/falixso/rotary.falixso.com/assets";
            $ruta_nueva_ ="";
            $i = 0;
            foreach ($split_data_ruta as $row){
                if($i <(count($split_data_ruta)-1)){
                    $ruta_nueva .= $split_data_ruta[$i]."/";
                    $ruta_nueva_ .= $split_data_ruta[$i]."/";
                }else{
                    $ruta_nueva .= $split_data_ruta[$i];
                    $ruta_nueva_ .= $split_data_ruta[$i];
                }
                $i++;
            }


            if (!rename($ruta_antigua, $ruta_nueva)) {
                $respuesta = ['op' => 1, 'mensaje' => "Fallo al renombrar carpetas, intentelo en unos momentos"];
            }else{
                $query = $this->db->query("update falixso_bd_rotary.rutas_carpetas set nombre = '".$data["txt_nuevo_nombre"]."' ,
                 ruta = '".$ruta_nueva_."' where id = " . $split_data[0]);
                $query = $this->db->query("select * from falixso_bd_rotary.rutas_carpetas where id_relacion = ". $split_data[0]);
                $data_hijos = $query->result_array();
                if(count($data_hijos)>0){
                    foreach ($data_hijos as $row1){
                        $data_split_hijo = explode("/",$row1["ruta"]);
                        $data_split_hijo[count($data_split_hijo)-2] = $data["txt_nuevo_nombre"];
                        $i = 0;
                        $ruta_nueva = "";
                        foreach ($data_split_hijo as $row2){
                            if($i <(count($data_split_hijo)-1)){
                                $ruta_nueva .= $data_split_hijo[$i]."/";
                            }else{
                                $ruta_nueva .= $data_split_hijo[$i];
                            }

                            $i++;
                        }
                        $query = $this->db->query("update falixso_bd_rotary.rutas_carpetas set ruta = '".$ruta_nueva."' where id = " . $row1["id"]);
                    }
                }
                $respuesta = ['op'=>0,'mensaje' => 'Carpeta Renombrada'];
            }

        }catch(Exception $ex){
            $respuesta = ['op'=>1,'mensaje' => "Problemas con la conexión, intentelo en unos minutos"];
        }
        return $respuesta;
    }

}

?>
