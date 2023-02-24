<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
    class TimerecordModel extends CI_Model {
    
        function __construct(){
            parent::__construct();
        }

        public function getdata() {
            
        }
        public function getTimerecords() {
            $output= array();
            $this->db->select('t.*,e.last_name,e.first_name,u.user_name');
            $this->db->from('time_records t');
            $this->db->join('employees e', 't.employee_id = e.id', 'left');
            $this->db->join('users u', 't.user_id = u.id', 'left');
            $query = $this->db->get();
            if($query->num_rows())
            {
                $result_num_rows = $query->num_rows();
                $result = $query->result_array();
                $data = array();
                foreach ($result as $key => $value) {
                    $sub_array = array();
                    $sub_array[] = $value['id'];
                    $sub_array[] = $value['last_name'].", ".$value['first_name'];
                    $sub_array[] = $value['time_in'];
                    $sub_array[] = $value['time_out'];
                    $sub_array[] = $value['user_name'];
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