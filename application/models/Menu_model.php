<?php
class Menu_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->db_autenticacion = $this->load->database('autenticacion', TRUE);
    }
	public function all()
	{

        $user_id = $this->session->userdata('user_id');

        $this->db_autenticacion->select('menus.*');
        $this->db_autenticacion->from('menus');
        $this->db_autenticacion->join('menus_groups', 'menus_groups.menus_id = menus.id','inner');
        $this->db_autenticacion->join('groups', 'groups.id = menus_groups.groups_id','inner');
        $this->db_autenticacion->join('users_groups', 'users_groups.group_id = groups.id','inner');
        $this->db_autenticacion->join('users', 'users.id = users_groups.user_id','inner');
        $this->db_autenticacion->where('users.id', $user_id);
        $this->db_autenticacion->where('menus.status', '1');
        $query = $this->db_autenticacion->get();
        //die($this->db_autenticacion->last_query());
        return $query->result_array();


	}
    public function get_menu($id=null)
    {

        //$user_id = $this->session->userdata('user_id');

        $this->db_autenticacion->select('menus.*');
        $this->db_autenticacion->from('menus');
        $this->db_autenticacion->join('menus_groups', 'menus_groups.menus_id = menus.id','inner');
        $this->db_autenticacion->join('groups', 'groups.id = menus_groups.groups_id','inner');
        //$this->db_autenticacion->join('users_groups', 'users_groups.group_id = groups.id','inner');
        //$this->db_autenticacion->join('users', 'users.id = users_groups.user_id','inner');
        //$this->db_autenticacion->where('users.id', $user_id);
        $this->db_autenticacion->where('menus.status', '1');
        $this->db_autenticacion->where('menus.parent', $id);

        $query = $this->db_autenticacion->get();
        //die($this->db_autenticacion->last_query());
        return $query->result_array();


    }
    public function get_menu_x_groups($group_id, $parent_id=null)
    {

        //$user_id = $this->session->userdata('user_id');

        $this->db_autenticacion->select('menus.*');
        $this->db_autenticacion->from('menus');
        $this->db_autenticacion->join('menus_groups', 'menus_groups.menus_id = menus.id','inner');
        $this->db_autenticacion->join('groups', 'groups.id = menus_groups.groups_id','inner');
        //$this->db_autenticacion->join('users_groups', 'users_groups.group_id = groups.id','inner');
        //$this->db_autenticacion->join('users', 'users.id = users_groups.user_id','inner');
        //$this->db_autenticacion->where('users.id', $user_id);
        $this->db_autenticacion->where('menus.status', '1');
        $this->db_autenticacion->where('menus.parent', $parent_id);
        $this->db_autenticacion->where('groups.id', $group_id);
        $query = $this->db_autenticacion->get();
        //die($this->db_autenticacion->last_query());
        return $query->result_array();


    }
    public function get_menu_x_groups_childs($group_id,$id_parent)
    {

        //$user_id = $this->session->userdata('user_id');

        $this->db_autenticacion->select('menus.*');
        $this->db_autenticacion->from('menus');
        $this->db_autenticacion->join('menus_groups', 'menus_groups.menus_id = menus.id','inner');
        $this->db_autenticacion->join('groups', 'groups.id = menus_groups.groups_id','inner');
        //$this->db_autenticacion->join('users_groups', 'users_groups.group_id = groups.id','inner');
        //$this->db_autenticacion->join('users', 'users.id = users_groups.user_id','inner');
        //$this->db_autenticacion->where('users.id', $user_id);
        $this->db_autenticacion->where('menus.status', '1');
        $this->db_autenticacion->where('menus.parent', $id_parent);
        $this->db_autenticacion->where('groups.id', $group_id);
        $query = $this->db_autenticacion->get();
        //die($this->db_autenticacion->last_query());
        return $query->result_array();


    }


}