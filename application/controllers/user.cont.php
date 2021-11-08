<?php

class User extends Online_Exam_Sys
{
  public function __construct(){
    $this->helper("link");
    $this->userModel = $this->model('userModel');
    $this->resultModel = $this->model('resultModel');
  }

  public function index(){
    $this->view("index");
  }

  public function logout(){
    $this->unsetSession('userID');
    $this->unsetSession('name');
    $this->unsetSession('email');
    $this->unsetSession('mobile');
    $this->destroy();
    $this->redirect("login");
  }

// ===================== function for user views ========================
  public function users(){

      $check = $_GET['check'];

      if($check == 'index'){
        $this->view("users/index");
      }elseif ($check == 'myexam') {
        $this->view("users/myexam");
      }elseif ($check == 'result') {
        $this->view("users/result");
      }elseif ($check == 'profile') {
        $this->view("users/profile");
      }else {
        $this->logout();
      }

}

  public function user_Result(){
    $this->view("users/user_Result");
  }
  public function user_Result_PDF(){
    $this->view("users/user_Result_PDF");
  }

// =============================== checking time for start paper ============================
   public function checkExamTime(){
     if($_POST['check'] == 'checkExamTime')
     {
         if($_POST['page'] == 'user')
         {
           date_default_timezone_set("Asia/Karachi");

           $current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
           $current_time = strtotime($current_datetime);
           $result = $this->userModel->check_Exam_Time();

           $exam_datetime = '';
           $start = '';
           $over = '';
           $status = '';
           foreach ($result as $row)
           {
               $exam_id = $row['Exam_ID'];
               $exam_datetime = $row['Date_Time'];
               $duration = $row['Duration'] . 'minute';
               $status = $row['Exam_Status'];
               $exam_star_time = strtotime($exam_datetime);
               $exam_end_time = strtotime($exam_datetime .'+'.  $duration);

               if($current_time < $exam_end_time &&  $current_time >= $exam_star_time && $status != 'Started')
               {
                   $start = $this->userModel->start_Exam_Time($exam_id);
               }
               if($current_time > $exam_end_time && $status != 'Over')
               {
                   $over = $this->userModel->end_Exam_Time($exam_id);
               }
           }

           $output['date_time'] = $exam_datetime;
           $output['current_datetime'] = $current_datetime;
           $output['Started'] = $start;
           $output['Over'] = $over;

             echo json_encode($output);
         }
     }
   }
// ============================= controller for getting exam List from database =======================//
  public function getExamList(){

      if($_POST['check'] == 'examList')
      {
      	if($_POST['page'] == 'userIndex')
      	{
      		$examList = $this->userModel->get_Exam_List();
      		echo json_encode($examList);
      	}
      }

  }

// ============================= controller for enrollment =======================//
  public function enroll(){

      if($_POST['check'] == 'enroll')
      {
      	if($_POST['page'] == 'userIndex')
      	{
      		$exam_id = $_POST['exam_id'];
          $user_id = $this->getSession('userID');
      		$result = $this->userModel->enroll_User($exam_id,$user_id);
      		echo json_encode($result);
      	}
      }
}

// ============================= controller for enrolled exams =======================//
  public function myExams(){

      if($_POST['check'] == 'myExams')
      {
      	if($_POST['page'] == 'myexam')
      	{
          $user_id = $this->getSession('userID');
      		$myExam = $this->userModel->my_Exams($user_id);
      		echo json_encode($myExam);
      	}
      }

}


// ============================= controller for quitting exam =======================//
  public function quitExam(){

      if($_POST['check'] == 'quit')
      {
      	if($_POST['page'] == 'myexam')
      	{
      		$user_id = $this->getSession('userID');
          $exam_id = $_POST['exam_id'];
      		$result = $this->userModel->quit_Exam($exam_id,$user_id);
      		echo json_encode($result);
      	}
      }
}

