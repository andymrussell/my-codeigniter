<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {


	public function index()
	{	


		$this->data['title'] = 'testing';
		$data->{'names'} = 'testing';
		$this->data['temp'] = $this->load->presenter('Welcome_Presenter',$data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */