<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hooks

{
	function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->library('session');
	}
	function authorization()
	{
		// $class = $this->CI->router->fetch_class();
		// 	$method = $this->CI->router->fetch_method();
		// 	print_r($class . " ". $method);exit;
		if($this->CI->session->userdata('UserSession'))
		{
			$class = $this->CI->router->fetch_class();
			$method = $this->CI->router->fetch_method();
			if($class == 'home' && $method == 'index'){
				redirect(base_url().'admin/employees');
			}
		}
		else{
			// redirect(base_url());
			// exit;
		}
	}
}
