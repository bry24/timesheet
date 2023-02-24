<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['post_controller_constructor'][] = array(
	'class'    => 'Hooks',
	'function' => 'authorization',
	'filename' => 'Hooks.php',
	'filepath' => 'hooks'
);
?>