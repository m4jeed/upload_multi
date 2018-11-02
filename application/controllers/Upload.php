<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('M_upload','load');
	}

	public function index()
	{
		$this->load->view('v_upload');
	}

	function proses_upload(){
		$config['upload_path'] =FCPATH.'/upload-foto/';
		$config['allowed_types']='gif|jpeg|png|ico|jpg';
		$this->load->library('upload',$config);

		if ($this->upload->do_upload('userfile')) {
			$token=$this->input->post('token_foto');
			$name =$this->upload->data('file_name');
			$this->db->insert('foto', array('nama_foto'=>$name, 'token'=>$token));
		}
	}

	//Untuk menghapus foto
	function remove_foto(){

		//Ambil token foto
		$token=$this->input->post('token');
		$foto=$this->db->get_where('foto',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('foto',array('token'=>$token));
		}

		echo "{}";
	}

}