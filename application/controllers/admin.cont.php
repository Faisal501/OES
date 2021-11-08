<?php

  class Admin extends Online_Exam_Sys{

    public function __construct(){
      $this->helper("link");
      $this->adminModel = $this->model('adminModel');
      $this->resultModel = $this->model('resultModel');
    }
    public function index(){
      $this->view("adminIndex");
    }

    public function logout(){
      $this->unsetSession('userID');
      $this->unsetSession('name');
      $this->destroy();
      $this->redirect("admin");
    }

// =============================== nav bar view functions ====================
    public function admin(){
        if(isset($_GET['check'])){
          if($_GET['check'] == 'admin'){
            $this->view("admin/admin");
          }else if($_GET['check'] == 'questionBank'){
            $this->view("admin/questionBank");
          }else if($_GET['check'] == 'viewUser'){
            $this->view("admin/viewUser");
          }else if($_GET['check'] == 'prepareResult'){
            $this->view("admin/prepareResult");
          }else if($_GET['check'] == 'viewResult'){
            $this->view("admin/viewResult");
          }else{
            $this->logout();
          }
       }
   }
//============================ view functions ======================================
   public function quizBank(){
     $this->view('admin/quizBank');
   }
   // ================================ enrolled users view =====================
    public function enrollUser(){
      $this->view("admin/enrollUser");
    }
    // ================================ enrolled users view =====================
     public function enrolledUser(){
       $this->view("admin/enrolledUser");
     }
     // ================================ enrolled users view =====================
      public function marking(){
        $this->view("admin/marking");
      }
      //============================ single result ================================
      public function singleUser_Result(){
        $this->view("admin/singleUser_Result");
      }
      //============================ single_Result_PDF ==========================
      public function single_Result_PDF(){
        $this->view("admin/single_Result_PDF");
      }
      //===================== exam result ==============================
      public function exam_Result_PDF(){
        $this->view("admin/exam_Result_PDF");
      }

// ============= main exam table ==========================================
   public function getJQueryTable(){

     if($_POST['check'] == 'tableData')
     {
         if ($_POST['page'] == 'admin')
         {
             $exams = $this->adminModel->get_Table_Data();
             echo json_encode($exams);
         }
     }
     // ===================== question of all exams ==============
     if ($_POST['check'] == 'quizBankTableData')
     {
         if ($_POST['page'] == 'quizBank')
         {
             $result = $this->adminModel->get_AllExam_TableData();
             echo json_encode($result);
         }
     }
     // ===================== question of single exam ==============
     if ($_POST['check'] == 'questionTableData')
     {
         if ($_POST['page'] == 'quizBank')
         {
             $exam_id = $_POST['exam_id'];
             $sub = $_POST['subject'];
             $result = $this->adminModel->get_Exam_TableData($exam_id,$sub);
             echo json_encode($result);
         }
     }
// ===================== registered users ==============
     if($_POST['check'] == 'regUsersTableData')
     {
       if($_POST['page'] == 'viewUser')
       {
         $regUsers = $this->adminModel->get_Reg_Users();
         echo json_encode($regUsers);
       }
     }
     // =================== enrolled exam table ===================================
      if($_POST['check'] == 'enrollExamTableData')
      {
        if($_POST['page'] == 'enrollUser')
        {
          $regUsers = $this->adminModel->get_Enroll_Exam();
          echo json_encode($regUsers);
        }
      }
      // =================== enrolled users table ===================================
       if($_POST['check'] == 'enrollUserTableData')
       {
         if($_POST['page'] == 'enrolledUser')
         {
           $exam_id = $_POST['exam_id'];
           $enrollUsers = $this->adminModel->get_Enroll_User($exam_id);
           echo json_encode($enrollUsers);
         }
       }
       // =================== view result===================================
       if($_POST['check'] == 'view_Result')
       {
         if($_POST['page'] == 'viewResult')
         {
           $result = $this->resultModel->view_Exam_Result();
           echo json_encode($result);
         }
       }

  }


// ================================== create exam ====================================
   public function addExam(){

     if($_POST['check'] == 'Add')
     {
         if($_POST['page'] == 'admin')
         {
             $title = $_POST['title'];
             $dateTime = $_POST['examDatetime'];
             $duration = $_POST['duration'];
             $totalQuestion = $_POST['totalQuestion'];
             $marks = $_POST['marks'];
             $descMarks = $_POST['descMarks'];
             $adminID = $this->getSession('userID');
              $msg = $this->adminModel->addTo_ExamTable($adminID,$title,$dateTime,$totalQuestion,$duration,$marks,$descMarks);
             echo json_encode($msg);
         }
     }

     // =============================  editing exam ==================================

     if($_POST['check'] == 'EditDone')
     {
         if($_POST['page'] == 'admin')
         {
                 $exam_id = $_POST['Exam_id'];
                 $title = $_POST['title'];
                 $dateTime = $_POST['examDatetime'];
                 $duration = $_POST['duration'];
                 $totalQuestion = $_POST['totalQuestion'];
                 $marks = $_POST['marks'];
                 $descMarks = $_POST['descMarks'];
                 $msg = $this->adminModel->edit_ExamTable($title,$dateTime,$totalQuestion,$duration,$marks,$descMarks,$exam_id);
                 echo json_encode($msg);
         }
     }

}

// ============================= getting exam to edit =======================//
   public function editExam(){
     if($_POST['check'] == 'edit')
     {
         if ($_POST['page'] == 'admin')
         {
             $exam_id = $_POST['exam_id'];
             $data = $this->adminModel->edit_Exam($exam_id);
             echo json_encode($data);
         }
     }

   }

  // ============================= deleting exam =======================//
   public function deleteExam(){
     if($_POST['check'] == 'delete')
     {
         if ($_POST['page'] == 'admin')
         {
             $exam_id = $_POST['exam_id'];
             $data = $this->adminModel->delete_Exam($exam_id);
             echo json_encode($data);
         }
     }
   }

// ============================== add question ===========================
   public function addQuestion(){
     // ==================== adding mcq =====================
     if ($_POST['check'] == 'addQuestion')
     {
         if ($_POST['page'] == 'admin')
         {

                 $exam_id = $_POST['exam_id'];
                 $type = $_POST['quest_type'];
                 $question = $_POST['question'];
                 $optA = $_POST['optionA'];
                 $optB = $_POST['optionB'];
                 $optC = $_POST['optionC'];
                 $optD = $_POST['optionD'];
                 $answer = $_POST['correct'];

                 $data = $this->adminModel->add_Mcq_Question($exam_id,$question,$optA,$optB,$optC,$optD,$answer,$type);

            echo json_encode($data);
         }
     }
     // ======================== adding desc question ========================
     if ($_POST['check'] == 'addQuestion_desc')
     {
         if ($_POST['page'] == 'admin')
         {
               $exam_id = $_POST['exam_id_desc'];
               $type = $_POST['quest_type'];
               $question = $_POST['question_desc'];
               $answer = 'DESC';

               $data = $this->adminModel->add_Desc_Question($exam_id,$question,$answer,$type);

            echo json_encode($data);
         }
     }
     // ====================== editing mcq ==================================
     if ($_POST['check'] == 'Edit_Quest_Done')
     {
         if ($_POST['page'] == 'quizBank')
         {

             $question_id = $_POST['question_id'];
             $question = $_POST['question'];
             $optA = $_POST['optionA'];
             $optB = $_POST['optionB'];
             $optC = $_POST['optionC'];
             $optD = $_POST['optionD'];
             $answer = $_POST['correct'];

             $data = $this->adminModel->edit_Mcq_Question($question_id,$question,$optA,$optB,$optC,$optD,$answer);
             echo json_encode($data);
         }
     }
     // ========================= editing desc question ===========================
     if ($_POST['check'] == 'Edit_Quest_Desc')
     {
         if ($_POST['page'] == 'quizBank')
         {
             $question_id = $_POST['question_id_desc'];
             $question = $_POST['question_desc'];

             $data = $this->adminModel->edit_Desc_Question($question_id,$question);
             echo json_encode($data);
         }
     }


  }

// ========================= edit question =================================
   public function editQuestion(){
     // ================================ getting mcq =====================
     if($_POST['check'] == 'edit_quest')
     {
         if ($_POST['page'] == 'admin')
         {
             $question_id = $_POST['question_id'];
             $data = $this->adminModel->get_Question_Mcq($question_id);
             echo json_encode($data);
         }
     }
     // ================================ getting desc question =====================
     if($_POST['check'] == 'edit_quest_desc')
     {
         if ($_POST['page'] == 'admin')
         {
             $question_id = $_POST['question_id'];
             $data = $this->adminModel->get_Question_Desc($question_id);
             echo json_encode($data);
         }
     }

   }

// ================================ deleting question =====================
   public function deleteQuestion(){

     if($_POST['check'] == 'Delete_Quest')
     {
         if($_POST['page'] == 'quizBank')
         {
             $question_id = $_POST['question_id'];
             $exam_id = $_POST['exam_id'];
             $data = $this->adminModel->delete_Question($question_id,$exam_id);
             echo json_encode($data);
         }
     }

   }

// ================================ prepare result ============================
   public function result(){

     if($_POST['check'] == 'result')
     {
       if($_POST['page'] == 'prepareResult')
       {
         $result = $this->adminModel->prepare_Result();
         echo json_encode($result);
       }
     }
     // ========================== get paper for marking =========================
     if($_POST['check'] == 'result')
     {
       if($_POST['page'] == 'marking')
       {
         $exam_id = $_POST['exam_id'];
         $user_id = $_POST['user_id'];

         $result = $this->adminModel->mark_Paper($exam_id,$user_id);
         echo json_encode($result);
       }
     }
     //============================= add marking ================================
     if($_POST['check'] == 'marks')
     {
       if($_POST['page'] == 'marking')
       {
         $marks = $_POST['marks'];
         $question_id = $_POST['question_id'];
         $exam_id = $_POST['exam_id'];
         $user_id = $_POST['user_id'];

         $result = $this->adminModel->add_Marks($marks,$question_id,$exam_id,$user_id);
         echo json_encode($result);
       }
     }
     // ============================================ save marks ====================
     if($_POST['check'] == 'saveMarked')
     {
       if($_POST['page'] == 'marking')
       {
         $total = $_POST['total'];
         $obtained = $_POST['obtained'];
         $exam_id = $_POST['exam_id'];
         $user_id = $_POST['user_id'];

         $result = $this->adminModel->save_Marks($total,$obtained,$exam_id,$user_id);
         echo json_encode($result);
       }
     }
     //=========================== single result web =========================
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

// ====================================  user result PDF ==========================================
   public function singleResultPDF($exam_id,$user_id){
     $result = $this->resultModel->single_Result_PDF($exam_id,$user_id);
     return $result;
   }
// ====================================  exam resutl PDF ==========================================
   public function examResultPDF(){
     $result = $this->resultModel->exam_Result_PDF();
     return $result;
   }
// ====================================  controller ends here ==========================================
  }




 ?>
