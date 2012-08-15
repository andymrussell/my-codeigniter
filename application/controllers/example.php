<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends MY_Controller {


	public function index()
	{	
		// $post = new Post();
		// $post->title = '';
		// $post->body = 'body!';

		// if($post->save())
		// {
		// 	echo 'SAVE!';
		// }
		// else
		// {
		// 	$this->data['validation_errors'] = $post->errors->full_messages();
		// }


		//Eager load extra data!
		$data = Post::find('all', array('include' => array('user') ));
		$this->data['title'] = 'testing';
		$this->data['presenter'] = $this->load->presenter('Example_Presenter', $data);
		// $this->data['data'] = $data;

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */