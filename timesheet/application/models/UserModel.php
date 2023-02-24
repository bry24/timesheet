<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
    class UserModel extends CI_Model {
    
        function __construct(){
            parent::__construct();
        }

        public function getdata() {
            
        }
        public function insertuser($data) {
            $this->db->insert('users',$data);
        }
        public function updateuser($data) {
            $this->db->where('id', $data['id']);
            $this->db->update('users', $data);
        }
        public function deleteUser($data, $isMulti = false) {
            if($isMulti){
                $ids = explode(",",$data['id']);
                $this->db->where_in('id', $ids);
            }
            else{
                $this->db->where_in('id', $data['id']);
            }
            $this->db->delete('users');
        }
        public function loginuser($password, $username) {
            $query = $this->db->query("SELECT * FROM users WHERE user_password='$password' AND user_name='$username'");
            if($query->num_rows()==1)
            {
                return $query->row();
            }
            else
            {
                return false;
            }
        }
        public function getUsers() {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');
                $query = $this->db->query("SELECT * FROM users WHERE id='$id'");
                if($query->num_rows()==1)
                {
                    return $query->row();
                }
                else{
                    return false;
                }
            }

            $output= array();
            $query = $this->db->query("SELECT * FROM users");
            if($query->num_rows())
            {
                $result_num_rows = $query->num_rows();
                $result = $query->result_array();
                $data = array();
				$udata = $this->session->userdata('UserSession');
                foreach ($result as $key => $value) {
                    if($value['user_type'] == 1){
                        $user_type = 'Super Admin';
                    }
                    else if($value['user_type'] == 2){
                        $user_type = 'Admin';
                    }
                    $sub_array = array();
                    
                    if($udata['id'] == $value['id']){
                        $sub_array[] = '';
                    }
                    else{
                        $sub_array[] = '<input type="checkbox" class="checkboxes" value="1" data-id="'.$value['id'].'" />';
                    }
                    $sub_array[] = $value['id'];
                    $sub_array[] = $value['user_name'];
                    $sub_array[] = $user_type;
                    $sub_array[] = $value['datetime_add'];
                    
                    if($udata['id'] == $value['id']){
                        $sub_array[] = '<a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-primary btn-sm editbtn" >Edit</a>';
                    }
                    else{
                        $sub_array[] = '<a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-primary btn-sm editbtn" >Edit</a>  <a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
                    }
                    
                    $data[] = $sub_array;
                }
                
                $output = array(
                    'recordsTotal' =>$result_num_rows ,
                    'recordsFiltered'=>   $result_num_rows,
                    'data'=>$data,
                );
                return $output;
            }
            else
            {
                return false;
            }
        }
        

    }

?>