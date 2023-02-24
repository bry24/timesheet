<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
    class EmployeeModel extends CI_Model {
    
        function __construct(){
            parent::__construct();
        }

        public function getdata() {
            
        }
        public function insertEmployee($data) {
            $this->db->insert('employees',$data);
        }
        public function updateEmployee($data) {
            $this->db->where('id', $data['id']);
            $this->db->update('employees', $data);
        }
        public function deleteEmployee($data, $isMulti = false) {
            if($isMulti){
                $ids = explode(",",$data['id']);
                $this->db->where_in('id', $ids);
            }
            else{
                $this->db->where_in('id', $data['id']);
            }
            $this->db->delete('employees');
        }
        function encodeURIComponent($str){
            $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
            return strtr(rawurlencode($str), $revert);
          }
        public function getEmployeeTimeRecord($id_machine = false) {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');
                if($id_machine){
                    $id = $id_machine;
                }
                // validate employee id
                $this->db->select('e.*');
                $this->db->from('employees e');
                $this->db->where('e.id', $id);
                $query = $this->db->get();
                if($query->num_rows()==1)
                { 
                    //check employee last record - if yes get the last row check if time in and out have values, if time in has value show time out only, if time out has value insert new + show time in only
                    $result = array();
                    $this->db->select('t.*,e.*, t.id AS time_record_id, e.id AS employee_id');
                    $this->db->from('time_records t');
                    $this->db->join('employees e', 't.employee_id = e.id', 'left');
                    $this->db->where('e.id', $id);
                    $this->db->order_by("time_record_id", "DESC");
                    $query2 = $this->db->get();
                    if($query2->num_rows()>=1)
                    {
                        $final = array();
                        $result = $query2->row_array();
                        return $result;
                    }
                    else{
                       
                        $result = $query->row_array();
                        $result['time_out'] = date('Y-m-d H:i:s');
                        return $result;
                    }
                }
                else{
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        public function getEmployees() {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');

                $this->db->select('e.*,u.user_name');
                $this->db->from('employees e');
                $this->db->join('users u', 'e.created_by = u.id', 'left');
                $this->db->where('e.id', $id);
                $query = $this->db->get();
                if($query->num_rows()==1)
                {
                    $result = $query->row_array();
                    $result['qr_url'] = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=".$result['id'];
                    $result['id_url'] = "qrURL?url=".$this->encodeURIComponent('https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.$result['id']);
                    return $result;
                }
                else{
                    return false;
                }
            }

            $output= array();
            $this->db->select('e.*, u.user_name');
            $this->db->from('employees e');
            $this->db->join('users u', 'e.created_by = u.id', 'left');
            $query = $this->db->get();
            if($query->num_rows())
            {
                $result_num_rows = $query->num_rows();
                $result = $query->result_array();
                $data = array();
                foreach ($result as $key => $value) {
                    $sub_array = array();
                    $sub_array[] = '<input type="checkbox" class="checkboxes" value="1" data-id="'.$value['id'].'" />';
                    $sub_array[] = $value['id'];
                    $sub_array[] = $value['last_name'].", ".$value['first_name'];
                    $sub_array[] = $value['user_name'];
                    $sub_array[] = $value['datetime_add'];
                    $sub_array[] = '<a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-secondary btn-sm qrbtn" >QR</a> <a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-primary btn-sm editbtn" >Edit</a>  <a href="javascript:;" data-id="'.$value['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
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
       
        public function setEmployeeTimeOut($id_machine = false) {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');
                if($id_machine){
                    $id = $id_machine;
                }
                $data = array();
                $udata = $this->session->userdata('UserSession');
                $data['user_id'] = $udata['id'];
                $data['time_out'] = date('Y-m-d H:i:s');
                $this->db->where('id', $id);
                $this->db->update('time_records', $data);
                $data['success'] = true;
                return $data;
            }
            else
            {
                return false;
            }
        } 
        public function setEmployeeTimeIn($id_machine = false) {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');
                if($id_machine){
                    $id = $id_machine;
                }
                $data = array();
                $data['employee_id'] = $id;
                $udata = $this->session->userdata('UserSession');
                $data['user_id'] = $udata['id'];
                $this->db->insert('time_records', $data);
                $data['success'] = true;
                return $data;
            }
            else
            {
                return false;
            }
        } 
        public function setEmployeeTimeRecord() {
            if($this->input->post('id'))
		    {
                $id = $this->input->post('id');
                $employee_time_record = $this->getEmployeeTimeRecord($id);
                if($employee_time_record){
                    // print_r($employee_time_record);exit;
                    if(!$employee_time_record['time_out']){
                        $this->setEmployeeTimeOut($employee_time_record['time_record_id']);
                        $time_record_type = "Time out";
                    }
                    else{
                        $this->setEmployeeTimeIn($employee_time_record['employee_id']);
                        $time_record_type = "Time in";
                    }
                    $data = array();
                    $data['employee_id'] = $id;
                    $data['time_record_type'] = $time_record_type;
                    $data['success'] = true;
                    return $data;
                }
                else{
                    return false;
                }
            }
            else
            {
                return false;
            }
        } 

    }

?>