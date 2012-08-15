<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {


	public function index()
	{	
		// $data = Post::all();

		$data = Post::find('all', array('include' => array('user') ));
			
		//Post::find('all', array('limit' => 10, 'include' => array('author')));
		foreach($data as $item)
		{
			echo $item->title;
			echo '<br/>';
			echo $item->body;
			echo '<br/>';
			echo $item->user->name;
			echo '<hr/>';

		}

		exit();

		$this->data['title'] = 'testing';
		$data->{'names'} = 'testing';
		$this->data['temp'] = $this->load->presenter('Welcome_Presenter',$data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */