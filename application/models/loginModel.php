<?php
class loginModel extends Database
{

  public function registerUser($fullname,$email,$mobile,$pass,$cat,$verified,$v_key)
  {

    try
    {
      $sql = "INSERT INTO users (full_name, email, mobile, pass_word, category, verified, v_key) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->connect()->prepare($sql);
      $chk = $stmt->execute([$fullname,$email,$mobile,$pass,$cat,$verified,$v_key]);

      if($chk)
      {
        $response = array(

          'success' => 'Please check your email to verify your Account'
        );
        return $response;
      }

    }
    catch (PDOException $e)
    {

      echo $e->getMessage();
    }
  }

  public function check($email,$mobile)
  {
    try
    {
      $sql = "SELECT email,mobile FROM users WHERE email = ? OR  mobile = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$email,$mobile]);
      $result = $stmt->fetch();



      if($result['email'] == $email)
      {
        $response = array(

          'error' => 'Email Already Exists'
        );
        return $response;
      }
      if($result['mobile'] == $mobile)
      {
        $response = array(

          'error' => 'Mobile number Already Exists'
        );
        return $response;
      }
      if(($result['email'] != $email) && ($result['mobile'] != $mobile))
      {
        return "valid";
      }


    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  public function login($email,$pass)
  {
    try
    {
      $sql = "SELECT id,full_name,email,mobile,pass_word,category,verified FROM users WHERE email = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$email]);
      $result = $stmt->fetch();

      return $result;


    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  public function verifiedUser($v_key)
  {
    try
    {
      $sql = "SELECT verified,v_key FROM users WHERE v_key = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$v_key]);
      $result = $stmt->fetch();

      if (($result['v_key'] == $v_key) && ($result['verified'] == "NO"))
      {

        $sql = "UPDATE users SET verified = 'YES' WHERE v_key = ?";
        $stmt = $this->connect()->prepare($sql);
        $result = $stmt->execute([$v_key]);

        if($result)
        {
          return "verified";
        }
      }
      elseif (($result['v_key'] == $v_key) && ($result['verified'] == "YES"))
      {
        return "already_verified";
      }
      else
      {
        return "invalid_key";
      }
    }
    catch (PDOException $e)
    {
      echo $e->getMessage();
    }
  }
}
 ?>
