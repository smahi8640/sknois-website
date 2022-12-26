<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class User extends BaseController
{
	/**
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * Configuration
	 *
	 * @var \IonAuth\Config\IonAuth
	 */
	protected $configIonAuth;

	/**
	 * IonAuth library
	 *
	 * @var \IonAuth\Libraries\IonAuth
	 */
	protected $ionAuth;

	/**
	 * Session
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Validation library
	 *
	 * @var \CodeIgniter\Validation\Validation
	 */
	protected $validation;

	/**
	 * Validation list template.
	 *
	 * @var string
	 * @see https://bcit-ci.github.io/CodeIgniter4/libraries/validation.html#configuration
	 */
	protected $validationListTemplate = 'list';

	/**
	 * Views folder
	 * Set it to 'auth' if your views files are in the standard application/Views/auth
	 *
	 * @var string
	 */
	//protected $viewsFolder = 'admin';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{

		$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
		$this->validation = \Config\Services::validation();
		helper(['form', 'url']);
		$this->configIonAuth = config('IonAuth');
		$this->session       = \Config\Services::session();

		if (! empty($this->configIonAuth->templates['errors']['list']))
		{
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}

	}
	
	
	public function index()
	{
		$data['title'] = 'Login';
		if($this->input->post())
		{
			//here we will verify the inputs;
		}
		//$this->load->helper('form');
	  return view('admin/login',$data);
	}
	
	public function login()
	{
		$data['title'] = 'Login';
		return view('admin/pages/login',$data);
	}
	
	
	
	public function log()
	{
	    $session = session();
	    if($this->request->getMethod() === 'post')
		{
		    $this->validation->setRule('email', str_replace(':', '', lang('Auth.login_identity_label')), 'required');
		    $this->validation->setRule('password', str_replace(':', '', lang('Auth.login_password_label')), 'required');
			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		    {
			    $remember = (bool)$this->request->getVar('remember');
			    if ($this->ionAuth->login($this->request->getVar('email'), $this->request->getVar('password'), $remember))
			    {
				    //$session->set($query);
				    
				    echo json_encode(array('status'=>1,'message'=>'Success'));
				    exit(0);
					//redirect('admin', 'refresh');
				}
				else
				{
					echo json_encode(array('status'=>0,'message'=>$this->ionAuth->errors($this->validationListTemplate)));
					exit(0);
				}
			}else{
			    echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
			    exit(0);
			     
			}
		}
	}
	
	public function logout()
	{
		
		$this->ionAuth->logout();
		return redirect()->to('admin');
	}
	
	public function profile()
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect('admin');
		}
		$this->data['page_title'] = 'User Profile';
		$user = $this->ion_auth->user()->row();
		$this->data['current_user'] = $user;
		$this->data['user'] = $user;
		$this->data['current_user_menu'] = '';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','trim|required');
		$this->form_validation->set_rules('last_name','Last name','trim|required');
		//$this->form_validation->set_rules('company','Company','trim');
		$this->form_validation->set_rules('phone','Phone','trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		$this->form_validation->set_rules('country_code','Country_code','trim|required');
		//$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','Password','min_length[6]');
		$this->form_validation->set_rules('password_confirm','Password confirmation','matches[password]');
		//$this->form_validation->set_rules('groups[]','Groups','required|integer');
		
		if($this->form_validation->run()===FALSE)
		{
			$this->data['groups'] = $this->ion_auth->groups()->result();
			$this->data['usergroups'] = array();
			if($usergroups = $this->ion_auth->get_users_groups($user->id)->result())
			{
				foreach($usergroups as $group)
				{
					$this->data['usergroups'][] = $group->id;
				}
			}
			
			$this->render('admin/user/profile_view','admin_master');
		}
		else
		{
			$new_data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
				'photo' => $this->input->post('photo'),
				'country' => $this->input->post('country'),
				'country_code' => $this->input->post('country_code')
			);
			if(strlen($this->input->post('password'))>=6) $new_data['password'] = $this->input->post('password');
			$this->ion_auth->update($user->id, $new_data);
			
			//Update the groups user belongs to
			$groups = $this->input->post('groups');
			if (isset($groups) && !empty($groups))
			{
				$this->ion_auth->remove_from_group('', $user->id);
				foreach ($groups as $group)
				{
					$this->ion_auth->add_to_group($group, $user->id);
				}
			}
			
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('admin/user/profile','refresh');
		}
	}
}