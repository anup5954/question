<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('user')->id) || $this->session->userdata('user')->role !='user'){
			return redirect(base_url());
		}
		$this->load->model('CommonModel','cm');
		$this->load->library('pdf');
	}

	public function index() {
		$quesCond = ['status' => 1];
		$countQues = $this->cm->getNumRow($quesCond,'questions');

		$user_answer_cond = ['userId' => $this->session->userdata('user')->id];

		$countAnswer = $this->cm->getNumRow($user_answer_cond,'user_answers');

		$this->load->view('user/userDashboard', compact('countQues','countAnswer'));	
	}

	public function userQuestion(){

		$user_profile_cond = ['id' => $this->session->userdata('user')->id];
		$colmn = ['id','firstname','lastname','mobile','designation','company_name','num_emp','company_revenue','website','office_address','report_generated'];
		$profileRow = $this->cm->getRowData($colmn,$user_profile_cond,'users');

		if(!empty($profileRow->firstname) && !empty($profileRow->lastname) && !empty($profileRow->mobile) && !empty($profileRow->designation) && !empty($profileRow->company_name) && !empty($profileRow->num_emp) && (isset($profileRow->company_revenue) && $profileRow->company_revenue !== '') && !empty($profileRow->office_address)){


			if($profileRow->report_generated == 1){
				$this->session->set_flashdata('error','You have already completed the task.');
				return redirect('user/dashboard');
			} else {
				
			}

			$catCond = ['status'=>1];
			$catColmn = ['*'];

			$categories = $this->cm->getData($catColmn,$catCond,'','categories');

			if(!empty($categories)){

				foreach($categories as $cat){

					$quesCond = ['cat_id'=> $cat->cat_id];
					$cat->questions = $this->cm->getData($catColmn,$quesCond,'','questions');

					if(!empty($cat->questions)){
						foreach($cat->questions as $ques){
							$optionCond = ['question_id'=>$ques->id];
							$optionColmn = ['*'];
							$answerCond = ['question_id'=>$ques->id,'userId'=>$this->session->userdata('user')->id];
							$ques->answers = $this->cm->getRowData($optionColmn,$answerCond,'user_answers');

							$ques->options = $this->cm->getData($optionColmn,$optionCond,'','options');
							
						}
					}
				}
			}
			//echo "<pre>";print_r($categories);die();
			$this->load->view('user/question-answer', compact('categories'));
		}
		else {
			$this->session->set_flashdata('error','Please Complete Your Profile Firstly.');
			return redirect('user/user-profile');
		}
		
		
	}

	public function saveUserAnswer() {

		//echo "<pre>";print_r($_POST);
		if(isset($_POST['genratePdfData']) && !empty($_POST['genratePdfData']) && $_POST['genratePdfData'] == 'saveFinalData'){

			if(!empty($_POST['question_id']) && isset($_POST['question_id'])) {
				$answerData = array();
				foreach($_POST['question_id'] as $ques ) {
					$answerData['cat_id'] = $_POST['cat_id'];
					$answerData['question_id'] = $ques;
					$answerData['option_id'] = implode(',', $_POST['option_id_'.$ques]);
					$answerData['userId'] = $this->session->userdata('user')->id;
					if(isset($_POST['answer_id_'.$ques]) && !empty($_POST['answer_id_'.$ques])){
						$updateAnsCond = ['id'=>$_POST['answer_id_'.$ques], 'userId' => $this->session->userdata('user')->id ];
						$this->cm->updateData($updateAnsCond,'user_answers',$answerData);
					} else {
						$this->cm->insertData('user_answers',$answerData);
					}
				}

				$path = base_url('assets/img/logo-2.png');
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

				$footer_img = '<img src="'.$base64.'" style="height:20px;">'; 
				$html_content = $this->cm->getPdfData();
				$this->pdf->loadHtml($html_content);
				$this->pdf->render();


				// header

				$canvas = $this->pdf->get_canvas();
				$header = $canvas->open_object();
				$w = $canvas->get_width();
				$h = $canvas->get_height();

				$canvas->page_text($w-590,10,"HBC", $this->pdf->getFontMetrics()->get_font('helvetica','bold'),10,[0,0,0,"alpha" => 0.3]);

				$canvas->page_text($w-180,10,"Business Growth Report", $this->pdf->getFontMetrics()->get_font('helvetica','bold'),10,[0,0,0,"alpha" => 0.3]);



				$canvas->close_object();
				$canvas->add_object($header,"all");

				// footer
				$canvas = $this->pdf->get_canvas();
				$footer = $canvas->open_object();
				$w = $canvas->get_width();
				$h = $canvas->get_height();


				$canvas->page_script('
					$image = "./assets/img/lg.jpg"; 
					$w = $pdf->get_width();
					$h = $pdf->get_height();
					$color = array(0, 0, 0.5);
					$pdf->filled_rectangle(0, $h-60,$w, 80 , $color);
					$pdf->image($image, $w-100,$h-50, 55, 40);
				');

				$canvas->page_text($w-590,$h-28,"Page | {PAGE_NUM}", $this->pdf->getFontMetrics()->get_font('helvetica'),10,[255,255,255]);

				$canvas->close_object();
				$canvas->add_object($footer,"all");


				$output = $this->pdf->output();
				$pdfName = 'report_'.$this->session->userdata('user')->id.'_'.time().'_'.$this->session->userdata('user')->firstname.'.pdf';
				if(file_put_contents("./uploads/".$pdfName, $output)) {

					$pdfData = [
						'report_generated' => 1,
						'report_link' => $pdfName,
						'report_date' => date('d-m-Y')
					];
					
					
					$file1 = $_SERVER["DOCUMENT_ROOT"]."/software/uploads/".$pdfName;
					$this->load->library('email');
					$message = "<h4>Please find the attached analysis report</h4>";  
			        $message .="<br/>";
			        
			        $message .= "<h4>Thanks,<br>HBC</h4><br>";
			        $message .= "<img style='height: 60px;' src = '".base_url('assets/img/logo-2.png')."' >";
				    $this->email->from('websitebyranking@gmail.com', 'HBC');
				    $this->email->to($this->session->userdata('user')->email);
				    $this->email->cc('anupmishra509@gmail.com');
				    $this->email->subject('HBC Analysis Report');
				    $this->email->message($message);
				    $this->email->set_mailtype("html");
				    $this->email->attach($file1);



					$pdfCond = ['id' => $this->session->userdata('user')->id];
					$this->cm->updateData($pdfCond,'users',$pdfData);

					$this->email->send();

					$response = ['msg' => "You have successfully completed",
					'filename' => $pdfName
					];

					echo json_encode($response);
				}

			}
		} else {
			if(!empty($_POST['question_id']) && isset($_POST['question_id'])) {
				$answerData = array();
				foreach($_POST['question_id'] as $ques ) {
					$answerData['cat_id'] = $_POST['cat_id'];
					$answerData['question_id'] = $ques;
					$answerData['option_id'] = implode(',', $_POST['option_id_'.$ques]);
					$answerData['userId'] = $this->session->userdata('user')->id;
					if(isset($_POST['answer_id_'.$ques]) && !empty($_POST['answer_id_'.$ques])){
						$updateAnsCond = ['id'=>$_POST['answer_id_'.$ques], 'userId' => $this->session->userdata('user')->id ];
						$this->cm->updateData($updateAnsCond,'user_answers',$answerData);
					} else {
						$this->cm->insertData('user_answers',$answerData);
					}
				}
			}
		}
		
	}



	public function userProfile() {
		$colmn = ['id','firstname','lastname','mobile','designation','company_name','num_emp','company_revenue','website','office_address'];
		$userCond = ['id'=> $this->session->userdata('user')->id];
		$user = $this->cm->getRowData($colmn,$userCond,'users');
		$this->load->view('user/profile',compact('user'));
	}

	public function password_check($oldpass){
        $colmn = ['id','firstname','lastname','mobile','password'];
		$userCond = ['id'=> $this->session->userdata('user')->id];
		$user = $this->cm->getRowData($colmn,$userCond,'users');

        if($user->password !== hash('sha256',$oldpass)) {
            $this->form_validation->set_message('password_check', 'The current password does not match');
            return false;
        }

        return true;
    }


	public function updateProfile() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    	$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('phonenumber', 'Mobile', 'trim|required|xss_clean');

        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('num_emp', 'No of Employees', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company_revenue', 'Company Revenue', 'trim|required|xss_clean');
        $this->form_validation->set_rules('office_address', 'Office Address', 'trim|required|xss_clean');

        if($this->form_validation->run() == TRUE) {
        	$profileData = [
    			'firstname'	=> $_POST['firstname'],
    			'lastname'	=> $_POST['lastname'],
    			'mobile'	=> $_POST['phonenumber'],
    			'designation'	=> $_POST['designation'],
    			'company_name'	=> $_POST['company_name'],
    			'num_emp'	=> $_POST['num_emp'],
    			'company_revenue'	=> $_POST['company_revenue'],
    			'website'	=> $_POST['website'],
    			'office_address'	=> $_POST['office_address']
    		];
    		$userCond = ['id'=> $this->session->userdata('user')->id];
    		if($this->cm->updateData($userCond,'users',$profileData)){
    			$this->session->userdata('user')->firstname = $_POST['firstname'];
    			$this->session->set_flashdata('success', 'Your profile has been changed!!');
				return redirect('user/user-profile');
    		} else {
    			$this->session->set_flashdata('error','Something Went Wrong !!');
				return redirect('user/user-profile');
    		}
        } else {
        	$this->userProfile();
        }
	}

	public function updatePassword(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('currentpwd', 'Old password', 'trim|required|callback_password_check|xss_clean');
        $this->form_validation->set_rules('newpwd', 'Password', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('confirmpwd', 'Confirm Password', 'required|matches[newpwd]');
    	if($this->form_validation->run() == TRUE) {
    		$passData = [
    			'password'	=> hash('sha256',$_POST['newpwd'])
    		];
    		$userCond = ['id'=> $this->session->userdata('user')->id];
    		if($this->cm->updateData($userCond,'users',$passData)){
    			$this->session->set_flashdata('success', 'Your password has been changed!!');
				return redirect('user/user-profile');
    		} else {
    			$this->session->set_flashdata('error','Something Went Wrong !!');
				return redirect('user/user-profile');
    		}
        } else {
        	$this->userProfile();
        }
	}


	public function showResult(){
		$catCond = ['status'=>1];
		$catColmn = ['*'];

		$categories = $this->cm->getData($catColmn,$catCond,'','categories');

		if(!empty($categories)){

			foreach($categories as $cat){

				$quesCond = ['cat_id'=> $cat->cat_id];
				$cat->questions = $this->cm->getData($catColmn,$quesCond,'','questions');

				if(!empty($cat->questions)){
					foreach($cat->questions as $ques){
						$optionCond = ['question_id'=>$ques->id];
						$optionColmn = ['*'];
						$answerCond = ['question_id'=>$ques->id,'userId'=>$this->session->userdata('user')->id];
						$ques->answers = $this->cm->getRowData($optionColmn,$answerCond,'user_answers');

						$ques->options = $this->cm->getData($optionColmn,$optionCond,'','options');
						
					}
				}
			}
		}
		$this->load->view('user/result', compact('categories'));
	}

}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */
?>