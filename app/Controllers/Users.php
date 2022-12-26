<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;

class Users extends BaseController
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
        $this->db      = \Config\Database::connect();

		if (! empty($this->configIonAuth->templates['errors']['list']))
		{
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}

	}
	
	
	public function registeradd(){

		$this->data['title'] = lang('Auth.create_user_heading');

		$this->data['meta_title'] = lang('Auth.create_user_heading');
		$this->data['meta_description'] = 'Writeway';
		$this->data['meta_keyword'] = 'Writeway';


		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;

		// validate form input
		$this->validation->setRule('first_name', lang('Auth.create_user_validation_fname_label'), 'trim|required');
		$this->validation->setRule('last_name', lang('Auth.create_user_validation_lname_label'), 'trim|required');
		if ($identityColumn !== 'email')
		{
			$this->validation->setRule('identity', lang('Auth.create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identityColumn . ']');
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->validation->setRule('phone', lang('Auth.create_user_validation_phone_label'), 'trim|required|max_length[10]');
		$this->validation->setRule('company', lang('Auth.create_user_validation_company_label'), 'trim');
		$this->validation->setRule('password', lang('Auth.create_user_validation_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[password_confirm]');
		$this->validation->setRule('password_confirm', lang('Auth.create_user_validation_password_confirm_label'), 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
			$email    = strtolower($this->request->getPost('email'));
			$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
			$password = $this->request->getPost('password');

			$additionalData = [
				'first_name' => $this->request->getPost('first_name'),
				'last_name'  => $this->request->getPost('last_name'),
				'company'    => $this->request->getPost('company'),
				'phone'      => $this->request->getPost('phone'),
			];
		}
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{

			$id = $this->ionAuth->register($identity, $password, $email, $additionalData, array('3'));
			
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->setFlashdata('message', $this->ionAuth->messages());

			$redirect_url = site_url('register');
			//$currentpage = session()->get('currentpage');


			return redirect()->to($redirect_url);
		}
		else
		{
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));
			return view('frontend/pages/users/merchant', $this->data);
		}
	}


	/**
	 * Log the user in
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function login()
	{
		if ($this->ionAuth->loggedIn())
		{
			// redirect them to the login page
			return redirect()->to('users/profile');
		}

		$this->data['title'] = lang('Auth.login_heading');

		$this->data['meta_title'] = lang('Auth.login_heading');
		$this->data['meta_description'] = 'Writeway';
		$this->data['meta_keyword'] = 'Writeway';

		// validate form input
		$this->validation->setRule('identity', str_replace(':', '', lang('Auth.login_identity_label')), 'required');
		$this->validation->setRule('password', str_replace(':', '', lang('Auth.login_password_label')), 'required');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->request->getVar('remember');
			
			if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'), $remember))
			{

				$user = $this->ionAuth->user()->row();
				$ci_session = get_cookie('ci_session');
				$record['user_id'] = $user->id;

				
				$this->db->table('cart')->where('session_id',$ci_session)->update($record);

				$cart_records = $this->db->query("select * from cart where user_id='".$user->id."'")->getResultArray();

				



				$return_url = $this->request->getVar('return_url'); 
				if($return_url != '') {
					$return_url = base64_decode($return_url);
				} else {
					$return_url = site_url();
				}

                echo json_encode(array('message_type'=>'success','message'=>'Login Successfully','url'=>$return_url));
				//return redirect()->to($return_url)->withCookies();
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				//$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				echo json_encode(array('message_type'=>'failure','message'=>strip_tags($this->ionAuth->errors($this->validationListTemplate))));
				// use redirects instead of loading views for compatibility with MY_Controller libraries
				//return redirect()->back()->withInput();
			}
		}
		else
		{
			
			return view('frontend/pages/user/login', $this->data);
		}
	}


	/**
	 * Log the user out
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function logout()
	{
		$this->data['title'] = 'Logout';

		// log the user out
		$this->ionAuth->logout();

		// redirect them to the login page
		$this->session->setFlashdata('message', $this->ionAuth->messages());
		return redirect()->to('users/login')->withCookies();
	}


	/**
	 * Create a new user
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function register()
	{
		$this->data['title'] = lang('Auth.create_user_heading');

		
		/*if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}*/

		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;

		// validate form input
		$this->validation->setRule('first_name', lang('Auth.create_user_validation_fname_label'), 'trim|required');
		$this->validation->setRule('last_name', lang('Auth.create_user_validation_lname_label'), 'trim|required');
	
	

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
		     
			$email    = strtolower($this->request->getPost('email'));
			$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
			$password = $this->request->getPost('password');
            $remember = (bool)$this->request->getVar('remember');
			$additionalData = [
				'first_name' => $this->request->getPost('first_name'),
				'last_name'  => $this->request->getPost('last_name'),
				//'company'    => $this->request->getPost('company'),
				'phone'      => $this->request->getPost('phone'),
			];
			
				$this->validation->setRule('phone', lang('Auth.create_user_validation_phone_label'), 'trim|required|max_length[10]|is_unique[' . $tables['users'] . '.phone]|integer');
        		if ($identityColumn !== 'email')
        		{
        			$this->validation->setRule('identity', lang('Auth.create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identityColumn . ']');
        			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
        		}
        		else
        		{
        			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        		}
		
				if ($this->request->getPost() && $this->validation->withRequest($this->request)->run() && $this->ionAuth->register($identity, $password, $email, $additionalData))
        		{
        		    $this->ionAuth->login($email,$password, $remember);
        			// check to see if we are creating the user
        			// redirect them back to the admin page
        			$return_url = $this->request->getVar('return_url'); 
        				if($return_url != '') {
        					$return_url = base64_decode($return_url);
        				} else {
        					$return_url = site_url();
        				}
        
                        echo json_encode(array('message_type'=>'success','message'=>'Register Successfully','url'=>$return_url));
        		}
        		else
        		{
        		    echo json_encode(array('message_type'=>'error','message'=>$this->validation->getErrors() ? strip_tags($this->validation->listErrors($this->validationListTemplate)) : ($this->ionAuth->errors($this->validationListTemplate) ? strip_tags($this->ionAuth->errors($this->validationListTemplate)) : "")));
        			
        		}
		}else{
		    
		return view('frontend/pages/user/register', $this->data);
		}
	
		
	}


	/**
	 * Redirect a user checking if is admin
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function redirectUser()
	{
		if ($this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}
		return redirect()->to('/');
	}


	/**
	 * Edit a user
	 *
	 * @param integer $id User id
	 *
	 * @return string string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function profile()
	{
		
		

		if (! $this->ionAuth->loggedIn() )
		{
			return redirect()->to('users/login');
		}
        
        $user = $this->ionAuth->user()->row();
		$id = $user->id;

		$user          = $this->ionAuth->user($id)->row();
		$groups        = $this->ionAuth->groups()->resultArray();
		$currentGroups = $this->ionAuth->getUsersGroups($id)->getResult();

		if (! empty($_POST))
		{
			// validate form input
			$this->validation->setRule('first_name', lang('Auth.edit_user_validation_fname_label'), 'trim|required');
			$this->validation->setRule('last_name', lang('Auth.edit_user_validation_lname_label'), 'trim|required');
			$this->validation->setRule('phone', lang('Auth.edit_user_validation_phone_label'), 'trim|required');

           if ($this->request->getPost() )
			{
			    
				$data = [
					'first_name' => $this->request->getPost('first_name'),
					'last_name'  => $this->request->getPost('last_name'),
					'phone'      => $this->request->getPost('phone'),
					'customer_country'      => $this->request->getPost('customer_country'),
					'customer_city'      => $this->request->getPost('customer_city'),
					'customer_state'      => $this->request->getPost('customer_state'),
					'customer_address'      => $this->request->getPost('customer_address'),
					'customer_pincode'      => $this->request->getPost('customer_pincode'),
				];

				// update the password if it was posted
				if ($this->request->getPost('password'))
				{
					$data['password'] = $this->request->getPost('password');
				}

				// Only allow updating groups if user is admin
				// check to see if we are updating the user
				if ($this->ionAuth->update($user->id, $data))
				{
				    
					$this->session->setFlashdata('message', $this->ionAuth->messages());
				}
				else
				{
					$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				}
				// redirect them back to the admin page if admin, or to the base url if non admin
				return redirect()->to('users/profile');
			}
		}

		// display the edit user form

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;

	
		return view('frontend/pages/user/profile', $this->data);
	}
	
	public function myorders()
	{
		

	

		if (! $this->ionAuth->loggedIn())
		{
			return redirect()->to('/login');
		}
        $user = $this->ionAuth->user()->row();
		$id = $user->id;
		$user          = $this->ionAuth->user($id)->row();

	    $this->data['orders'] = $this->db->query("select * from orders where user_id='".$id."' order by created_date desc, id desc")->getResult();
	    $this->data['user'] = $user;
		

		//return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
		return view('frontend/pages/order_history', $this->data);
	}


	/**
	 * Change password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function change_password()
	{
		if (! $this->ionAuth->loggedIn())
		{
			return redirect()->to('/auth/login');
		}
		
		$this->validation->setRule('old', lang('Auth.change_password_validation_old_password_label'), 'required');
		$this->validation->setRule('new', lang('Auth.change_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
		$this->validation->setRule('new_confirm', lang('Auth.change_password_validation_new_password_confirm_label'), 'required');

		$user = $this->ionAuth->user()->row();

		$this->data['meta_title'] = 'Change Password';
		$this->data['meta_description'] = 'Writeway';
		$this->data['meta_keyword'] = 'Writeway';

		if (! $this->request->getPost() || $this->validation->withRequest($this->request)->run() === false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = ($this->validation->getErrors()) ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

			$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
			$this->data['old_password'] = [
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			];

			// render
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		}
		else
		{
			$identity = $this->session->get('identity');

			$change = $this->ionAuth->changePassword($identity, $this->request->getPost('old'), $this->request->getPost('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return $this->logout();
			}
			else
			{
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/auth/change_password');
			}
		}
	}


	/**
	 * Forgot password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function forgot_password()
	{
		$this->data['title'] = lang('Auth.forgot_password_heading');

		$this->data['meta_title'] = lang('Auth.forgot_password_heading');
		$this->data['meta_description'] = 'Writeway';
		$this->data['meta_keyword'] = 'Writeway';

		// setting validation rules by checking whether identity is username or email
		if ($this->configIonAuth->identity !== 'email')
		{
			$this->validation->setRule('identity', lang('Auth.forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->validation->setRule('identity', lang('Auth.forgot_password_validation_email_label'), 'required|valid_email');
		}

		if (! ($this->request->getPost() && $this->validation->withRequest($this->request)->run()))
		{
			$this->data['type'] = $this->configIonAuth->identity;
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id'   => 'identity',
				'class'   => 'form-control',
			];

			if ($this->configIonAuth->identity !== 'email')
			{
				$this->data['identity_label'] = lang('Auth.forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = lang('Auth.forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			//return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
			return view('user/forgot_password', $this->data);

		}
		else
		{
			$identityColumn = $this->configIonAuth->identity;
			$identity = $this->ionAuth->where($identityColumn, $this->request->getPost('identity'))->users()->row();

			if (empty($identity))
			{
				if ($this->configIonAuth->identity !== 'email')
				{
					$this->ionAuth->setError('Auth.forgot_password_identity_not_found');
				}
				else
				{
					$this->ionAuth->setError('Auth.forgot_password_email_not_found');
				}

				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/forgot_password');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ionAuth->forgottenPassword($identity->{$this->configIonAuth->identity});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/login'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/forgot_password');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function reset_password($code = null)
	{
		if (! $code)
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$this->data['title'] = lang('Auth.reset_password_heading');

		$this->data['meta_title'] = lang('Auth.reset_password_heading');
		$this->data['meta_description'] = 'Writeway';
		$this->data['meta_keyword'] = 'Writeway';

		$user = $this->ionAuth->forgottenPasswordCheck($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->validation->setRule('new', lang('Auth.reset_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
			$this->validation->setRule('new_confirm', lang('Auth.reset_password_validation_new_password_confirm_label'), 'required');

			if (! $this->request->getPost() || $this->validation->withRequest($this->request)->run() === false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

				$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
				$this->data['new_password'] = [
					'name'    => 'new',
					'id'      => 'new',
					'type'    => 'password',
					'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
					'class'   => 'form-control',
				];
				$this->data['new_password_confirm'] = [
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
					'class'   => 'form-control',
				];
				$this->data['user_id'] = [
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				];
				$this->data['code'] = $code;

				// render
				//return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
				return view('user/reset_password', $this->data);

			}
			else
			{
				$identity = $user->{$this->configIonAuth->identity};

				// do we have a valid request?
				if ($user->id != $this->request->getPost('user_id'))
				{
					// something fishy might be up
					$this->ionAuth->clearForgottenPasswordCode($identity);

					throw new \Exception(lang('Auth.error_security'));
				}
				else
				{
					// finally change the password
					$change = $this->ionAuth->resetPassword($identity, $this->request->getPost('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->setFlashdata('message', $this->ionAuth->messages());
						return redirect()->to('login');
					}
					else
					{
						$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
						return redirect()->to('reset_password/' . $code);
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('forgot_password');
		}
	}

}
