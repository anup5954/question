
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CommonModel extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getData($column = null, $condition = null,$orderBy = null , $table = null) {
		$this->db->select($column);
		$this->db->where($condition);
		$this->db->order_by($orderBy);
		$query = $this->db->get($table);
		//echo $this->db->last_query();die();
		if($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function deleteData($condition,$table) {
    	$query = $this->db->where($condition)
    						->delete($table);
    	if($query) {
    		return true;
    	} else {
    		return false;
    	}
    }

	public function getNumRow($condition = null , $table = null) {
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();die();

		if($query) {
			return $query->num_rows();
		} else {
			return false;
		}
	}

	public function getRowData($column = null, $condition = null, $table = null){
		$this->db->select($column);
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();die();
		if($query){
			return $query->row();
		} else{
			return false;
		}
	}

	public function insertData($table, $data) {
    	$query = $this->db->insert($table,$data);
    	if($query) {
    		return $this->db->insert_id();
    	} else {
    		return false;
    	}
    }

    public function getRowSelectd($column,$condtion="",$table){
    	$this->db->select($column);
    	if(!empty($condtion) && isset($condtion)){
			$this->db->where($condtion);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			return $query->row();
		} else {
			return false;
		}
    }

    public function updateResponseData($condition,$table,$data) {
		$response_id = $condition['response_id'];
    	$query = $this->db->where($condition)
							->update($table,$data);
        //echo $this->db->last_query();die;
    	if($query) {
    		return $response_id;
    	} else {
    		return false;
    	}
    }

  

    public function updateData($condtion,$table,$data){
    	$query = $this->db->where($condtion)
    					->update($table,$data);
    	if($query){
    		return true;
    	} else {
    		return false;
    	}
    }

    public function getAllResponses($sectorId,$indicator_id,$userId,$response_value,$moduleId){
		$query = $this->db->query("SELECT response_id FROM integrated_response WHERE sector_id='$sectorId' AND indicator_id = '$indicator_id' AND userId = '$userId' AND response_value != '$response_value' AND module_id = '$moduleId' AND status = 1");
		if($query) {
    		return $query->result();
    	} else {
    		return false;
    	}
	}

    public function getAllResponsesForDoc($sectorId,$indicator_id,$userId,$moduleId,$quesId){
        $query = $this->db->query("SELECT response_id FROM integrated_response WHERE sector_id='$sectorId' AND indicator_id = '$indicator_id' AND userId = '$userId' AND module_id = '$moduleId' AND question_id='$quesId' AND status=1 ");
        if($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getQuestions($colmn,$inOper,$condition,$table){
    	$this->db->select($colmn);
		$this->db->where_in('module_id',$inOper, FALSE);
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		if($query) {
			return $query->result();
		} else {
			return false;
		}
    }

    public function getJoinData(){
    	$query = $this->db->select('t1.*, t2.*')
     				->from('categories as t1')
     				->join('questions as t2', 't1.cat_id = t2.cat_id')
     				->order_by('t2.created_at', 'ASC')
     				->get();
     	if($query) {
     		return $query->result();
     	} else {
     		return false;
     	}
    }


    public function getEditQuestionData($quesId){
    	$query = $this->db->select('t1.*, t2.*, t3.*')
     				->from('categories as t1')
     				->join('questions as t2', 't1.cat_id = t2.cat_id')
     				->join('options as t3', 't2.id = t3.question_id')
     				->where('t2.id',$quesId)
     				->get();
     	if($query) {
     		return $query->result();
     	} else {
     		return false;
     	}
    }


    public function getOptionPoints($inOper){
    	$query = $this->db->query('select sum(option_point) as catPoints from options where id IN ('.$inOper. ')');
		//echo $this->db->last_query();
		if($query) {
			return $query->row()->catPoints;
		} else {
			return false;
		}
    }


    public function getPdfData() {
    	$catCond = ['status'=>1];
		$catColmn = ['*'];

		$categories = $this->getData($catColmn,$catCond,'','categories');

		if(!empty($categories)){

			foreach($categories as $cat){

				$quesCond = ['cat_id'=> $cat->cat_id];
				$cat->questions = $this->getData($catColmn,$quesCond,'','questions');

				if(!empty($cat->questions)){
					foreach($cat->questions as $ques){
						$optionCond = ['question_id'=>$ques->id];
						$optionColmn = ['*'];
						$answerCond = ['question_id'=>$ques->id,'userId'=>$this->session->userdata('user')->id];
						$ques->answers = $this->getRowData($optionColmn,$answerCond,'user_answers');

						$ques->options = $this->getData($optionColmn,$optionCond,'','options');
						
					}
				}
			}
		}
		//echo "<pre>";print_r($categories);die();

		$graph_img = base_url('assets/img/tree.jpg');
  		//if(file_exists('./uploads/Category_1657795018.jpg')){
		$type1 = pathinfo($graph_img, PATHINFO_EXTENSION);
		$data1 = file_get_contents($graph_img);
		$base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
		
  		//}
  		//$output = '<style>@page { margin: 2px; }body { margin: 10px;border: 3px solid orange; }</style>';
  		
  		//css start
		
  		//css end 


    	$output = '<div class="bg-white rounded questionanswer">';
    	$output .= '<br><br><center><p>BUSINESS GROWTH REPORT<br><br>
						FOR<br><br>
					HBC<br><br></p>';
		$output .= '<style>.bulletImgCls{ padding-left:25px !important;}</style>';
		$output .= '<img style="width:600px;height:500px;" src="'.$base641.'"></center>';
		$output .= '<br><br><br><br><br><br>';
		$output .= 'Dt: '.$this->session->userdata('user')->report_date;
		$output .= '<p style="page-break-after:always"></p>';
		$output .= '<h2>Overview</h2>
			<p>This Report aims at analysing and identifying the growth pattern of the business.</p>

			<p>It shall reveal the existing gaps to be bridged within the Company as required for stronger growth.</p>

			<p><strong>Thank you for answering all the questions. </strong></p>

			<h5>The Report is based on the Answers provided by you.</h5>

			<p>Each section is individually scored. </p>

			<p>Questions posed to you were broken into 26 logical Sections. Each of these Sections has a total score of 100.</p>

			<p>The Report is lengthy. For the desired results, it is advisable to take 1 area at a time and start implementing the suggestions. Here, you can start:</p>

			<p>- Either from the area which has the lowest score</p>

			<p>- Or the area which you feel would give the most beneficial results.</p>

			<p>We recommend the following steps to facilitate you to take the maximum advantage of the Report.</p>
			<p>1.	Establish your growth ambitions / vision with a timeline of 1 – 5 years depending on what is best suited to your type of business.</p>
			<p>2.	Determine your metrics – the way in which you would measure success.</p>
			<p>3.	Create a plan keeping in mind the result of this Report. We have used 3 colours namely <strong style="color:#52d43b;">GREEN </strong>, <strong style="color:#e4c03b;">YELLOW </strong> and <strong style="color:#cf0004;">RED </strong> to highlight the scores.</p>
			<p> <div style="display:inline-block;"> <div style="border : solid #52d43b ;  border-width :5px; width:5px; height:5px; border-radius:50%; background:#9ee994;display:inline-block; margin-right:5px; "></div></div> <strong style="color:#52d43b;">Green </strong>  colour signifies that this particular business area is working satisfactorily or better than expected and that no immediate remedial action is required in this particular business function.</p>
			<p> If you feel these are your strengths you may further work on to achieve faster business growth. </p>
			<p> <div style="display:inline-block;"><div style="border : solid #e4c03b ;  border-width :5px; width:5px; height:5px; border-radius:50%; background:#fee893;display:inline-block; margin-right:5px; "></div></div>  <strong style="color:#e4c03b;">YELLOW </strong> colour signifies that this particular business area is not working as it should and that some form of further analysis and remedial action is required.</p>
			<p><div style="display:inline-block;"> <div style="border : solid #cf0004 ;  border-width :5px; width:5px; height:5px; border-radius:50%; background:#f77f7e;display:inline-block; margin-right:5px; "></div></div> <strong style="color:#cf0004;">RED </strong>  colour signifies that this particular business area is in crisis and that you need to take immediate action to address a serious problem within this business function. Such areas could be responsible for slowing down the pace of growth. In case they are critical to the business, they could be responsible for derailing it totally ignoring other areas of strength. We would highly recommend a quick corrective action on all such areas.</p>
			<p>-	Fix a date each month to review the progress and make amend, in case required, in the existing plan.</p>
			<p>4.	Meet with all the stakeholders and after discussions decide the following :</p>
			<p>-	Who would take what action (s).</p>
			<p>-	Set deadline in place for each action to enable timely measures to complete each task.</p>
			<p>-	Fix a date each month to review the progress and make amend, in case required, in the existing plan.</p>
			<p>Smaller businesses may question whether they have 26 functional areas or not. </p>
			<p>Functional areas are not departments within a business, rather, these are the elements that can be found in most businesses. If you have no activity in any particular area at this time, it may simply be an indication that it might be useful to consider such an area for analysis or action.</p>			<p>Most business owners should be able to address some of the business issues identified in this Section themselves. However, in case you feel that you are not in a position to address problem areas in your business yourself or even with your existing team, then we would recommend that you engage with us and we will help you to implement the required changes.</p>
			<p>We concede that this Report will not give you 100% accuracy in relation to your business. This could not be realistically achieved without spending time in your business and talking to you and/or your people at some length. However, based on our initial question set, and the answers given by you, this Report should provide a pretty good high-level assessment of what is going on in your business.</p>
			<p>It is important to remember that businesses are dynamic in nature and change over time. Consequently, the scores you achieved today may be radically different if you were to answer the question set again in 3 to 6 months time. </p>
			<p>We recommend that: </p>
			<p>- you do this assessment on a quarterly basis to get the best results. </p>
			<p>- your entire management team can sit together and take this assessment every time.</p>
			<p>The Report covers 26 sections. Brief about all the sections is given hereunder:</p>
				';
		$output .= '<p style="page-break-after:always"></p>';
		$output .= '<table border="1" style="width:100%">';
		$output .= '<tr><th>S No.</th>';
		$output .= '<th>Section</th>';
		$output .= '<th>Score (%)</th>';
		$output .= '<th>Colour</th></tr>';
		$scoreData = [];
		if(!empty($categories)){
			$i=1;
			foreach($categories as $cat){
				$cat_points = 0;
				$cat_options = $this->getData(['question_id','option_id'],['cat_id'=>$cat->cat_id,'userId'=>$this->session->userdata('user')->id],'','user_answers');
				$inCondn = array();
        		
        		foreach($cat_options as $cat_option){
        			
        			//more than 5

        			if($cat_option->question_id == 340 || $cat_option->question_id == 379){
        				$singleQuest = $this->getRowData(['*'],['id'=>$cat_option->question_id],'questions');

						if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						if(count($options) >= $singleQuest->less_then) {
							$cat_points =  $cat_points + $singleQuest->more_then_marks;
						} else {
							$cat_points =  $cat_points + $singleQuest->less_then_marks;
						}
 
        			} elseif($cat_option->question_id == 412){
        				$cat_points =  $cat_points + 2;
        			} elseif($cat_option->question_id == 493){
        				$cat_points =  $cat_points + 10;
        			}

        			elseif($cat_option->question_id == 501){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 209

						if(count($options) == 1 && in_array(1487, $options)) {
							$cat_points =  $cat_points + 40;
						} else {
							$cat_points =  $cat_points + (40-(count($options)*3));
						}  
        			} elseif($cat_option->question_id == 503){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 1487

						if(count($options) == 1 && in_array(1498, $options)) {
							$cat_points =  $cat_points + 30;
						} else {
							$cat_points =  $cat_points + (30-(count($options)*3));
						}  
        			} elseif($cat_option->question_id == 471) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 20;
						} else {
							$cat_points =  $cat_points + 10;
						}
        			} elseif($cat_option->question_id == 505) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 14;
						} else {
							$cat_points =  $cat_points + 4;
						}
        			}

        			elseif($cat_option->question_id == 293) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 20;
						} else {
							$cat_points =  $cat_points + 10;
						}
        			}


        			elseif($cat_option->question_id == 491) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT) == 1 && in_array(1446, $optionsTT)) {
							$cat_points =  $cat_points + 40;
						} else {
							$cat_points =  $cat_points + (40-(count($optionsTT)));
						} 

        			} elseif($cat_option->question_id == 489){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 1414

						if(count($options) == 1 && in_array(1414, $options)) {
							$cat_points =  $cat_points + 0;
						} else {
							$cat_points =  $cat_points + 2;
						}  
        			}  elseif($cat_option->question_id == 543) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  > 0){
							$cat_points =  $cat_points + 5;
						}
        			}
        			elseif($cat_option->question_id == 545) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT) > 0){
							$cat_points =  $cat_points + 10;
						}
        			}
        			
        			else {
        				  array_push($inCondn,$cat_option->option_id);
        			}
        		}

        		$color = "";

        		$cat_points = $cat_points +  $this->getOptionPoints(implode(',',$inCondn));
        		if($cat_points >= 0 && $cat_points <= 40){
        			$color = "#ff0000";
        		} elseif($cat_points > 40 && $cat_points <= 70){
        			$color = "#FFFF00";
        		} elseif($cat_points > 70){
        			$color = "#00FF00";
        		}
        		$scoreData[$cat->cat_id] = $cat_points;
        		$output .= '<tr>';
        		$output .= '<td>'.$i++.'</td>';
        		$output .= '<td>'.$cat->cat_name.'</td>';
        		$output .= '<td style="text-align:center">'.$cat_points.'</td>';
        		$output .= '<td style="background-color:'.$color.'"></td>';
        		$output .= '</tr>';
			}
		}
		$insScoreData = [
			'userId' => $this->session->userdata('user')->id,
			'cat_points' => json_encode($scoreData),
			'report_submit' => strtotime(date('m/d/Y'))
		];
		$this->insertData('user_score',$insScoreData);

		$output .= '</table>';
		$output .= '<p style="page-break-after:always"></p>';

		$output .= '<section style="width:700px; margin: auto;">
	<div class="list-bullet-poing">
		<div style="background-color: #f3b1cd; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px; ">

			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;  ">Category 1 <span style="width: 120px;  background-color:#e05c95; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;  ">Marketing </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px; ">
				<li>Identify the strength of your marketing team.</li>
				<li>Check the budget allocation for marketing. </li>
				<li>Whether the return on investment is positive with respect to marketing.</li>

			</ul>
		</div>

		<div style="background-color: #bad5f0; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 2 <span style="width: 120px; background-color:#5ca6ef; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Sales </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Checks the operations and effectiveness of sales function.</li>

			</ul>
		</div>

		<div style="background-color: #c2d5a8; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 3 <span style="width: 120px; background-color:#527c16; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Customer Service </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Questions the customer service focus in the business.</li>
				<li>Identify ways in which customer service can be enhanced.</li>

			</ul>
		</div>

		<div style="background-color: #b0abcb; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 120px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 4 <span style="width: 120px; background-color:#6759b8; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:120px;">Pricing Strategy  </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the adequacy of your profit margins. </li>
				<li>Check the accuracy of the methods used for product pricing.</li>
				<li>Establish the impact of price increases or decreases on the business.</li>

			</ul>
		</div>

		<div style="background-color: #f0d5ba; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 5 <span style="width: 120px; background-color:#db8129; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Understanding your customers </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Explores the target markets for business.</li>
				<li>Best ways to attract and retain customers.</li>
				<li>Figure out how the business is currently engaging with the customers and what can be improved.</li>

			</ul>
		</div>

		<div style="background-color: #d6eff6; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 6 <span style="width: 120px; background-color:#68a9bc; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Credit Control </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Checks adequacy of your credit control procedures. </li>
				<li>Measures the speed at which you turn receivables into cash.</li>

			</ul>
		</div>

		<div style="background-color: #fccbb5; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 7 <span style="width: 120px; background-color:#f87439; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Product / Service Offering</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Product / Service Offering. </li>
				<li>Evaluates the risks and benefits that are associated with your product choices. </li>

			</ul>
		</div>

		<div style="background-color: #cbafbd; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 8 <span style="width: 120px; background-color:#c3518a; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Purchase</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identifies the processes involved in procurement.</li>

			</ul>
		</div>

		<div style="background-color: #afc4af; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 120px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 9 <span style="width: 120px; background-color:#399439; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:120px;">Human Resources</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the experience and work ethics. </li>
				<li>Assess the quality of communication in business.</li>
				<li>Identify if any problem exists in the functioning of HR.</li>
				<li>Checks the quality of performance management and accountability within the business.</li>

			</ul>
		</div>

		

		<div style="background-color: #c2a289; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 10 <span style="width: 120px; background-color:#cb702a; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Operations</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify operational capability of the business.</li>
				<li>Check effectiveness of administration. </li>

			</ul>
		</div>


		<div style="background-color: #f3b1cd; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px; min-height: 100px;">

			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 11 <span style="width: 120px; background-color:#e05c95; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Financial Performance </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Checks the ways in which you track and measure the financial performance of the business.</li>
				<li>Evaluates risk factors that can impact  financial stability of the business.</li>

			</ul>
		</div>

		<div style="background-color: #bad5f0; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 12 <span style="width: 120px; background-color:#5ca6ef; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Financial Stability </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Assessing  the financial stability of the business. </li>
				<li>Checking the access to debt and/or equity funding. </li>

			</ul>
		</div>

		<div style="background-color: #c2d5a8; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 120px;">
			<p style="padding: 10px;display:flex; align-items:center;"><br><br>Category 13 <span style="width: 120px; background-color:#527c16; padding:0px 10px;   color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;height:120px;"><br><br>Management Accounts</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Check the adequacy of the management accounting function. </li>
				<li>Identify whether the monthly financial reports are timely and used adequately.</li>

			</ul>
		</div>

		<div style="background-color: #b0abcb; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 14 <span style="width: 120px; background-color:#6759b8; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">IT Systems   </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the adequacy or inadequacy of the existing computer system. </li>
				<li>Checks for the data security measures and the robustness of the backup protocols.</li>

			</ul>
		</div>

		<div style="background-color: #f0d5ba; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 120px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 15 <span style="width: 120px; background-color:#db8129; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:120px;">Management  </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the experience and competence of the management team.</li>
				<li>Knowing various perceptions of management as to how well the business is managed. </li>
				<li>Check whether management team is complete or not.</li>

			</ul>
		</div>

		<div style="background-color: #d6eff6; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 16 <span style="width: 120px; background-color:#68a9bc; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">MIS</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Quality of information generated by the MIS in use. </li>
				<li>Check if it adequately meets the business needs.</li>

			</ul>
		</div>

		<div style="background-color: #fccbb5; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 17 <span style="width: 120px; background-color:#f87439; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Business Goals </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify business goals.</li>
				<li>Assess the effectiveness of the implementation process.</li>

			</ul>
		</div>

		<div style="background-color: #cbafbd; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 18 <span style="width: 120px; background-color:#c3518a; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Your Niche </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify key differentiating factors and sustainable competition in the prevailing conditions.</li>

			</ul>
		</div>

		<div style="background-color: #afc4af; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 19 <span style="width: 120px; background-color:#399439; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Challenges</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify specific challenges facing the business. </li>
				<li>Analyse the methods / ways in which they are being addressed</li>

			</ul>
		</div>

		

		<div style="background-color: #c2a289; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 20 <span style="width: 120px; background-color:#cb702a; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Growth Potential</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the opportunities that exist for your business both in terms of quantity and quality.</li>

			</ul>
		</div>

		<div style="background-color: #f3b1cd; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height:100px">

			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 21 <span style="width: 120px; background-color:#e05c95; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Risk Management </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the key business risks facing the business and how you mitigate the same.</li>

			</ul>
		</div>

		<div style="background-color: #bad5f0; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 22 <span style="width: 120px; background-color:#5ca6ef; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Key Performance Indicators </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Highlights a wide range of possible KPIs. </li>
				<li>Ascertain the ones commonly used in your business. </li>
				<li>Evaluates the benefits derived by you through the use of KPI&apos;s. </li>

			</ul>
		</div>

		<div style="background-color: #c2d5a8; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 23 <span style="width: 120px; background-color:#527c16; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Communication</span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify the quality of internal communication in the business. </li>
				<li>Check the type and extent of information being made available to the employees. </li>

			</ul>
		</div>

		<div style="background-color: #b0abcb; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 130px;">
			<p style="padding: 10px;display:flex; align-items:center; "><br><br>Category 24 <span style="width: 120px; background-color:#6759b8; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px; height:130px;"><br><br>Strategic Business Planning   </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>This section questions your attitude to business planning and highlights the importance of using your business plan to drive the business forward.</li>
				<li>It looks to identify the core values of the owners, the vision for the business, as well as the mission, objectives and strategies that may exist.</li>

			</ul>
		</div>

		<div style="background-color: #f0d5ba; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 25 <span style="width: 120px; background-color:#db8129; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Competition monitoring  </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Assess your knowledge of the prevalent competition.</li>
				<li>Identify the probable threats to the business.</li>

			</ul>
		</div>

		<div style="background-color: #d6eff6; border-radius:50px ; position: relative; display: flex; align-items: center; margin-bottom: 10px; padding-left: 10px;min-height: 100px;">
			<p style="padding: 10px;display:flex; align-items:center;line-height:25px;">Category 26 <span style="width: 120px; background-color:#68a9bc; padding:0px 10px; color:#fff; position: absolute; top:0px; bottom: 0px; left: 120px;line-height:25px;height:100px;">Owner&apos;s Mindset </span></p>
			<ul style="padding-left:130px;padding-right:30px;position: absolute; top:-5px; bottom: 0px; left: 160px;">
				<li>Identify limiting beliefs, barriers in owner&apos;s mindset restricting the business growth. </li>

			</ul>
		</div>


	</div>