  // ============================= controller for updating profile =======================//
  public function updateProfile(){

        if(($_POST['check']) == 'updateProfile')
        {
        	if($_POST['category'] == 'user')
        	{
        		$user_id = $_POST['user_id'];
        		$name = $_POST['full-name'];
        		$email = $_POST['email'];
        		$mobile = $_POST['mobile'];
        		$pass = $_POST['password'];
            $password = password_hash($pass, PASSWORD_DEFAULT);
        		$result = $this->userModel->update_Profile($user_id,$name,$email,$mobile,$password);
        		echo json_encode($result);
        	}
        }
}

// ============================= view user =======================//
  public function paper(){
    $this->view("users/paper");
  }
// ============================= start exam =======================//
  public function startExam(){

          if($_POST['check'] == 'startPaper')
          {
          	if($_POST['page'] == 'paper')
          	{
          		$exam_id = $_POST['exam_id'];
          		$user_id = $_POST['user_id'];

              $result = $this->userModel->start_Exam($exam_id);

          		$exam_status = '';
              $output = array();
          		foreach($result as $row)
          		{
          			date_default_timezone_set("Asia/Karachi");

          			$exam_status = $row['Exam_Status'];
          			$output['duration'] = $row['Duration'] . ' minute';
          			$exam_star_time = $row['Date_Time'];
          			$duration = $row['Duration'] . 'minute';
          			$exam_end_time = strtotime($exam_star_time .'+'.  $duration);
                $time = $exam_end_time;
          			$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
          			$remaining_minutes = strtotime($exam_end_time) - time();
          			$output['remaining_time'] = $remaining_minutes;
          		}

          		if($exam_status == 'Started')
          		{
          			$this->userModel->add_Attendence($exam_id,$user_id);
                echo json_encode($output);
          		}
          		//elseif($exam_status == 'Over')
              elseif($time < time())
          		{
          			$response = array(

          				'error' => 'Exam Time is Over'
          			);

          			echo json_encode($response);
          		}
          		elseif($time > time())
          		{
          			$response = array(

          				'error' => 'Exam not started Yet'
          			);

          			echo json_encode($response);
          		}
          	}
          }
}

// ============================function to load the question on paper page================================
  public function loadQuestion(){

        if(isset($_POST['action'])){

        	if($_POST['check'] == 'paper'){

        		$output = '';

        	if($_POST['action'] == 'load_question'){

        		$exam_id = $_POST['exam_id'];
        		$question_id = $_POST['question_id'];

        		if($_POST['question_id'] == ''){
        			$result = $this->userModel->first_Question($exam_id);
        		}
        		else{
        			$result = $this->userModel->get_More_Question($question_id);
        		}

        		foreach ($result as $row){
        			$output .= '
        				<div class="quest" style="background-color:#e8eaed; padding:1%;">

                <div class="form-group">
                  <label for="inputAddress">Question:</label>
                  <textarea class="form-control question" id="'.$row['Question_ID'].' rows="3" readonly>'.$row["Question"].'</textarea>
                </div>
        				<hr/>
        				';
        			$Question_ID = $row['Question_ID'];

        		if($row['Question_Type'] == 'DESC'){
        			$output .=
        						'
        			<div class="col-lg-12" style="margin-bottom:10px; margin-top:20px;">
        			<textarea name="answer" class="form-control desc_answer" rows="5"></textarea>
        			</div>
        						';
        		}
        		else{
        			$options = $this->userModel->get_Options($Question_ID);

        			foreach ($options as $sub_row ){
        				$output .=
        						'
        					<div class="col-lg-12" style="margin-bottom:32px; margin-top:50px;">
        					<div class="radio">
                  <h4>
                  <div class="form-row">
                      <input type="text" class="form-control col-md-5" id="Option_A" value="'.$sub_row["Option_A"].'" readonly/>
                      <input type="radio" name="answer" value="A" class="col-md-1 answer"/>
                      <input type="text" class="form-control col-md-5" id="Option_B" value="'.$sub_row["Option_B"].'" readonly/>
                      <input type="radio" name="answer" value="B" class="col-md-1 answer"/>
                  </div></br>
                  <div class="form-row">
                      <input type="text" class="form-control col-md-5" id="Option_C" value="'.$sub_row["Option_C"].'" readonly/>
                      <input type="radio" name="answer" value="C" class="col-md-1 answer"/>
                      <input type="text" class="form-control col-md-5" id="Option_D" value="'.$sub_row["Option_D"].'" readonly/>
                      <input type="radio" name="answer" value="D" class="col-md-1 answer"/>
                  </div></h4>
        					</div>
        					</div>

        						';
        			}

        		}
        			$previous_question = $this->userModel->get_Previous_Question($exam_id,$Question_ID);
        			$previous_id = '';
        			$next_id = '';

        				foreach($previous_question as $previous)
        				{
        					$previous_id = $previous['Question_ID'];
        				}

        			$next_question = $this->userModel->get_Next_Question($exam_id,$Question_ID);

        				foreach($next_question as $next)
        				{
        					$next_id = $next['Question_ID'];
        				}

        				$if_previous_disable = '';
        				$if_next_disable = '';

        				if($previous_id == "")
        				{
        					$if_previous_disable = 'disabled';
        				}

        				if($next_id == "")
        				{
        					$if_next_disable = 'disabled';
        				}

        		$output .= '

        		  	<div align="right"><hr/>
        					<button type="button" name="previous" class="btn btn-primary btn-sm col-sm-1 previous"
        					id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
        					<button type="button" name="next" class="btn btn-primary btn-sm col-sm-1 next"
        					id="'.$next_id.'" '.$if_next_disable.'>Next</button>
                  <input type="submit" class="btn btn-danger btn-sm col-sm-1 save" value="SAVE" disabled/>
        		  	</div>
        		  			';
        		}
        	}
          // ======================== question navigation ==============================
        	if($_POST['action'] == 'question_navigation')
        	{
        		$result = $this->userModel->get_Question_Navigation($_POST['exam_id']);

        		$count = 1;
        			foreach($result as $row)
        			{
        				$output .= '

        			<button type="button" class="btn btn-primary btn-sm question_navigation" id="'.$row["Question_ID"].'">
        			'.$count.'</button>

        							';
        				$count++;
        			}

        		$output .= '
        			</div>
        					';
        	}

        	echo $output;
          }
        }
        // ========================= getting user checked options ======================
        if(isset($_POST['checked']))
        {
        		if($_POST['check'] == 'paper')
        		{
        		$question_id = $_POST['question_id'];
            $user_id = $this->getSession('userID');
        		$result = $this->userModel->get_Checked_Option($question_id,$user_id);
            $option = '';
      			foreach ($result as $row)
      			{
      				$option = $row['User_Answer'];
      			}
        		echo json_encode($option);
        	}
        }

}

// =================================  save answer =================================
public function saveAnswer(){

        if(isset($_POST['answer']))
        {
        	if($_POST['check'] == 'paper')
        	{
        		if($_POST['action'] == 'save_answer')
        		{

        			$question_id = $_POST['question_id'];
        			$answer = $_POST['answer'];
        			$exam_id = $_POST['exam_id'];
        			$user_id = $this->getSession('userID');

        			$result = $this->userModel->save_Answer($exam_id,$user_id,$question_id,$answer);
        			echo json_encode($result);
        		}
        	}
        }
        // =========================== save desc answer ===============================
        if(isset($_POST['desc_answer']))
        {
        	if($_POST['check'] == 'paper')
        	{
        		if($_POST['action'] == 'save_answer')
        		{
        				$question_id = $_POST['question_id'];
        				$answer = $_POST['desc_answer'];
        				$exam_id = $_POST['exam_id'];
        				$user_id = $this->getSession('userID');

        			$result = $this->userModel->save_Answer($exam_id,$user_id,$question_id,$answer);
        			echo json_encode($result);
        		}
        	}
        }

}

// ============================= end exam ==================================
public function endExam(){
      if($_POST['page'] == 'paper')
      {
        if($_POST['check'] == 'endPaper')
        {
            $exam_id = $_POST['exam_id'];
            $user_id = $this->getSession('userID');

          $result = $this->userModel->end_Exam($exam_id,$user_id);
          echo json_encode($result);
        }
      }
      // =============================== finish paper =====================
      if(isset($_POST['action']))
      {
      	if($_POST['check'] == 'finishPaper')
      	{
      		$exam_id = $_POST['exam_id'];
      		$result = $this->userModel->finish_Paper($exam_id);
      		echo json_encode($result);
      	}
      }
}

// ======================================= view result =======================
   public function result(){

     	if($_POST['check'] == 'view_Result')
     	{
     		if($_POST['page'] == 'result')
     		{
     			$user_id = $this->getSession('userID');
     			$result = $this->resultModel->user_Exam_Result($user_id);
     			echo json_encode($result);
     		}
     	}
      //=============== single result web ================================
      if($_POST['check'] == 'singleResult')
      {
        if($_POST['page'] == 'single_Result')
        {
          $exam_id = $_POST['exam_id'];
          $user_id = $_POST['user_id'];
          $result = $this->resultModel->view_Single_Result($exam_id,$user_id);
          echo json_encode($result);
        }
      }
   }
// ================================== single result PDF user ============================
   public function singleResultPDF($exam_id,$user_id){
     $result = $this->resultModel->single_Result_PDF($exam_id,$user_id);
     return $result;
   }

//========================================= user controller ends here ============================
}



 ?>
