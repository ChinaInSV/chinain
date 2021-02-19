<?php
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view('login/login_view');
	}
	function lock(){		
		$session = $this->session->userdata('userInfo');
		$data = array(
			'id_session'	=> $session['id_session'],
			'username'		=> $session['username'],
			'userid'		=> $session['userid'],
			'hostdir'		=> $session['hostdir'],
			'is_logged_in' 	=> 1,
			'permisos'		=> $session['permisos']
		 );
		$this->session->set_userdata('userInfo', $data);
		
		$user=$this->Generic_model->get('q','usuarios','*',array('id_usuario'=>$session['userid']));
		$dataUser["user"]=$user[0];
		
		$this->load->view('login/login_lock_view',$dataUser);
	}
	function check(){
		$user=$this->Generic_model->get('q','usuarios','*',array('username_usuario'=>$this->input->post('username'),'password_usuario'=>sha1($this->input->post('password'))));
		if(count($user)>0){
			if($user[0]->activo_usuario==0){
				echo 'inactivo';	
			}else{
				echo 'true';				
			}
		}else{
			echo 'false';
		}
	}
	function logon(){
		$user=$this->Generic_model->get('q','usuarios','*',array('username_usuario'=>$this->input->post('username'),'password_usuario'=>sha1($this->input->post('password'))));
		if(count($user)>0){
			$idUser=$user[0]->id_usuario;
			$nombre=$user[0]->nombre_usuario;
			$permisos=unserialize($user[0]->permisos_usuario);
			/* $dirIp = "192.168.1.100";$_SERVER['REMOTE_ADDR']; */
			$dirIp = $_SERVER['REMOTE_ADDR'];
			$session_id = substr(md5(uniqid(rand())),0,32);
			$data = array(
				'id_session'=> $session_id,
				'username'=> $this->input->post('username'),
				'userid'		=> $idUser,
				'nameuser'		=> $nombre,
				'hostdir'		=> $dirIp,
				'is_logged_in' 	=> 0,
				'permisos'		=> $permisos
			 );
			$this->session->set_userdata('userInfo', $data);
			$this->Generic_model->update('usuarios',array('conectado_usuario'=>1),array('id_usuario'=>$idUser));
			redirect(base_url("home")); 
		}else{
			redirect(base_url("login"));
		}
	}
	function logout(){
		$session = $this->session->userdata('userInfo');
		$this->Generic_model->update('usuarios',array('conectado_usuario'=>0),array('id_usuario'=>$session['userid']));
		$this->session->unset_userdata('userInfo');
		$this->session->sess_destroy();
		
		redirect(base_url("login"));
	}
	function sessiondestroy(){
		$this->session->unset_userdata('userInfo');
		$this->session->sess_destroy();
		redirect(base_url("login"));
	}
}
?>