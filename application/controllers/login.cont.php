<?php

  class Login extends Online_Exam_Sys{

    public function __construct(){
      $this->helper("link");
      $this->loginModel = $this->model('loginModel');
    }

    public function index(){
      $this->view("index");
    }
// =================================function for registration =================================
    public function register(){

      if(isset($_POST['check']))
      {
      	if($_POST['check'] == 'R')
      	{
      		$fullname = $_POST['full-name'];
      		$email = $_POST['emailR'];
      		$mobile = $_POST['mobile'];
      		$pass = $_POST['password2'];
      		$cat = $_POST['category'];

          //echo "i am here";
           //v_key generation
      		 $v_key = md5(time($mobile));
      		 $verified = "NO";
      		 $password = password_hash($pass, PASSWORD_DEFAULT);

           $check = $this->loginModel->check($email,$mobile);

           if( $check == 'valid')
      		{
            //================== sending mail after validation ===========================
            $mail = new PHPMailer;

            //$mail->SMTPDebug = 3;          // Enable verbose debug output

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com;';
            $mail->SMTPAuth = true;
            $mail->Username = 'myprojectcs619@gmail.com';
            $mail->Password = 'whwkwcqxscrfavia';
            $mail->Port = 25;

            $mail->setFrom('myprojectcs619@gmail.com', 'ProjectCS619');
            $mail->addAddress($email, $fullname);     // Add a recipient

            $mail->isHTML(true);                     // Set email format to HTML

            $mail->Subject = 'Account Verification';
            $mail->Body    = "<p>Thank for registering with online examination <a href='http://localhost/OES/loginController/verify?v_key=$v_key&check=v'>
            click here</a> to LOG IN</p>";
            $mail->AltBody = "Thank for registering with online examination <a href='http://localhost/projectCS619/loginController/verify?v_key=$v_key&check=v'>
            click here</a> to LOG IN";

            if(!$mail->send())
            {
              echo $mail->ErrorInfo;
            }else{

              $result = $this->loginModel->registerUser($fullname,$email,$mobile,$password,$cat,$verified,$v_key);

              echo json_encode($result);
            }

      		}
      		else
      		{
      			echo json_encode($check);
      		}
      	}
      }
    }

// ================================= login function for user and user ==============================
public function login(){
      if(isset($_POST['check']))
      {
      	if($_POST['check'] == 'L')
      	{

      		$email = $_POST['email'];
      		$pass = $_POST['password'];
      		$result = $this->loginModel->login($email,$pass);

          if (password_verify($pass, $result['pass_word']))
          {
            if(($result['verified'] == "YES") && ($result['category'] == "admin"))
            {
              $this->setSession('userID',$result['id']);
              $this->setSession('name',$result['full_name']);


              $response = array(

              'success' => 'admin'
              );
              echo json_encode($response);


            }
            elseif(($result['verified'] == "YES") && ($result['category'] == "user"))
            {
              $this->setSession('userID',$result['id']);
              $this->setSession('name',$result['full_name']);
              $this->setSession('email',$result['email']);
              $this->setSession('mobile',$result['mobile']);              

              $response = array(

              'success' => 'user'
              );
              echo json_encode($response);
            }
            else
            {
              $response = array(

              'error' => 'notVerified'
              );
              echo json_encode($response);
            }
          }
          else
          {
            $response = array(

              'error' => 'incorrect'
              );
              echo json_encode($response);
          }


        //  echo "login";
      	}
      }
    }


// =============================== Verification of new registered user ========================
public function verify(){
    if(isset($_GET['v_key'])){
      if($_GET['check'] == 'v'){
        $v_key = $_GET['v_key'];
        $result = $this->loginModel->verifiedUser($v_key);

        if($result == 'verified'){
          $this->redirect('?check=v');
        }else if($result == 'already_verified'){
          $this->redirect('?check=ad');
        }else{
          $this->redirect('?check=ia');
        }
      }
    }
}









  }




 ?>
