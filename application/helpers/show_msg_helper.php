<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('show_error_msg')){
    function show_error_msg(){
    	$ci=& get_instance();
    	$msg = '';
        if(!empty($ci->session->flashdata('error'))){
        	$msg .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        	$msg .= '<strong>Error!</strong>&nbsp;'.$ci->session->flashdata('error');
			$msg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			$msg .= ' <span aria-hidden="true">&times;</span>';
			$msg .= '</button>';
			$msg .= ' </div>';
            echo $msg;
        }
    }   
}


if ( ! function_exists('show_success_msg')){
    function show_success_msg(){
        $ci=& get_instance();
        $smsg = '';
        if(!empty($ci->session->flashdata('success'))){
            $smsg .= '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $smsg .= '<strong>Success!</strong>&nbsp;'.$ci->session->flashdata('success');
            $smsg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $smsg .= ' <span aria-hidden="true">&times;</span>';
            $smsg .= '</button>';
            $smsg .= ' </div>';
            echo $smsg;
        }
    	
    }   
}