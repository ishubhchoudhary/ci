<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function print_pre($data)
    { 
        echo "<pre>";print_r($data);echo "</pre>";       
    }
    
    function print_ex($data)
    { 
        echo "<pre>";print_r($data);echo "</pre>";exit();       
    }
      
    function csrf_field()
    { 
        $ci =& get_instance();
        $csrf = array(
                'name' => $ci->security->get_csrf_token_name(),
                'hash' => $ci->security->get_csrf_hash()
                );      
        return '<input type="hidden" name="'.$csrf['name'].'" value="'.$csrf['hash'].'" />';       
    }

    function hashcode($data){
        return hash('sha512',$data);
    }
   
    function ci_enc($str){
	    $new_str = strtr(base64_encode(addslashes(@gzcompress(serialize($str), 9))), '+/=', '-_.');
        return $new_str;	
    } 
   
    function ci_dec($str){
        $new_str = unserialize(@gzuncompress(stripslashes(base64_decode(strtr($str, '-_.', '+/=')))));
        return $new_str;
    }

    function send_mail($recipients, $subject, $message, $from='')
    {

    //echo 'ok this called';exit;
        $ci =& get_instance();
        $from_email = ($from=='')? $from : SITE_EMAIL;
        $ci->load->library('email');
        $ci->email->clear(TRUE);
        $ci->email->from($from_email, SITE_NAME); 
        $ci->email->to($recipients);

        $ci->email->set_mailtype("html");
        $ci->email->subject($subject);
        $ci->email->message($message);  
        $ci->email->send();
        return TRUE;
    }


   function message()
   { 
      $ci =& get_instance();
     
      if($ci->session->flashdata('success')){ 
        return '<div class="alert alert-success alert-dismissible fade show">
        <p class="mb-0 pb-0">'.$ci->session->flashdata('success').'</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

      } 

      if($ci->session->flashdata('error')){ 
        return '<div class="alert alert-danger alert-dismissible fade show">
            <p class="mb-0 pb-0">'.$ci->session->flashdata('error').'</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
      }       
   }