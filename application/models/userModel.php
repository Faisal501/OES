<?php

  class userModel extends Database{

    // =================================== function to get Exam List =========================//
    	public  function get_Exam_List()
    	{
    		//data comes with dataTable plugin

                    $draw = $_POST['draw'];
                    $row = $_POST['start'];
                    $rowperpage = $_POST['length']; // Rows display per page
                    $columnIndex = $_POST['order'][0]['column']; // Column index
                    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
                    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
                    $searchValue = $_POST['search']['value']; // Search value



            // Searching from table
                    $searchQuery = " ";

                    if($searchValue != '')
                    {
                        $searchQuery = " AND (Exam_Title like '%".$searchValue."%')";
                    }


            // Total number of records without filtering
                    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examtable");

                    $records = mysqli_fetch_assoc($sql);

                    $totalRecords = $records['allcount'];


            //Total number of record with filtering
                    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examtable WHERE 1 ".$searchQuery);

                    $records = mysqli_fetch_assoc($sql);

                    $totalRecordwithFilter = $records['allcount'];


            //Fetch records
                    $Query = "SELECT * FROM examtable WHERE Exam_Status='Complete' ".$searchQuery." ORDER BY ".$columnName."
                                     ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;

                    $exams = mysqli_query($this->conn(), $Query);

                     $data = array();

            while ($row = mysqli_fetch_assoc($exams))
            {

                     $dataSub[] = array();

                    $dataSub["Exam_Title"]      =        $row['Exam_Title'];

                    $dataSub["Total_Question"]  =        $row['Total_Question'];

                    $dataSub["Duration"]        =        $row['Duration'].' min';

                    $dataSub["Date_Time"]       =        $row['Date_Time'];

                    $dataSub["MCQ"]     		=        $row['Marks_MCQ'].' marks';

                    $dataSub["DESC"]     		=        $row['Marks_Desc'].' marks';

                    $dataSub["Enroll"]        =       '<button id="'.$row['Exam_ID'].'"
    	                                                class="btn btn-outline-success btn-sm col-sm-4 enroll">
    	                                                <i class="fa fa-save">&nbsp;</i>Enroll</button>';

        			$data[] = $dataSub;

             }

            // Response to user controller

                    $response = array(

                      "draw" => intval($draw),
                      "iTotalRecords" => $totalRecords,
                      "iTotalDisplayRecords" => $totalRecordwithFilter,
                      "aaData" => $data

                    );

                        return $response;
    	}

    // =================================== function to Enroll User =========================//

    	public  function enroll_User($exam_id,$user_id)
    	{
    		try
    		{
    			$sql = "SELECT User_ID FROM enrollTable WHERE Exam_ID = ? AND User_ID = ?";
    			$stmt = $this->connect()->prepare($sql);
    			$stmt->execute([$exam_id,$user_id]);
    			$check = $stmt->fetch();

    			if(!$check)
    			{
    				$sql = "INSERT INTO enrollTable (Exam_ID,User_ID) VALUES (?,?)";
    				$stmt = $this->connect()->prepare($sql);
    				$result = $stmt->execute([$exam_id,$user_id]);
    				if($result)
    	            {
    	                $output = array
    	               (
    	                'success'   =>  'You are Enrolled for this Exam Successfully'
    	                );
    	               return $output;
    	            }
    	            else
    	            {
    	                $output = array
    	               (
    	                'error'   =>  'SomeThing went Wrong'
    	                );
    	               return $output;
    	            }
    			}
    			else
    			{
    				$output = array
    	               (
    	                'error'   =>  'You are Already Enrolled for this Exam'
    	                );
    	               return $output;
    			}



    		}
    		catch(PDOException $e)
    		{
    			echo $e->getMessage();
    		}
    	}

    // =================================== function to get enrolled exams =========================//

    	 public  function my_Exams($user_id)
        {
            $draw = $_POST['draw'];
                    $row = $_POST['start'];
                    $rowperpage = $_POST['length']; // Rows display per page
                    $columnIndex = $_POST['order'][0]['column']; // Column index
                    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
                    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
                    $searchValue = $_POST['search']['value']; // Search value

            // Searching from table
                    $searchQuery = " ";

                    if($searchValue != '')
                    {
                        $searchQuery = " AND (Exam_Title like '%".$searchValue."%' )";
                    }


            // Total number of records without filtering
        $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examtable INNER JOIN enrollTable USING (Exam_ID)");

                    $records = mysqli_fetch_assoc($sql);

                    $totalRecords = $records['allcount'];


            //Total number of record with filtering
        $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount
            FROM examtable INNER JOIN enrollTable USING (Exam_ID) WHERE 1 ".$searchQuery);

                    $records = mysqli_fetch_assoc($sql);
                    $totalRecordwithFilter = $records['allcount'];

         $Query = "SELECT e.Exam_ID,e.Exam_Title,e.Date_Time,e.Total_Question,e.Duration,q.User_ID FROM examtable e
                    INNER JOIN enrollTable q USING (Exam_ID) WHERE q.User_ID = '".$user_id."' AND e.Exam_ID = q.Exam_ID AND Attendence = 'absent'
            ".$searchQuery." ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;

                    $exams = mysqli_query($this->conn(), $Query);
                     $data = array();

            while ($row = mysqli_fetch_assoc($exams))
            {
                $dataSub[] = array();

                $dataSub["Exam_Title"]         =        $row['Exam_Title'];
                $dataSub["Date_Time"]          =        $row['Date_Time'];
                $dataSub["Total_Question"]     =        $row['Total_Question'].' questions';
                $dataSub["Duration"]           =        $row['Duration'].' min';

                $dataSub["Quit"]               =        '<button type="button" id="'.$row['Exam_ID'].'"
    	                                                 class="btn btn-outline-danger btn-sm quit">
    	                                                 <i class="fa fa-eraser">&nbsp;</i>Quit</button>';

    	        $dataSub["Start"]			   =		'<a href="paper?eid='.$row['Exam_ID'].'&uid='.$row['User_ID'].'"
    	                                                class="btn btn-outline-success btn-sm col-sm-8 start">
    	                                                <i class="fa fa-file">&nbsp;</i>Start</a>';

                $data[] = $dataSub;
            }

            // Response to admin controller

                    $response = array(
                          "draw" => intval($draw),
                          "iTotalRecords" => $totalRecords,
                          "iTotalDisplayRecords" => $totalRecordwithFilter,
                          "aaData" => $data
                    );
                        return $response;
        }

    // =================================== function to quitting from exam =========================//

        public  function quit_Exam($exam_id,$user_id)
        {
        	try
        	{
        		$sql = "DELETE FROM enrollTable WHERE Exam_ID = ? AND User_ID = ?";
        		$stmt = $this->connect()->prepare($sql);
        		$result = $stmt->execute([$exam_id,$user_id]);

        		if($result)
        		{

        			$output = array
    	               (
    	                'success'   =>  'You quitted from this Exam Successfully'
    	                );
    	               return $output;
        		}
        		else
        		{
        			$output = array
    	               (
    	                'error'   =>  'SomeThing went Wrong'
    	                );
    	               return $output;
        		}
        	}
        	catch(PDOException $e)
        	{
        		echo $e->getMessage();
        	}
        }


    // =================================== function to get user profile =========================//

        public  function update_Profile($user_id,$name,$email,$mobile,$password)
        {
        	try
        	{
        		$sql = "UPDATE users SET full_name=?,email=?,mobile=?,pass_word=? WHERE id =?";
        		$stmt = $this->connect()->prepare($sql);
        		$result = $stmt->execute([$name,$email,$mobile,$password,$user_id]);

        		if($result)
                {
                    $sql = "SELECT id,full_name,email,mobile,pass_word,category,verified FROM users WHERE id = ?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$user_id]);
                    $ret = $stmt->fetch();

                        $_SESSION['userID'] = $ret['id'];
                        $_SESSION['name'] = $ret['full_name'];
                        $_SESSION['email'] = $ret['email'];
                        $_SESSION['mobile'] = $ret['mobile'];

                    $output = array(

                        'success' => 'Profile updated Successfully'
                    );
                    return $output;
                }
                else
                {
                    $output = array(

                        'error' => 'Profile updated Successfully'
                    );
                    return $output;
                }

        	}
        	catch(PDOException $e)
        	{
        		echo $e->getMessage();
        	}
        }

    // =================================== function to start exam =========================//
        public function start_Exam($exam_id)
        {
            try
            {
                $sql = "SELECT Exam_Status,Date_Time,Duration FROM examtable WHERE Exam_ID = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id]);
                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }


    // =================================== function to start exam =========================//
        public  function add_Attendence($exam_id,$user_id)
        {
            try
            {
                $sql = "UPDATE enrollTable SET Attendence = 'Present' WHERE Exam_ID = ? AND User_ID = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id,$user_id]);

                $sql = "SELECT Exam_ID,Question_ID FROM questiontable WHERE Exam_ID = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id]);
                $result = $stmt->fetchAll();

                foreach($result as $row){
                  $sql = "SELECT Exam_ID,User_ID,Question_ID FROM resultTable
                  WHERE Exam_ID = ? AND User_ID = ? AND Question_ID = ?";
                  $stmt = $this->connect()->prepare($sql);
                  $stmt->execute([$row['Exam_ID'],$user_id,$row['Question_ID']]);
                  $result = $stmt->fetchAll();

                  if(!$result){
                    $sql = "INSERT INTO resultTable (Exam_ID,User_ID,Question_ID) VALUES ( ?,?,?)";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$row['Exam_ID'],$user_id,$row['Question_ID']]);
                  }

                }


            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting first question =========================//
        public  function first_Question($exam_id)
        {
            try
            {
                $sql = "SELECT * FROM questiontable WHERE Exam_ID = ? ORDER BY Question_ID ASC LIMIT 1";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting more question =========================//

        public  function get_More_Question($question_id)
        {
            try
            {
                $sql = "SELECT * FROM questiontable WHERE Question_ID = ? ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$question_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting options =========================//
        public  function get_Options($question_id)
        {
            try
            {
                $sql = "SELECT * FROM optiontable WHERE Question_ID = ? ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$question_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting previous question id =========================//
        public  function get_Previous_Question($exam_id,$Question_ID)
        {
            try
            {
                $sql = "SELECT Question_ID FROM questiontable
                        WHERE Question_ID < ? AND Exam_ID = ? ORDER BY Question_ID DESC LIMIT 1 ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Question_ID,$exam_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting next question  =========================//
        public  function get_Next_Question($exam_id,$Question_ID)
        {
            try
            {
                $sql = "SELECT Question_ID FROM questiontable
                        WHERE Question_ID > ? AND Exam_ID = ? ORDER BY Question_ID ASC LIMIT 1 ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Question_ID,$exam_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== getting navigation button   =========================//
        public  function get_Question_Navigation($exam_id)
        {
            try
            {
                $sql = "SELECT Question_ID FROM questiontable
                        WHERE Exam_ID = ? ORDER BY Question_ID ASC ";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id]);

                $result = $stmt->fetchAll();

                return $result;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    // =================================== adding answer  =========================//

        public function save_Answer($exam_id,$user_id,$question_id,$answer)
        {
            try
            {
                    $sql = "UPDATE resultTable SET User_Answer = ?
                            WHERE Exam_ID=? AND User_ID=? AND Question_ID=?";
                    $stmt = $this->connect()->prepare($sql);
                    $result1 = $stmt->execute([$answer,$exam_id,$user_id,$question_id]);

                        if($result1)
                        {
                            $output = array(

                                         'success' => 'Added'
                                            );
                            return $output;
                        }
                        else
                        {
                            $output = array(

                                         'success' => 'not Added'
                                            );
                            return $output;
                        }

            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    		// =============================================== checked option ======================

    			public  function get_Checked_Option($question_id,$user_id)
    			{
    				try
    				{
    					$sql = "SELECT User_Answer FROM resultTable WHERE Question_ID = ? AND User_ID = ?";
    					$stmt = $this->connect()->prepare($sql);
    					$stmt->execute([$question_id,$user_id]);
    					$result = $stmt->fetchAll();

    					return $result;

    				}
    				catch (PDOException $e)
    				{
    					echo $e->getMessage();
    				}

    			}
    // ================================ finish paper =======================================
    			public  function finish_Paper($exam_id)
    			{
    				try
    				{
    						$sql = "UPDATE examtable SET Exam_Status = 'Complete' WHERE Exam_ID = ?";
    						$stmt = $this->connect()->prepare($sql);
    						$result = $stmt->execute([$exam_id]);

    						if($result)
    						{
    							$response = array(
    								'success' => 'status changed'
    							);
    							return $response;
    						}

    				} catch (PDOException $e) {
    					echo $e->getMessage();
    				}

    			}

// ================================ end exam =======================================
			public  function end_Exam($exam_id,$user_id)
			{
				try
				{
						$sql = "SELECT COUNT(R_ID) AS total FROM resultTable WHERE Exam_ID = ? AND User_ID = ?";
						$stmt = $this->connect()->prepare($sql);
						$stmt->execute([$exam_id,$user_id]);
            $result = $stmt->fetch();
            $total = $result['total'];

            $sql = "SELECT COUNT(User_Answer) AS attempt FROM resultTable WHERE Exam_ID = ? AND User_ID = ? AND User_Answer IS NOT NULL";
            $stmt = $this->connect()->prepare($sql);
						$stmt->execute([$exam_id,$user_id]);
            $result = $stmt->fetch();
            $attempt = $result['attempt'];

            return ['total' => $total, 'attempt' => $attempt];

				} catch (PDOException $e) {
					echo $e->getMessage();
				}

			}

// =================================== checking Exam time to start =========================//

    public function check_Exam_Time()
    {
        try
        {
            $sql = " SELECT Exam_ID,Date_Time,Duration,Exam_Status FROM examTable";
            $stmt = $this->connect()->query($sql);
            $result = $stmt->fetchAll();

            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// =================================== start exam =========================//
    public function start_Exam_Time($exam_id)
    {
        try
        {
            $sql = "UPDATE examTable SET Exam_Status='Started' WHERE Exam_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$exam_id]);

            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// =================================== ending exam =========================//
    public function end_Exam_Time($exam_id)
    {
        try
        {
            $sql = "UPDATE examTable SET Exam_Status='Complete' WHERE Exam_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$exam_id]);

            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// ========================================== usermodel ends here =========================
  }
