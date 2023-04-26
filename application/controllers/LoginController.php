<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LoginController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('CommonModel','cm');

	}
	public function index(){
		$this->load->view('admin/index');
	}

	public function  userRegister(){
		$this->load->view('admin/register');	
	}

	public function saveUser(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    	$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');


    	if($this->form_validation->run() == TRUE){

			$data['title']              = 'Checkout payment | HBS';  
        	$data['callback_url']       = base_url().'razorpay/callback';
        	$data['surl']               = base_url().'razorpay/success';
        	$data['furl']               = base_url().'razorpay/failed';
        	$data['currency_code']      = 'INR';
        	$data['mobile']      		= $_POST['mobile'];
        	$data['email']      		= $_POST['email'];
        	$data['uname']      		= $_POST['firstname'];

        	$this->session->set_userdata('postData',$_POST);

        	$this->load->view('checkout',$data);	

		} else {

			$this->userRegister();
		}

	}

	public function userLogin(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');


    	if($this->form_validation->run() == TRUE){
			
			$userCodn = ['email' => $_POST['email'], 'password' => hash('sha256', $_POST['password']), 'status' => 1,'order_id!='=>'','payment_id!='=>''];
			$userColmn = ['id','firstname','lastname','email','role','report_date'];
			$user = $this->cm->getRowData($userColmn,$userCodn,'users');

			if(!empty($user)){
				$this->session->set_userdata('user',$user);

				if($user->role == 'admin'){
					return redirect('admin/dashboard');
				} elseif($user->role == 'user') {
				 	return redirect('user/dashboard');
				}
			} else {
				$this->session->set_flashdata('error','Invalid Email or Password !!');
				return redirect('/');
			}

		} else {

			$this->index();
		}

	}


	public function logout(){
		$this->session->sess_destroy();
    	return redirect(base_url());
	}

	// initialized cURL Request
    private function curl_handler($payment_id, $amount)  {
        $url            = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id         = "rzp_test_3Hy6varBFoCJYb";
        $key_secret     = "Fi3DJBMWqmHvg8Dk2bo0WX8C";
        $fields_string  = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }   
        
    // callback method
    public function callback() {   
        print_r($this->input->post());     
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            
            $this->session->set_flashdata('razorpay_payment_id', $this->input->post('razorpay_payment_id'));
            $this->session->set_flashdata('merchant_order_id', $this->input->post('merchant_order_id'));
            $currency_code = 'INR';
            $amount = 20000;
            $success = false;
            $error = '';
            try {                
                $ch = $this->curl_handler($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
            }
            
            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                if (!$order_info['order_status_id']) {
                    redirect($this->input->post('merchant_surl_id'));
                } else {
                    redirect($this->input->post('merchant_surl_id'));
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
    public function success() {
        $data['title'] = 'Razorpay Success | HBC';

        $userRow = $this->session->userdata('postData');

        $insertData = array();

		$insertData['firstname'] = !empty($userRow['firstname']) ? $userRow['firstname'] : '';
		$insertData['lastname'] = !empty($userRow['lastname']) ? $userRow['lastname'] : '';
		$insertData['email'] = !empty($userRow['email']) ? $userRow['email'] : '';
		$insertData['password'] = !empty($userRow['password']) ? hash('sha256',$userRow['password']) : '';
		$insertData['role'] = 'user';
		$insertData['mobile'] = !empty($userRow['mobile']) ? $userRow['mobile'] : '';
		$insertData['order_id'] = $this->session->flashdata('merchant_order_id');
		$insertData['payment_id'] = $this->session->flashdata('razorpay_payment_id');

		if($this->cm->insertData('users',$insertData))
		{
			$this->load->library('email');
			$message = "<h4>Your transaction is Successfull</h4>";  
	        $message .="<br/>";
	        $message .= "Transaction ID: ".$this->session->flashdata('razorpay_payment_id');
	        $message .= "<br/>";
	        $message .= "Order ID: ".$this->session->flashdata('merchant_order_id');
	        $message .= "<h4>Thanks,<br>HBC</h4><br>";
	        $message .= "<img style='height: 60px;' src = '".base_url('assets/img/logo-2.png')."' >";
		    $this->email->from('websitebyranking@gmail.com', 'HBC');
		    $this->email->to($insertData['email']);
		    $this->email->cc('anupmishra509@gmail.com');
		    $this->email->subject('HBC Registration Sussessfully');
		    $this->email->message($message);
		    $this->email->set_mailtype("html");
		    $this->email->send();
			$this->session->set_flashdata('success', 'Registered Sussessfully !!');
			return redirect('/');
		} else {

			$this->session->set_flashdata('error','Registration Failed !!');
			return redirect('user/register');
		}
    }  
    public function failed() {
        $data['title'] = 'Razorpay Failed | HBC';
        $this->session->sess_destroy();  
        $this->session->set_flashdata('error','Registration Failed !!');
		return redirect('user/register');
    }

    /*------ Forgot Password -----------*/
    public function forgotPassword() {
    	$this->load->view('admin/forgot-password');
    }

    public function verifyUser() {
    	$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    	$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
    	if($this->form_validation->run() == TRUE){
    		$colmn = ['id','email','forgot_pass_token'];
    		$cond = ['email'=>$this->input->post('email')];
    		$emailData = $this->cm->getRowData($colmn,$cond,'users');
    		if(!empty($emailData->email)){
    			$token = bin2hex(openssl_random_pseudo_bytes(10));
    			$this->load->library('email');
				$message = "<h4>Forgot Password Link</h4>";  
		        $message .="<br/>";
		        $message .= "<a href='".base_url('user/reset-password/'.$token)."'>Click here to reset password</a>";
		        $message .= "<br/>";
		        $message .= "<h4>Thanks,<br>HBC</h4><br>";
		        $message .= "<img style='height: 60px;' src = '".base_url('assets/img/logo-2.png')."' >";
			    $this->email->from('websitebyranking@gmail.com', 'HBC');
			    $this->email->to($this->input->post('email'));
			    $this->email->cc('anupmishra509@gmail.com');
			    $this->email->subject('HBC Reset Password');
			    $this->email->message($message);
			    $this->email->set_mailtype("html");
			    if($this->email->send()){
			    	$updateData = ['forgot_pass_token' => $token,'forgot_pass_token_time'=>date("H:i")];
			    	$this->cm->updateData($cond,'users',$updateData);
			    	$this->session->set_flashdata('success','Reset password link sent to your mail !!');
					return redirect('user/for-got-password');
			    }
    		} else {
    			$this->session->set_flashdata('error','Email Address Does Not Exists !!');
				return redirect('user/for-got-password');
    		}
    	} else {
    		$this->forgotPassword();
    	}
    }

    public function resetPassword($token){
    	$colmn = ['id','email','forgot_pass_token','forgot_pass_token_time'];
    	$cond = ['forgot_pass_token'=>$token];
    	$emailData = $this->cm->getRowData($colmn,$cond,'users');
    	if(!empty($emailData)){
    		$startTime = date("H:i", strtotime($emailData->forgot_pass_token_time));
    		$endTime = date("H:i");
    		if((strtotime($endTime)-strtotime($startTime)) <= 1800) {
    			$this->load->view('admin/create-new-password', compact('emailData'));
    		} else {
    			$this->session->set_flashdata('error','Your link is not valid or link is expire !!');
				return redirect('user/for-got-password');	
    		}
    	} else {
    		$this->session->set_flashdata('error','Your link is not valid or link is expire !!');
			return redirect('user/for-got-password');
    	}
    }

    public function changePassword() {
    	$colmn = ['id','email','forgot_pass_token','forgot_pass_token_time'];
    	$cond = ['forgot_pass_token'=>$_POST['token'],'id'=>$_POST['userId']];
    	$emailData = $this->cm->getRowData($colmn,$cond,'users');
    	if(!empty($emailData)){
    		$startTime = date("H:i", strtotime($emailData->forgot_pass_token_time));
    		$endTime = date("H:i");
    		if((strtotime($endTime)-strtotime($startTime)) <= 1800) {
    			$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
    			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
    			if($this->form_validation->run() == TRUE){
    				$passData = [
    					'password' => hash('sha256',$_POST['password']),
    					'forgot_pass_token' => '',
    					'forgot_pass_token_time'=>''
    				];
    				$this->cm->updateData($cond,'users',$passData);
    				$this->session->set_flashdata('success','Your password has been changed !!');
					return redirect(base_url());
    			} else {
    				$this->resetPassword($_POST['token']);
    			}
    			
    		} else {
    			$this->session->set_flashdata('error','Your link is not valid or link is expire !!');
				return redirect('user/for-got-password');	
    		}
    	} else {
    		$this->session->set_flashdata('error','Your link is not valid or link is expire !!');
			return redirect('user/for-got-password');
    	}
    }

}

/* End of file LoginController.php */
/* Location: ./application/controllers/LoginController.php */
?>