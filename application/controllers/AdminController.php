<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class AdminController extends CI_Controller {



	public function __construct(){

		parent::__construct();





		if(empty($this->session->userdata('user')->id) || $this->session->userdata('user')->role !='admin'){

			return redirect(base_url());

		}

		$this->load->model('CommonModel','cm');

	}



	public function index(){

		$userCodn = ['status' => 1, 'role' => 'user'];

		$userColmn = ['id','firstname','lastname','email','role','mobile','report_generated','report_link'];

		$orderby = 'created_at DESC';

		$users = $this->cm->getData($userColmn,$userCodn,$orderby,'users');

		$quesCond = ['status' => 1];

		$countQues = $this->cm->getNumRow($quesCond,'questions');

		$userSubmitCodn = ['status' => 1, 'report_generated' => 1];

		$countUserSubmit = $this->cm->getNumRow($userSubmitCodn,'users');

		$catCond = ['status' => 1];

		$countCat = $this->cm->getNumRow($catCond,'categories');

		$this->load->view('admin/dashboard',compact('users','countQues','countUserSubmit','countCat'));	

	}





	public function listCategory(){

		$catCodn = ['status' => 1];

		$catColmn = ['cat_id','cat_name','cat_description','cat_image'];

		$categories = $this->cm->getData($catColmn,$catCodn,'','categories');

		$this->load->view('admin/category',compact('categories'));	

	}



	public function createCategory(){

		$filename = "";

		if(!empty($_FILES['cat_image']['name']) && isset($_FILES['cat_image']['name'])){

			$ext = strtolower(pathinfo($_FILES['cat_image']['name'], PATHINFO_EXTENSION));

			$tempname = $_FILES["cat_image"]["tmp_name"];

			$filename = "Category_".time().".".$ext;

			move_uploaded_file($tempname,"./uploads/".$filename);

		}

		$insertData = [

			'cat_name' 			=> !empty($_POST['cat_name']) ? $_POST['cat_name'] : '',

			'cat_description' 	=> !empty($_POST['cat_description']) ? $_POST['cat_description'] : '',

			'cat_image'			=> $filename

		];

		if($this->cm->insertData('categories',$insertData)) {

			$this->session->set_flashdata('success', 'Category Added !!');

			return redirect('admin/category');

		} else {

			$this->session->set_flashdata('error','Something Went Wrong !!');

			return redirect('admin/category');

		}

		

	}



	public function deleteCategory($catId){

		$catCodn = ['cat_id' => $catId];

		if($this->cm->deleteData($catCodn,'categories')){

			$this->cm->deleteData($catCodn,'questions');

			$this->session->set_flashdata('success', 'Category Deleted !!');

			return redirect('admin/category');

		} else {

			$this->session->set_flashdata('error','Something Went Wrong !!');

			return redirect('admin/category');

		}

	}



	public function questionList(){

		$questions = $this->cm->getJoinData();

		$this->load->view('admin/question', compact('questions'));

	}



	public function questionDetails(){

		$catCond = ['status'=>1];

		$catColmn = ['*'];

		$categories = $this->cm->getData($catColmn,$catCond,'','categories');

		$this->load->view('admin/question-detail',compact('categories'));

	}



	public function addQuestionDetails() {



		if(!empty($_POST['option_answer']) && !empty($_POST['option_point']) && !empty($_POST['question_description']) && !empty($_POST['cat_id'])){

			$tick_type = '';

			if( (!empty(trim($_POST['all_tick_answer_header'])) || !empty(trim($_POST['all_tick_answer_footer'])) ) && (!empty(trim($_POST['if_any_untick_answer_header'])) || !empty(trim($_POST['if_any_untick_answer_footer'])) )  ){

				$tick_type = 'ticked';

			}



		$insertData = array(

			'cat_id' 		=> $_POST['cat_id'],

			'question' 		=> $_POST['question_description'],

			'question_type' => $_POST['question_type'],

			'tick_header' 	=> trim($_POST['all_tick_answer_header']),

			'tick_footer' 	=> trim($_POST['all_tick_answer_footer']),

			'untick_header' => trim($_POST['if_any_untick_answer_header']),

			'untick_footer' => trim($_POST['if_any_untick_answer_footer']),

			'tick_type' 	=> $tick_type

		);

		if($insertId = $this->cm->insertData('questions',$insertData))

			{

				if(!empty($_POST['option_answer']) && !empty($_POST['option_point']))

				{

					$i = 0;

					foreach($_POST['option_answer'] as $option_answer)

					{	

						if(!empty($option_answer)){

							$optionData = array(

								'question_id' => $insertId,

								'options' => $_POST['option'][$i],

								'option_bullet' => $_POST['image_option'][$i],

								'option_answer' => $_POST['option_answer'][$i],

								'option_point' => $_POST['option_point'][$i],

								'option_header' => $_POST['option_header'][$i]

							);



							$this->cm->insertData('options',$optionData);

						}

						$i++;

					}



				}



				$this->session->set_flashdata('success', 'Question Added !!');

				return redirect('admin/questions');

			} else {

				$this->session->set_flashdata('error','Something Went Wrong !!');

				return redirect('admin/question-details');

			}

		} else {

			$this->session->set_flashdata('error','Please fill all the fields !!');

			return redirect('admin/question-details');

		}

	}



	public function deleteQuestion($quesId){

		$quesCodn = ['id' => $quesId];

		$optionCodn = ['question_id' => $quesId];

		if($this->cm->deleteData($quesCodn,'questions')){

			$this->cm->deleteData($optionCodn,'options');

			$this->session->set_flashdata('success', 'Question Deleted !!');

			return redirect('admin/questions');

		} else {

			$this->session->set_flashdata('error','Something Went Wrong !!');

			return redirect('admin/questions');

		}

	}



	public function editQuestion($quesId){

		$catCond = ['status'=>1];

		$catColmn = ['*'];

		$quesCond = ['id'=> $quesId];

		$categories = $this->cm->getData($catColmn,$catCond,'','categories');

		$question = $this->cm->getRowData($catColmn,$quesCond,'questions');

		if(!empty($question)){

			$optionCond = ['question_id'=>$quesId];

			$catColmn = ['*'];

			$question->options = $this->cm->getData($catColmn,$optionCond,'','options');

		}

		//echo "<pre>";print_r($question);die;

		$this->load->view('admin/edit-question-detail',compact('categories','question'));

	}



	public function updateQuestion() {

		$tick_type = '';

			if( (!empty(trim($_POST['all_tick_answer_header'])) || !empty(trim($_POST['all_tick_answer_footer'])) ) && (!empty(trim($_POST['if_any_untick_answer_header'])) || !empty(trim($_POST['if_any_untick_answer_footer'])) )  ){

				$tick_type = 'ticked';

			}

		$updateData = array(

			'cat_id' => $_POST['cat_id'],

			'question' => $_POST['question_description'],

			'tick_header' 	=> trim($_POST['all_tick_answer_header']),

			'tick_footer' 	=> trim($_POST['all_tick_answer_footer']),

			'untick_header' => trim($_POST['if_any_untick_answer_header']),

			'untick_footer' => trim($_POST['if_any_untick_answer_footer']),

			'tick_type' 	=> $tick_type

		);

		$quesCond = ['id' => $_POST['question_id'] ];	

		if($this->cm->updateData($quesCond,'questions',$updateData))

		{

			if(!empty($_POST['option_answer']) && !empty($_POST['option_point']))

			{

				$i = 0;

				foreach($_POST['option_id'] as $optionId)

				{	

					if(!empty($optionId)){

						

						$optionCond = ['id' => $optionId ];

						$optionData = array(

							'options' => $_POST['option'][$i],

							'option_bullet' => $_POST['image_option'][$i],

							'option_answer' => $_POST['option_answer'][$i],

							'option_point' => $_POST['option_point'][$i],

							'option_header' => $_POST['option_header'][$i]

						);



						$this->cm->updateData($optionCond,'options',$optionData);

					} 

					else {



						$insertData = array(

							'question_id' => $_POST['question_id'],

							'options' => $_POST['option'][$i],

							'option_bullet' => $_POST['image_option'][$i],

							'option_answer' => $_POST['option_answer'][$i],

							'option_point' => $_POST['option_point'][$i],

							'option_header' => $_POST['option_header'][$i]

						);



						$this->cm->insertData('options',$insertData);

					}

					$i++;

				}



			}



			$this->session->set_flashdata('success', 'Question Updated !!');

			return redirect('admin/questions');

		} else {

			$this->session->set_flashdata('error','Something Went Wrong !!');

			return redirect('admin/questions');

		}

	}





	public function deleteOption(){



		$optionCodn = ['id' => $_POST['optionId']];



		if($this->cm->deleteData($optionCodn,'options'))

		{

			echo 'Option Deleted';

		} else {



			echo 'Something Went Wrong';

		}

	}



	public function userList()

	{

		

		$userCodn = ['role' => 'user'];

		$userColmn = ['id','firstname','lastname','email','role','mobile','report_generated','report_link','status'];

		$orderby = 'created_at DESC';

		$users = $this->cm->getData($userColmn,$userCodn,$orderby,'users');



		$this->load->view('admin/user', compact('users'));	

	}



	public function changeStatus(){



		$userCodn = ['id' => $_POST['userId']];

		$updateData = ['status' => $_POST['status']];



		if($this->cm->updateData($userCodn,'users',$updateData))

		{

			echo 'User Updated';

		} else {



			echo 'Something Went Wrong';

		}

	}



	public function editCategory() {

		$catCodn = ['cat_id' => $_POST['catId']];

		$category = $this->cm->getRowData(['*'],$catCodn,'categories');

		if(!empty($category)){

			echo json_encode($category);

		} else {

			echo "No category found";

		}

	}



	public function createUpdate() {
		if(isset($_POST['catId']) && !empty($_POST['catId'])) {
			$updateCond = ['cat_id'=>$_POST['catId']];
			$filename = "";
			if(!empty($_FILES['cat_image']['name']) && isset($_FILES['cat_image']['name'])){
				$ext = strtolower(pathinfo($_FILES['cat_image']['name'], PATHINFO_EXTENSION));
				$tempname = $_FILES["cat_image"]["tmp_name"];
				$filename = "Category_".time().".".$ext;
				move_uploaded_file($tempname,"./uploads/".$filename);
			} else {
				$filename = $_POST['hideImage'];
			}
			$insertUpdate = [
				'cat_name' 			=> !empty($_POST['cat_name']) ? $_POST['cat_name'] : '',
				'cat_description' 	=> !empty($_POST['cat_description']) ? $_POST['cat_description'] : '',
				'cat_image'			=>$filename
			];
			if($this->cm->updateData($updateCond,'categories',$insertUpdate))
			{
				$this->session->set_flashdata('success', 'Category Updated !!');
				return redirect('admin/category');
			} else {
				$this->session->set_flashdata('error','Something Went Wrong !!');
				return redirect('admin/category');
			}
		}
	}

	public function userScore() {
		if(isset($_POST['searchBtn']) && !empty($_POST['searchBtn']) && $_POST['searchBtn'] == 'searchBtn'){
			//echo "<pre>";print_r($_POST);
			$post_cat = !empty($_POST['category_name'])?$_POST['category_name']:'';
			$post_date_range = explode('-',$_POST['cat_date_range']);
			
			$query = $this->db->query("SELECT * FROM `user_score` WHERE  (report_submit BETWEEN '".trim(strtotime($post_date_range[0]))."' AND '".strtotime(trim($post_date_range[1]))."')");
			/*echo $this->db->last_query();
			die();*/
			$scores = $query->result();

			
			if(!empty($post_cat)){
				$cat_perce_range_from = !empty($_POST['cat_perce_range_from'])?$_POST['cat_perce_range_from']:'';
				$cat_perce_range_to = !empty($_POST['cat_perce_range_to'])?$_POST['cat_perce_range_to']:'';
				foreach($scores as $key => $score){
					$catPoints = json_decode($score->cat_points);
					//print_r($catPoints);
					if(isset($catPoints->$post_cat) && ($catPoints->$post_cat >= $cat_perce_range_from && $catPoints->$post_cat <= $cat_perce_range_to)) {
						
					} else {
						unset($scores[$key]);
					}
				}
			}
		} else {
			$scores = $this->cm->getData(['*'],[],'','user_score');
		}
		$cats = $this->cm->getData(['*'],[],'','categories');
		$this->load->view('admin/user-score', compact('scores','cats'));	
	}

	public function searchUserScore() {
		//echo "<pre>";print_r($_POST);die();
		$post_cat = !empty($_POST['category_name'])?$_POST['category_name']:'';
		$post_date_range = explode('-',$_POST['cat_date_range']);
		$cat_perce_range_from = 0;
		$cat_perce_range_to = 0;
		if(!empty($post_cat)){
			$cat_perce_range_from = !empty($_POST['cat_perce_range_from'])?$_POST['cat_perce_range_from']:'';
			$cat_perce_range_to = !empty($_POST['cat_perce_range_to'])?$_POST['cat_perce_range_to']:'';

			$where = "(report_submit BETWEEN '".trim($cat_perce_range_from)."' AND '".trim($cat_perce_range_to)."')";
		}
		$query = $this->db->query("SELECT * FROM `user_score` WHERE  (report_submit BETWEEN '".trim($post_date_range[0])."' AND '".trim($post_date_range[1])."')");
		$scores = $query->result();

		foreach($scores as $key => $score){
			$catPoints = json_decode($score->cat_points);
			//print_r($catPoints);
			if(isset($catPoints->$post_cat) && ($catPoints->$post_cat >= $cat_perce_range_from && $catPoints->$post_cat <= $cat_perce_range_to)) {
				
			} else {
				unset($scores[$key]);
			}
		}


		$cats = $this->cm->getData(['*'],[],'','categories');
		$this->load->view('admin/user-score', compact('scores','cats'));
	}

	public function scoreMail($id){
		$userData = $this->cm->getRowData(['*'],['id'=>$id],'users');
		$this->load->view('admin/score-mail',compact('userData'));
	}
	public function sendScoreMail($id){
		$userData = $this->cm->getRowData(['*'],['id'=>$id],'users');
		$this->load->library('email');
		$message = "<h4>Your report analysis</h4>";
		$message .= "<br/>";
		$message .= $_POST['email_content'];
		$message .= "<br/>";
		$message .= "<h4>Thanks,<br>HBC</h4><br>";
	    $message .= "<img style='height: 60px;' src = '".base_url('assets/img/logo-2.png')."' >";
	    $this->email->from('websitebyranking@gmail.com', 'HBC');
	    $this->email->to($userData->email);
	    $this->email->cc('anupmishra509@gmail.com');
	    $this->email->subject($_POST['email_subject']);
	    $this->email->message($message);
	    $this->email->set_mailtype("html");
	    $this->email->send();
		$this->session->set_flashdata('success', 'Mail Send Sussessfully !!');
		return redirect('/admin/user-score');
	}
}
/* End of file AdminController.php */
/* Location: ./application/controllers/AdminController.php */
?>