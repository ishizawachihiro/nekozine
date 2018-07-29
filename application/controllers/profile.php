<?php
/*
 * profile.php ユーザープロフィルコントローラー
 *
 * 2012/04/22 Chihiro: 作成
 */
class Profile extends CI_Controller{
	
  private $connection;

  public function __construct(){
    parent::__construct();

		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret')){
			// If user already logged in
			$this->connection = $this->twitteroauth->create(
			  $this->config->item('twitter_consumer_token'),
			  $this->config->item('twitter_consumer_secret'),
			  $this->session->userdata('access_token'), 
			  $this->session->userdata('access_token_secret')
			);
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret')){
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create(
			  $this->config->item('twitter_consumer_token'), 
			  $this->config->item('twitter_consumer_secret'),
			  $this->session->userdata('request_token'),
			  $this->session->userdata('request_token_secret')
			);
		}
		else{
			// Unknown user
			$this->connection = $this->twitteroauth->create(
			  $this->config->item('twitter_consumer_token'),
			  $this->config->item('twitter_consumer_secret')
			);
		}


  }
  
  public function login($type = null){
    if($type == "twitter"){

		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret')){
			// User is already authenticated. Add your user notification code here.
			$user = $this->session->userdata('logged_in_user');
			redirect('/user/' . $user);
		}
		else{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(site_url('profile/oauth_cb'));
			
			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200){
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else{
				// An error occured. Make sure to put your error notification code here.
				redirect(base_url('/'));
			}
		}
	}
	else{
		$data = array();
		$data['title']  = "ログイン";
		$data['view']   = "profile/login";
      
		$this->load->view("templates/simple", $data);
	}
  }
  
  public function logout($type = null){
    if($type == "twitter"){
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('access_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
		$this->session->unset_userdata('logged_in_user');
	}

	$data = array();
    $data['title']  = "ログアウト";
    $data['view']   = "profile/logout";
      
    $this->load->view('templates/simple', $data);
  }
  
  // Twitter 専用
  public function oauth_cb(){
	if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token')){
		$this->reset_session();
		redirect(base_url('/profile/login'));
	}
	else{
		$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
		$user = $this->connection->get('https://api.twitter.com/1.1/users/show.json',array("screen_name"=>$access_token['screen_name'],"user_id"=>$access_token['user_id']));

		if ($this->connection->http_code == 200){
			$this->session->set_userdata('access_token', $access_token['oauth_token']);
			$this->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
			$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
			$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
			$this->session->set_userdata('logged_in_user', $access_token['screen_name']);
			$this->session->unset_userdata('request_token');
			$this->session->unset_userdata('request_token_secret');

			$_user  = User::get($access_token['screen_name']);
			if(!$_user){
				$data = array();
				$data['username']  = $access_token['screen_name'];
				$data['imageurl']  = $user->profile_image_url;
				$this->db->insert('users', $data);
    		}
			redirect('/user/' . $access_token['screen_name']);				
		}
		else{
			// An error occured. Add your notification code here.
			redirect(base_url('/'));
		}
	}
 }
  
 private function reset_session(){
	$this->session->unset_userdata('access_token');
	$this->session->unset_userdata('access_token_secret');
	$this->session->unset_userdata('request_token');
	$this->session->unset_userdata('request_token_secret');
	$this->session->unset_userdata('twitter_user_id');
	$this->session->unset_userdata('twitter_screen_name');
}
	
  // Updates the user profile information
  public function update(){
    $user   = User::get($this->input->post('username'));
    $notice = "Error: Unable to upload the image";
    
    if($user){
      $fileinfo = $_FILES['profilepic'];
      
      if($user->updateProfileImage($fileinfo))
        $notice = "Success: Uploaded the profile image";
    }
    
    redirect("/user/" . $this->input->post('username'));
  }
  
  // Uploads a post with an attached media
  public function newpost(){
    $user = $this->session->userdata('logged_in_user');
    
    if($user){
      $this->form_validation->set_rules('status', 'Status', 'trim|required|max_length[100]|xss_clean');
      $this->form_validation->set_rules('media', 'Photo', 'callback_imagefile_check');
      
      $this->form_validation->set_message('status', 'ステータスが必要');
      $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
      
      if($this->form_validation->run() === FALSE){
        $data = array();
        $data['title']    = "";
        $data['view']     = "parts/newpost";
        $data['username'] = $user;
        
        $this->load->view('templates/layout', $data);
      }
      else{
        // Upload to twitter
        $image  = "@{$_FILES['media']['tmp_name']};type={$_FILES['media']['type']};filename={$_FILES['media']['name']}";
        
        $data   = array(
          'media[]' => $image,
          'status'  => $this->input->post('status') . " via @nekozine"
        );

		$response = $this->connection->oAuthRequestImage('statuses/update_with_media', 'POST',$data);

        // Process the result
        if($response){
			$json = json_decode($response);
	        $result = Post::insertNewTweet($json);
        }
        
        redirect('/user/' . $user );
      }
    }
    else{
      show_404();
    }
  }
  
  // Custom check on the file set by the user
  function imagefile_check(){
    $valid_mimes  = array("image/jpeg", "image/jpg", "image/png", "image/gif");
    $size_limit   = 3145728;
    $valid        = true;
    
    if(!$_FILES['media']){
      $this->form_validation->set_message('imagefile_check', '写真を選択してください');
      $valid = false;
    }
    else{
      if(!in_array($_FILES['media']['type'], $valid_mimes)){  
        $this->form_validation->set_message('imagefile_check', 'JPEG/PNG/GIFのみを選択してください');
        $valid = false;
      }
    
      if($_FILES['media']['size'] > $size_limit){  
        $this->form_validation->set_message('imagefile_check', '3MB 以下の写真を選択してください');
        $valid = false;
      }
    }
    
    return $valid;
  }
}
?>