</section>';
$redbullet = '<div style="padding-top:30px;display:inline-block;"> <div style="border : solid #cf0004 ;  border-width :5px; width:10px; height:10px; border-radius:50%; background:#f77f7e;display:inline-block; margin-right:10px; "></div></div>';
$greenbullet = '<div style="padding-top:30px;display:inline-block;"> <div style="border : solid #52d43b ;  border-width :5px; width:10px; height:10px; border-radius:50%; background:#9ee994;display:inline-block; margin-right:10px; "></div></div>';
$yellowbullet = '<div style="padding-top:30px;display:inline-block;"><div style="border : solid #e4c03b ;  border-width :5px; width:10px; height:10px; border-radius:50%; background:#fee893;display:inline-block; margin-right:10px; "></div></div>';
$output .= '<p style="page-break-after:always"></p>';

      	$c = 0;
      	$catLength = count($categories);
      	if(!empty($categories)){

        	foreach($categories as $cat){
        		$cat_points = 0;
        		$cat_options = $this->getData(['question_id','option_id'],['cat_id'=>$cat->cat_id,'userId'=>$this->session->userdata('user')->id],'','user_answers');

        		$inCondn = array();

        		foreach($cat_options as $cat_option){
        			
        			//more than 5

        			if($cat_option->question_id == 340 || $cat_option->question_id == 379){
        				$singleQuest = $this->getRowData(['*'],['id'=>$cat_option->question_id],'questions');

						if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						if(count($options) >= $singleQuest->less_then) {
							$cat_points =  $cat_points + $singleQuest->more_then_marks;
						} else {
							$cat_points =  $cat_points + $singleQuest->less_then_marks;
						}
 
        			} elseif($cat_option->question_id == 412){
        				$cat_points =  $cat_points + 2;
        			} elseif($cat_option->question_id == 493){
        				$cat_points =  $cat_points + 10;
        			}

        			elseif($cat_option->question_id == 501){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 1487

						if(count($options) == 1 && in_array(1487, $options)) {
							$cat_points =  $cat_points + 40;
						} else {
							$cat_points =  $cat_points + (40-(count($options)*3));
						}  
        			} elseif($cat_option->question_id == 503){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 1487

						if(count($options) == 1 && in_array(1498, $options)) {
							$cat_points =  $cat_points + 30;
						} else {
							$cat_points =  $cat_points + (30-(count($options)*3));
						}  
        			} elseif($cat_option->question_id == 471) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 20;
						} else {
							$cat_points =  $cat_points + 10;
						}
        			}

        			elseif($cat_option->question_id == 505) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 14;
						} else {
							$cat_points =  $cat_points + 4;
						}
        			}

        			elseif($cat_option->question_id == 293) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  == count($optionsTick)){
							$cat_points =  $cat_points + 20;
						} else {
							$cat_points =  $cat_points + 10;
						}
        			}

        			elseif($cat_option->question_id == 491) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT) == 1 && in_array(1446, $optionsTT)) {
							$cat_points =  $cat_points + 40;
						} else {
							$cat_points =  $cat_points + (40-(count($optionsTT)));
						}
						 
        			} elseif($cat_option->question_id == 489){

        				// 40-3 wala

        				if(!empty($cat_option->option_id)){
							$options = explode(',',$cat_option->option_id);
						}

						// none id 1414

						if(count($options) == 1 && in_array(1414, $options)) {
							$cat_points =  $cat_points + 0;
						} else {
							$cat_points =  $cat_points + 2;
						}  
        			} elseif($cat_option->question_id == 543) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT)  > 0){
							$cat_points =  $cat_points + 5;
						}
        			} 
        			elseif($cat_option->question_id == 545) {
        				$optionCondT = ['question_id'=>$cat_option->question_id];
						$optionColmnT = ['*'];
						$answerCondT = ['question_id'=>$cat_option->question_id,'userId'=>$this->session->userdata('user')->id];
						$answersTick = $this->getRowData($optionColmnT,$answerCondT,'user_answers');
						$optionsTick = $this->getData($optionColmnT,$optionCondT,'','options');

						$optionsTT = explode(',',$answersTick->option_id);

						if(count($optionsTT) > 0){
							$cat_points =  $cat_points + 10;
						}
        			}
        			
        			else{
        				array_push($inCondn,$cat_option->option_id);
        			}
        		}


        		$cat_points = $cat_points + $this->getOptionPoints(implode(',',$inCondn));
        		

      			$output .= '<div class="card shadow  activeDiv">';
        		$output .= '<div class="card-header d-flex">';
          		$output .= '<h3 style="color:blue;" class="ml-auto   d-flex align-items-center"><span class="text-success">'.$cat->cat_name.'</span> | Points: '.$cat_points.'</h3>';

          		if(!empty($cat->cat_image)){
	          		$path = base_url('uploads/'.$cat->cat_image);
	          		if(file_exists('./uploads/'.$cat->cat_image)){
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	          			$output .= '<img src="'.$base64.'" style="height:100px;width:700px;"><br><br>';
	          		}
          		}

        		$output .= '</div>'; 
        		$i = 1;
        		if(!empty($cat->questions)){ 
          			foreach($cat->questions as $ques){
        			$output .= '<div class="card-body border-bottom" id="'.$ques->id.'">';
          			/*$output .= '<div class="wdinput form-group">';
            		$output .= '<label class=" ">Question <span class="text-danger">'.$i++.'</span></label>';
            		$output .= '<p>'.$ques->question.'</p>';
          			$output .= '</div>';*/

          			/*if($ques->question_type == 'multiple'){

          				$tick_items = count(explode(',',$ques->answers->option_id));
          				$output .= ' <label class=" ">You have ticked '.$tick_items. ' options</label>';
          			}*/

          			$output .= '<div class="wdinput form-group">';

          			if($ques->question_type == 'binary'){
	              		if(!empty($ques->answers)){

	              			$option_row = $this->getRowData(['*'],['id' => $ques->answers->option_id],'options');

	                		/* foreach($ques->options as $option){
	                		$binaychecked = "";
	                		if(!empty($ques->answers->option_id) && $option->id == $ques->answers->option_id){
	                			$binaychecked = "checked";
	                		}
	                		$output .= '<label class=" ">'.ucfirst($option->options).'
	                  					<input type="radio" '.$binaychecked.'>
	                  					<span class="checkmark"></span>
	                					</label>';
	              			}*/

	              			$bullet_image = '';

	              		/*	if(!empty($option_row->option_bullet)){
				          		$path1 = base_url('assets/img/'.$option_row->option_bullet);
				          		if(file_exists('./assets/img/'.$option_row->option_bullet)){
									$type1 = pathinfo($path1, PATHINFO_EXTENSION);
									$data1 = file_get_contents($path1);
									$base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
				          			$bullet_image = '<img src="'.$base641.'" style="height:15px; position:relative;top:35px;">';
				          		}
			          		}*/

			          		if(!empty($option_row->option_header) && strcasecmp(trim(strip_tags($option_row->option_header)),'Nil')){
			          		 
			          		    if($option_row->option_bullet == 'redbullet.png'){
			          		        $bullet_image = $redbullet;
			          		    } elseif($option_row->option_bullet == 'yellowbullet.png'){
			          		        $bullet_image = $yellowbullet;
			          		    } elseif($option_row->option_bullet == 'greenbullet.png'){
			          		        $bullet_image = $greenbullet;
			          		    }
				          		$output .= '<label style="font-weight:bold; font-size:22px; color:#002ea2; padding-top:30px;">'.$bullet_image.str_replace(array("\n", "\r"), '', trim($option_row->option_header)).'</label>';
				          	}

	              			if(strcasecmp(trim(strip_tags($option_row->option_answer)),'Nil')){
								//$output .= $bullet_image.' <label class=" ">'.str_replace(array('<div>','</div>','<p>','</p>','<table>','</table>'), '', $option_row->option_answer).'</label><br>';
								$output .='<label >'.str_replace(array("\n", "\r"), '', trim($option_row->option_answer)).'</label>';
							}

	              			//$output .= '<label class=" ">'.$option_row->option_answer.'</label><br>';

	              			}

	              			
	              		}

          				elseif($ques->question_type == 'mcq'){

              				if(!empty($ques->answers)){

              					$option_row = $this->getRowData(['*'],['id' => $ques->answers->option_id],'options');

	                				/*foreach($ques->options as $option){
	                				$mcqchecked = "";
	                				if(!empty($ques->answers->option_id) && $option->id == $ques->answers->option_id){
	                					$mcqchecked = "checked";
	                				}
	                  				$output .= '<label class="radio-btn">'.$option->options.'
	                    				<input type="radio" '.$mcqchecked.'>
	                    				<span class="checkmark"></span>
	                  				</label>';
	              				}*/

	              				$bullet_image = '';

		              			/*if(!empty($option_row->option_bullet)){
					          		$path1 = base_url('assets/img/'.$option_row->option_bullet);
					          		if(file_exists('./assets/img/'.$option_row->option_bullet)){
										$type1 = pathinfo($path1, PATHINFO_EXTENSION);
										$data1 = file_get_contents($path1);
										$base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
					          			$bullet_image = '<img src="'.$base641.'" style="height:15px; position:relative;top:35px;">';
					          		}
				          		}*/

				          	if(!empty($option_row->option_header) && strcasecmp(trim(strip_tags($option_row->option_header)),'Nil')){
			          		 
			          		    if($option_row->option_bullet == 'redbullet.png'){
			          		        $bullet_image = $redbullet;
			          		    } elseif($option_row->option_bullet == 'yellowbullet.png'){
			          		        $bullet_image = $yellowbullet;
			          		    } elseif($option_row->option_bullet == 'greenbullet.png'){
			          		        $bullet_image = $greenbullet;
			          		    }
				          		$output .= '<label style="font-weight:bold; font-size:22px; color:#002ea2; padding-top:30px;">'.$bullet_image.str_replace(array("\n", "\r"), '', trim($option_row->option_header)).'</label>';
				          	}

	              				if(strcasecmp(trim(strip_tags($option_row->option_answer)),'Nil')){
	              					//$output .= ' <label class=" ">'.$option_row->options.'</label> <br>'.$bullet_image.' <label class=" ">'.$option_row->option_answer.'</label><br>';

	              					$output .='<label>'.str_replace(array("\n", "\r"), '', trim($option_row->option_answer)).'</label>';
	              				}

	              				//$output .= ' <label class=" ">'.$option_row->options.'</label> <br><label class=" ">'.$option_row->option_answer.'</label><br>';
              				}
              				
              			}

      					elseif($ques->question_type == 'multiple'){
            				
            				if(!empty($ques->answers)){

            					$options = explode(',',$ques->answers->option_id);



            					if($ques->tick_type == 'ticked'){
            						if(!empty($ques->less_then)) {
            							if(count($options) >= $ques->less_then) {

            								if(strcasecmp(trim(strip_tags($ques->tick_header)),'Nil')){
            										$output .= '<label style="display:block">'.$ques->tick_header.'</label>';
            								}

            								if(strcasecmp(trim(strip_tags($ques->tick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->tick_footer.'</label>';
            								}
            								
            								
            							} else {

            								if(strcasecmp(trim(strip_tags($ques->untick_header)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_header.'</label>';
            								}

            								if(strcasecmp(trim(strip_tags($ques->untick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_footer.'</label>';
            								}
            								
            							}

            						} elseif($ques->id == 331 || $ques->id == 543 || $ques->id == 545){

            								if(strcasecmp(trim(strip_tags($ques->tick_header)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->tick_header.'</label>';
            								}

            								foreach($ques->options as $option){
	            								if(in_array($option->id, $options)){
	            									$option_row = $this->getRowData(['*'],['id' => $option->id],'options');
		            								$output .= ' <label style="display:block">'.$option_row->options.'</label><br/>';

		            								$output .= ' <label style="display:block">'.$option_row->option_answer.'</label>';
	            								}
	            							}

	            							if(strcasecmp(trim(strip_tags($ques->tick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->tick_footer.'</label>';
            								}

	            							
	            						

	            							if(strcasecmp(trim(strip_tags($ques->untick_header)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_header.'</label>';
            								}
	            							

	            							foreach($ques->options as $option){
	            								if(!in_array($option->id, $options)){
	            									$option_row = $this->getRowData(['*'],['id' => $option->id],'options');
		            								$output .= ' <label style="display:block">'.$option_row->options.'</label><br/>';
		            								
		            								$output .= ' <label style="display:block">'.$option_row->option_answer.'</label>';
	            								}
	            							}

	            							if(strcasecmp(trim(strip_tags($ques->untick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_footer.'</label>';
            								}
	            							
	            					

            						} else {
            							if(count($options)  == count($ques->options)){

            								if(strcasecmp(trim(strip_tags($ques->tick_header)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->tick_header.'</label>';
            								}


	            							if(strcasecmp(trim(strip_tags($ques->tick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->tick_footer.'</label>';
            								}

	            							
	            						} else {

	            							if(strcasecmp(trim(strip_tags($ques->untick_header)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_header.'</label>';
            								}
	            							

	            							foreach($ques->options as $option){
	            								if(!in_array($option->id, $options)){
	            									$option_row = $this->getRowData(['*'],['id' => $option->id],'options');
		            								$output .= ' <label style="display:block">'.$option_row->options.'</label>';

		            								if($ques->id == 293) {
		            									$output .= '<label style="display:block">'.$option_row->option_answer.'</label><br>';
		            								}
	            								}
	            							}

	            							if(strcasecmp(trim(strip_tags($ques->untick_footer)),'Nil')){
            									$output .= '<label style="display:block">'.$ques->untick_footer.'</label>';
            								}
	            							
	            						}
            						}
            					} else {
            						foreach($options as $option){
            							$option_row = $this->getRowData(['*'],['id' => $option],'options');

            							$bullet_image = '';

				              			/*if(!empty($option_row->option_bullet)){
							          		$path1 = base_url('assets/img/'.$option_row->option_bullet);
							          		if(file_exists('./assets/img/'.$option_row->option_bullet)){
												$type1 = pathinfo($path1, PATHINFO_EXTENSION);
												$data1 = file_get_contents($path1);
												$base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
							          			$bullet_image = '<img src="'.$base641.'" style="height:15px; position:relative;top:35px;">';
							          		}
						          		}*/

						          		if(!empty($option_row->option_header) && strcasecmp(trim(strip_tags($option_row->option_header)),'Nil')){
			          		 
			          		    if($option_row->option_bullet == 'redbullet.png'){
			          		        $bullet_image = $redbullet;
			          		    } elseif($option_row->option_bullet == 'yellowbullet.png'){
			          		        $bullet_image = $yellowbullet;
			          		    } elseif($option_row->option_bullet == 'greenbullet.png'){
			          		        $bullet_image = $greenbullet;
			          		    }
				          	$output .= '<label style="font-weight:bold; font-size:22px; color:#002ea2; padding-top:30px;">'.$bullet_image.str_replace(array("\n", "\r"), '', trim($option_row->option_header)).'</label>';
				          	}

            							if(strcasecmp(trim(strip_tags($option_row->option_answer)),'Nil')){

            								$output .='<label style="display:block">'.str_replace(array("\n", "\r"), '', trim($option_row->option_answer)).'</label>';
            							}
            							
            							//$output .= ' <label class=" ">'.$option_row->options.'</label> <br><label class=" ">'.$option_row->option_answer.'</label><br>';
            						}
            					}
            					
            					




              					/* $op = 0;
              					 foreach($ques->options as $option){
              					$multichecked = "";
              					if(!empty($opId[$op]) && $option->id == $opId[$op]){
              						$multichecked = "checked";
              					}
              					$opId = !empty($ques->answers->option_id)?explode(',',$ques->answers->option_id):'';
              					$output .= '<label class="checkbox-btn">'.$option->options.'
                				<input type="checkbox" '.$multichecked.'>
                				<span class="checkmark"></span>
             					</label>';
         						$op++;
         					} */

         					}

         					
         				}
      					
      					$output .= '</div></div>';

    					}}
      					
     				$output .= '</div>';
     				$output .= '<p style="page-break-after:always"></p>';
     				
     			}

     		}

     			$output .= '</div>';

     			return $output;
    } // end function

}

/* End of file IntegratedModel.php */
/* Location: ./application/models/IntegratedModel.php */
?>