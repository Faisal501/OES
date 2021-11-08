<?php

  class adminModel extends Database{

    public function addTo_ExamTable($adminID,$title,$dateTime,$totalQuestion,$duration,$marks,$descMarks)
    {
        try
        {
            $sql = "INSERT INTO examtable (Admin_ID,Exam_Title,Date_Time,Total_Question,Duration,Marks_MCQ,Marks_Desc)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $chk = $stmt->execute([$adminID,$title,$dateTime,$totalQuestion,$duration,$marks,$descMarks]);

            if($chk)
            {
                $output = array
               (
                'success'   =>  'Exam Added successfully'
                );
               return $output;
            }
            else
            {
                $output = array
               (
                'success'   =>  'SomeThing is Wrong'
                );
               return $output;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

    }


    // ============================= function to fetch data of exam ==========================//

    public function get_Table_Data()
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
                $Query = "SELECT * FROM examtable WHERE 1 ".$searchQuery." ORDER BY ".$columnName."
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

                $dataSub["Exam_Status"]     =        $row['Exam_Status'];

            if($row['Exam_Status'] == 'Started')
            {
                $dataSub["exam"]  =      '<button type="button" id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-info btn-sm col-sm-4 disabled">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>'.' '.

                                                '<button type="button" id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-danger btn-sm col-sm-4 disabled">
                                                 <i class="fa fa-trash">&nbsp;</i>Delete</button>';

                $dataSub["question"]         =       '<button id="'.$row['Exam_ID'].'"
                                                class="btn btn-outline-dark btn-sm col-sm-4 disabled">
                                                <i class="fa fa-save">&nbsp;</i>Add</button>'.' '.

                                            '<a href="quizBank?id='.$row['Exam_ID'].'&sub='.$row['Exam_Title'].'"
                                                class="btn btn-outline-success btn-sm col-sm-4 disabled">
                                                <i class="fa fa-file">&nbsp;</i>View</a>';
            }
            else
            {

                $dataSub["exam"]            =        '<button type="button" id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-info btn-sm col-sm-4 edit">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>'.' '.

                                             '<button type="button" id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-danger btn-sm col-sm-4 delete">
                                                 <i class="fa fa-trash">&nbsp;</i>Delete</button>';

                $dataSub["question"]         =       '<button id="'.$row['Exam_ID'].'"
                                                class="btn btn-outline-dark btn-sm col-sm-4 add">
                                                <i class="fa fa-save">&nbsp;</i>Add</button>'.' '.

                                            '<a href="quizBank?id='.$row['Exam_ID'].'&sub='.$row['Exam_Title'].'"
                                                class="btn btn-outline-success btn-sm col-sm-4 view">
                                                <i class="fa fa-file">&nbsp;</i>View</a>';
            }

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

// ============================= function to fetch data to exam ==========================//
    public function edit_Exam($exam_id)
    {
        $sql = "SELECT * FROM examtable WHERE Exam_ID =  ? ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$exam_id]);

        $result = $stmt->fetchAll();


            foreach($result as $row)
            {
                $output['Exam_ID'] = $row['Exam_ID'];

                $output['Exam_Title'] = $row['Exam_Title'];

                $output['Date_Time'] = $row['Date_Time'];

                $output['Duration'] = $row['Duration'];

                $output['Total_Question'] = $row['Total_Question'];

                $output['Marks_MCQ'] = $row['Marks_MCQ'];

                $output['Marks_Desc'] = $row['Marks_Desc'];
            }

            return $output;
    }

// ============================= function for edited exam ==========================//

    public function edit_ExamTable($title,$dateTime,$totalQuestion,$duration,$marks,$descMarks,$exam_id)
    {
        try
        {
            $sql =  "UPDATE examtable SET Exam_Title=?, Date_Time=?, Total_Question=?, Duration=?, Marks_MCQ=?, Marks_Desc=?
                WHERE Exam_ID=?";

            $stmt= $this->connect()->prepare($sql);
            $check = $stmt->execute([$title,$dateTime,$totalQuestion,$duration,$marks,$descMarks,$exam_id]);

            if ($check)
            {

               $output = array
               (
                'success'   =>  'Exam Details has been changed'
                );
               return $output;

            }
            else
            {

                $output = array
               (
                'success'   =>  'SomeThing is Wrong with Details'
                );
               return $output;

            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    // =================================== deleting exam =========================//

    public function delete_Exam($exam_id)
    {
        try
        {

            $sql ="DELETE FROM examtable WHERE Exam_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$exam_id]);

            if($result)
            {
                $output = array
                (
                    'success' => 'Exam Deleted successfully'
                );
                return $output;
            }
            else
            {
                $output = array
                (
                    'success' => 'Record Not deleted'
                );
                return $output;
            }

        }
        catch(PDOException $e)
        {
           echo $e->getMessage();
        }
    }

// =================================== Adding Question Mcqs=========================//

    public function add_Mcq_Question($exam_id,$question,$optA,$optB,$optC,$optD,$answer,$type)
    {
        try
        {
                $sql = " SELECT Exam_ID FROM questiontable WHERE Exam_ID = '".$exam_id."' ";
                $stmt = $this->connect()->query($sql);
                $addedQuest = $stmt->rowCount();
                    $added = (int)$addedQuest;
                $sql = " SELECT Total_Question AS noOfQuestion FROM examtable WHERE Exam_ID = '".$exam_id."'";
                $stmt = $this->connect()->query($sql);
                $noOfQuest = $stmt->fetch();

                    $toAdd =(int)$noOfQuest['noOfQuestion'];

                if($added == $toAdd)
                {
                    $output = array
                    (
                        'error' => 'All Questions Already Added'
                    );
                        return $output;
                }
                else
                {

                    $sql = "INSERT INTO questiontable (Exam_ID,Question,Answer,Question_Type) VALUES (?, ?, ?, ?)";
                    $stmt = $this->connect()->prepare($sql);
                    $check = $stmt->execute([$exam_id,$question,$answer,$type]);

                        if ($check)
                        {
                            $sql = "SELECT Question_ID FROM questiontable ORDER BY Question_ID DESC LIMIT 1";
                            $stmt = $this->connect()->query($sql);
                            $result = $stmt->fetch();

                            $questionID = $result['Question_ID'];

                            $sql = "INSERT INTO optiontable (Question_ID,Option_A,Option_B,Option_C,Option_D)
                                        VALUES(?, ?, ?, ?, ?)";
                            $stmt = $this->connect()->prepare($sql);
                            $chk = $stmt->execute([$questionID,$optA,$optB,$optC,$optD]);

                            $remaining = $toAdd - $added - 1;
                            if($remaining == 0)
                            {
                                $sql = "UPDATE examTable SET Exam_Status='Complete' WHERE Exam_id=?";
                                $stmt = $this->connect()->prepare($sql);
                                $check = $stmt->execute([$exam_id]);
                                if($check)
                                {
                                    $output = array
                                    (
                                        'success' => 'Question Added successfully  :  no more Question to Add'
                                    );
                                        return $output;
                                }
                            }
                            else
                            {
                              $output = array
                                (
                                    'success' => 'Question Added successfully  :" '.$remaining.' " more Questions to Add'
                                );
                                    return $output;
                            }
                        }

                }

        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// =================================== Adding Question Descriptive=========================//

public function add_Desc_Question($exam_id,$question,$answer,$type)
{
    try
    {
        $sql = " SELECT Exam_ID FROM questiontable WHERE Exam_ID = '".$exam_id."' ";
                $stmt = $this->connect()->query($sql);
                $addedQuest = $stmt->rowCount();
                    $added = (int)$addedQuest;
                $sql = " SELECT Total_Question AS noOfQuestion FROM examtable WHERE Exam_ID = '".$exam_id."'";
                $stmt = $this->connect()->query($sql);
                $noOfQuest = $stmt->fetch();

                    $toAdd =(int)$noOfQuest['noOfQuestion'];

                if($added == $toAdd)
                {
                    $output = array
                    (
                        'error' => 'All Questions Already Added'
                    );
                        return $output;
                }
                else
                {
                    $sql = "INSERT INTO questiontable (Exam_ID,Question,Answer,Question_Type) VALUES (?, ?, ?, ?)";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$exam_id,$question,$answer,$type]);

                            $remaining = $toAdd - $added - 1;
                            if($remaining == 0)
                            {
                                $sql = "UPDATE examTable SET Exam_Status='Complete' WHERE Exam_id=?";
                                $stmt = $this->connect()->prepare($sql);
                                $check = $stmt->execute([$exam_id]);

                                if($check)
                                {
                                        $output = array
                                    (
                                        'success' => 'Question Added successfully  :  no more Question to Add'
                                    );
                                        return $output;
                                }
                            }
                            else
                            {
                              $output = array
                                (
                                    'success' => 'Question Added successfully  :" '.$remaining.' " more Questions to Add'
                                );
                                    return $output;
                            }
                }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

    // ===================================Fetching Particular Exam Questions =========================//

    public function get_Exam_TableData($exam_id,$subject)
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
                    $searchQuery = " AND (Question like '%".$searchValue."%' OR Question_Type like '%".$searchValue."%' )";
                }


        // Total number of records without filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM questiontable");

                $records = mysqli_fetch_assoc($sql);

                $totalRecords = $records['allcount'];


        //Total number of record with filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount
        FROM questiontable WHERE Exam_ID = '".$exam_id."' ".$searchQuery);

                $records = mysqli_fetch_assoc($sql);
                $totalRecordwithFilter = $records['allcount'];

                //Fetch records
        $Query = "SELECT * FROM questiontable WHERE Exam_ID = '".$exam_id."' ".$searchQuery."
        ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;


                $exams = mysqli_query($this->conn(), $Query);
                 $data = array();

        while ($row = mysqli_fetch_assoc($exams))
        {
            $dataSub[] = array();

            $dataSub["Subject"]         =        $subject;

            $dataSub["Question"]        =        $row['Question'];

            $dataSub["Question_Type"]   =        $row['Question_Type'];

            if($row['Question_Type'] == 'MCQ')
            {

            $dataSub["edit_btn"]        =        '<button type="button" id="'.$row['Question_ID'].'"
                                                 class="btn btn-outline-info btn-sm edit_quest">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>';
            }
            else
            {
               $dataSub["edit_btn"]        =        '<button type="button" id="'.$row['Question_ID'].'"
                                                 class="btn btn-outline-warning btn-sm edit_quest_desc">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>';
            }

            $dataSub["delete_btn"]      =        '<button type="button" id="'.$row['Question_ID'].'"
                                                  data-id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-danger btn-sm delete_quest">
                                                 <i class="fa fa-eraser">&nbsp;</i>Delete</button>';
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


// ===================================Fetching All Exam Questions =========================//

    public function get_AllExam_TableData()
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
                    $searchQuery = " AND (Question like '%".$searchValue."%' OR Exam_Title like '%".$searchValue."%' )";
                }


        // Total number of records without filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examtable INNER JOIN questiontable USING (Exam_ID)");

                $records = mysqli_fetch_assoc($sql);

                $totalRecords = $records['allcount'];


        //Total number of record with filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount
        FROM examtable INNER JOIN questiontable USING (Exam_ID) WHERE 1 ".$searchQuery);

                $records = mysqli_fetch_assoc($sql);
                $totalRecordwithFilter = $records['allcount'];

     $Query = "SELECT e.Exam_ID,e.Exam_Title,q.Question,q.Question_Type,q.Question_ID FROM examtable e
                INNER JOIN questiontable q USING (Exam_ID) WHERE e.Exam_ID = q.Exam_ID
        ".$searchQuery." ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;

                $exams = mysqli_query($this->conn(), $Query);
                 $data = array();

        while ($row = mysqli_fetch_assoc($exams))
        {
            $dataSub[] = array();

            $dataSub["Subject"]         =        $row['Exam_Title'];

            $dataSub["Question"]        =        $row['Question'];

            $dataSub["Question_Type"]   =        $row['Question_Type'];

            if($row['Question_Type'] == 'MCQ')
            {

            $dataSub["edit_btn"]        =        '<button type="button" id="'.$row['Question_ID'].'"
                                                 class="btn btn-outline-info btn-sm edit_quest">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>';
            }
            else
            {
               $dataSub["edit_btn"]     =        '<button type="button" id="'.$row['Question_ID'].'"
                                                 class="btn btn-outline-warning btn-sm edit_quest_desc">
                                                 <i class="fa fa-edit">&nbsp;</i>Edit</button>';
            }

            $dataSub["delete_btn"]      =        '<button type="button" id="'.$row['Question_ID'].'"
                                                  data-id="'.$row['Exam_ID'].'"
                                                 class="btn btn-outline-danger btn-sm delete_quest">
                                                 <i class="fa fa-eraser">&nbsp;</i>Delete</button>';
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



    // =================================== function to get mcq question to edit =========================//

    public function get_Question_Mcq($question_id)
    {
        try
        {
            $sql = "SELECT q.Question,o.Option_A,o.Option_B,o.Option_C,o.Option_D,q.Answer
                    FROM questiontable q INNER JOIN optiontable o USING (Question_ID)
                    WHERE q.Question_ID = ? AND o.Question_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$question_id,$question_id]);
            $result = $stmt->fetchAll();

            foreach ($result as $row)
            {
                $output['Question'] = $row['Question'];
                $output['Option_A'] = $row['Option_A'];
                $output['Option_B'] = $row['Option_B'];
                $output['Option_C'] = $row['Option_C'];
                $output['Option_D'] = $row['Option_D'];
                $output['Answer'] = $row['Answer'];
            }
            return $output;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// =================================== function to get desc question to edit =========================//

public function get_Question_Desc($question_id)
{
    try
        {
            $sql = "SELECT Question, Question_Type FROM questiontable WHERE Question_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$question_id]);
            $result = $stmt->fetchAll();

            foreach ($result as $row)
            {
                $output['Question'] = $row['Question'];
                $output['Question_Type'] = $row['Question_Type'];
            }
            return $output;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
}
    // =================================== function to edit mcq question =========================//

    public function edit_Mcq_Question($question_id,$question,$optA,$optB,$optC,$optD,$answer)
    {
        try
        {
            $sql = " UPDATE questiontable q INNER JOIN optiontable o USING (Question_ID)
                    SET q.Question = ? , q.Answer = ? , o.Option_A = ? , o.Option_B = ? , o.Option_C = ? , o.Option_D = ?
                    WHERE q.Question_ID = ? AND o.Question_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$question,$answer,$optA,$optB,$optC,$optD,$question_id,$question_id]);

            if ($result)
            {
                $response = array(

                    'success' => 'Question Updated successfully'
                );
                return $response;
            }
            else
            {
                $response = array(

                    'success' => 'SomeThing Wrong with Database'
                );
                return $response;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

// =================================== function to edit desc  question =========================//

    public function edit_Desc_Question($question_id,$question)
    {
        try
        {
            $sql = " UPDATE questiontable SET Question = ? WHERE Question_ID = ? ";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$question,$question_id]);

            if ($result)
            {
                $response = array(

                    'success' => 'Question Updated successfully'
                );
                return $response;
            }
            else
            {
                $response = array(

                    'success' => 'SomeThing Wrong with Database'
                );
                return $response;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
// =================================== function to delete question =========================//

    public function delete_Question($question_id,$exam_id)
    {
        try
        {
            $sql = "DELETE FROM questiontable WHERE Question_ID = ?";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([$question_id]);

            if($result)
            {
                $sql = "UPDATE examTable SET Exam_Status='Pending' WHERE Exam_ID=?";
                $stmt = $this->connect()->prepare($sql);
                $check = $stmt->execute([$exam_id]);

                if($check)
                {
                    $response = array(

                    'success' => 'Question deleted successfully'
                    );

                    return $response;
                }
                else
                {
                    $response = array(

                        'success' => 'SomeThing is Wrong with database'
                    );

                    return $response;
                }

            }
            else
            {
                $response = array(

                    'success' => 'SomeThing is Wrong with database'
                );

                return $response;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
// ================================== reg users ==========================
    public function get_Reg_Users()
    {
      try
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
            $searchQuery = " AND (id like '%".$searchValue."%' OR full_name like '%".$searchValue."%' )";
        }


        // Total number of records without filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM users");

                $records = mysqli_fetch_assoc($sql);

                $totalRecords = $records['allcount'];


        //Total number of record with filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM users WHERE 1 ".$searchQuery);

                $records = mysqli_fetch_assoc($sql);
                $totalRecordwithFilter = $records['allcount'];

     $Query = "SELECT * FROM users WHERE category = 'user'
        ".$searchQuery." ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;

                $exams = mysqli_query($this->conn(), $Query);
                 $data = array();

        while ($row = mysqli_fetch_assoc($exams))
        {
            $dataSub[] = array();

            $dataSub["ID"]         =        $row['id'];
            $dataSub["Full-Name"]  =        $row['full_name'];
            $dataSub["Email"]      =        $row['email'];
            $dataSub["Mobile"]     =        $row['mobile'];
            $dataSub["Verified"]   =        $row['verified'];

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
      catch (PDOException $e)
      {
          echo $e-getMessage();
      }

    }
//=================================== reg user ends here ==========================
// ================================== Enrolled users ==========================
    public function get_Enroll_Exam()
    {
      try
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
            $searchQuery = " AND (Exam_ID like '%".$searchValue."%' OR Exam_Title like '%".$searchValue."%' )";
        }


        // Total number of records without filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examTable");

                $records = mysqli_fetch_assoc($sql);

                $totalRecords = $records['allcount'];


        //Total number of record with filtering
    $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM examTable WHERE 1 ".$searchQuery);

                $records = mysqli_fetch_assoc($sql);
                $totalRecordwithFilter = $records['allcount'];

     $Query = "SELECT * FROM examTable WHERE 1 ".$searchQuery." ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;
                $exams = mysqli_query($this->conn(), $Query);
                 $data = array();

        while ($row = mysqli_fetch_assoc($exams))
        {
            $dataSub[] = array();

            $dataSub["Exam_ID"]        =        $row['Exam_ID'];
            $dataSub["Exam_Title"]     =        $row['Exam_Title'];
            $dataSub["Time"]           =        $row['Date_Time'];
            $dataSub["Enrolled_Users"] =        '<a href="enrolledUser?enroll_id='.$row['Exam_ID'].'&sub='.$row['Exam_Title'].'"
                                                    class="btn btn-outline-success btn-sm enrolledUser">
                                                    <i class="fa fa-file">&nbsp;</i>View Users</a>';
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
      catch (PDOException $e)
      {
          echo $e-getMessage();
      }

    }

// ================================== enrolled users ==========================
        public function get_Enroll_User($exam_id)
        {
          try
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
                $searchQuery = " AND (id like '%".$searchValue."%' OR full_name like '%".$searchValue."%' )";
            }
            // Total number of records without filtering
            $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM users ");

                    $records = mysqli_fetch_assoc($sql);

                    $totalRecords = $records['allcount'];


            //Total number of record with filtering
            $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM users WHERE 1 ".$searchQuery);

                    $records = mysqli_fetch_assoc($sql);
                    $totalRecordwithFilter = $records['allcount'];

            $Query = "SELECT e.Exam_ID,e.User_ID,u.id,u.full_name,u.email FROM enrolltable e
                    INNER JOIN users u  WHERE e.Exam_ID = '".$exam_id."' AND e.User_ID = u.id
            ".$searchQuery." ORDER BY '".$columnSortOrder."' LIMIT ".$row.",".$rowperpage;

                    $exams = mysqli_query($this->conn(), $Query);
                     $data = array();

            while ($row = mysqli_fetch_assoc($exams))
            {
                $dataSub[] = array();

                $dataSub["User_ID"]         =        $row['id'];
                $dataSub["Name"]            =        $row['full_name'];
                $dataSub["Email"]           =        $row['email'];

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
          catch (PDOException $e)
          {
              echo $e-getMessage();
          }

        }


// ==================================  prepare result ========================
        public function prepare_Result()
        {
          try
          {
            $sql = "SELECT r.Exam_ID,r.User_ID FROM
            resulttable AS r INNER JOIN enrolltable AS en
            WHERE r.Exam_ID = en.Exam_ID AND r.User_ID = en.User_ID AND en.Marking = 'No' GROUP BY(en.User_ID)";
            $stmt = $this->connect()->query($sql);
            $result = $stmt->fetchAll();

            $totalQuestion = '';
            $data = array();
            foreach ($result as $rows) {

              $exam_id = $rows['Exam_ID'];
              $user_id = $rows['User_ID'];

              $sql = "SELECT COUNT(R_ID) AS totalQuestion FROM resultTable WHERE Exam_ID = ? AND User_ID = ?";
              $stmt = $this->connect()->prepare($sql);
              $stmt->execute([$exam_id,$user_id]);
              $no = $stmt->fetch();
              $totalQuestion = $no['totalQuestion'];

              $sql = "SELECT e.Exam_ID,e.Exam_Title,u.id,u.full_name FROM examTable
              AS e INNER JOIN users AS u WHERE e.Exam_ID =? AND u.id = ?";
              $stmt = $this->connect()->prepare($sql);
              $stmt->execute([$exam_id,$user_id]);
              $result = $stmt->fetchAll();

              foreach ($result as $row) {
                $sub_data = array();
                $sub_data['Total_Question'] = $totalQuestion;
                $sub_data['Exam_Title'] = $row['Exam_Title'];
                $sub_data['User_Name'] = $row['full_name'];
                $sub_data['Marking'] = '<a href="marking?exam_id='.$row['Exam_ID'].'&user_id='.$row['id'].'&exam_title='.$row['Exam_Title'].'"
                                        class="btn btn-outline-success btn-sm marking">
                                              <i class="fa fa-file">&nbsp;</i>Mark Paper</a>';

                $data[] = $sub_data;
              }

            }

              return $data;


          } catch (PDOException $e) {
            $e->getMessage();
          }

        }
// ==================================  mark paper ========================

  public function mark_Paper($exam_id,$user_id)
  {
    try
    {
      $sql = "SELECT q.Question,q.Answer,q.Question_Type,
      r.Question_ID,r.User_Answer,r.Marks_Obtained,
      e.Exam_Title,e.Marks_MCQ,e.Marks_DESC
      from questiontable as q inner join resulttable as r
      on q.Question_ID = r.Question_ID AND r.Exam_ID = ? AND r.User_ID = ?
      inner join examtable as e ON e.Exam_ID = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$exam_id,$user_id,$exam_id]);
      $result = $stmt->fetchAll();

      $output = array();
      $marks = 0;
      foreach ($result as $row)
      {
        $sub_data = array();

        $sub_data['Exam_Title'] = $row['Exam_Title'];
        $sub_data['Question'] = $row['Question'];
        $sub_data['Answer'] = $row['Answer'];
        $sub_data['User_Answer'] = $row['User_Answer'];

        if($row['Question_Type'] == 'DESC')
        {
          $sub_data['Total_Marks'] = $row['Marks_DESC'];
          $marks_Desc =   $row['Marks_DESC'];
        }
        else
        {
          $sub_data['Total_Marks'] = $row['Marks_MCQ'];
          $marks_Mcq =   $row['Marks_MCQ'];
        }

        if($row['Answer'] == $row['User_Answer'] && $row['Question_Type'] == 'MCQ')
        {
          $sub_data['Marks_Obtained'] ='<input type ="number" id="marks'.$row['Question_ID'].'" value="'.$marks_Mcq.'"
          name="marks" min="0" max="'.$marks_Mcq.'" disabled/>';
          $sub_data['Save'] = '<input type="button" id="'.$row['Question_ID'].'"
          class="btn btn-success btn-sm save_marks" value="Save"/>';
        }

        else if($row['Answer'] != $row['User_Answer'] && $row['Question_Type'] == 'MCQ')
        {
          $sub_data['Marks_Obtained'] ='<input type ="number" id="marks'.$row['Question_ID'].'" value="0"
          name="marks" min="0" max="'.$marks_Mcq.'" disabled/>';
          $sub_data['Save'] = '<input type="button" id="'.$row['Question_ID'].'"
          class="btn btn-success btn-sm save_marks" value="Save"/>';
        }


        else
        {
          $sub_data['Marks_Obtained'] ='<input type ="number" id="marks'.$row['Question_ID'].'"
          name="marks" min="0" max="'.$marks_Desc.'"/>';
          $sub_data['Save'] = '<input type="button" id="'.$row['Question_ID'].'"
          class="btn btn-success btn-sm save_marks" value="Save"/>';
        }

        $output[] = $sub_data;
      }
      return $output;

    } catch (PDOException $e) {
      $e->getMessage();
    }

  }


// =============================== adding marks ===================================
public function add_Marks($marks,$question_id,$exam_id,$user_id)
{
  try
  {
    $sql = "UPDATE resultTable SET Marks_Obtained = ? WHERE Exam_ID = ? AND User_ID = ? AND Question_ID = ? ";
    $stmt = $this->connect()->prepare($sql);
    $result = $stmt->execute([$marks,$exam_id,$user_id,$question_id]);

    if($result)
    {
      $response = array(
        'success' => 'Marks added'
      );
    }
    else {
      $response = array(
        'error' => 'SomeThing wrong'
      );
    }

    return $response;

    } catch (PDOException $e) {
    $e->getMessage();
  }

}

// =============================== adding marks ===================================
    public function save_Marks($total,$obtained,$exam_id,$user_id)
    {
      try
      {
        $sql = "UPDATE enrollTable SET Marking = 'Yes' WHERE Exam_ID = ? AND User_ID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$exam_id,$user_id]);


        $sql = "INSERT INTO historyTable (User_ID,Exam_ID,Total_Marks,Marks_Obtained) VALUES(?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $result = $stmt->execute([$user_id,$exam_id,$total,$obtained]);

        if($result)
        {
          $response = array(
            'success' => 'marking saved'
          );
          return $response;
        }
        else
        {
            $response = array(
              'error' => 'SomeThing wrong'
            );
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
      }

    }





  }



 ?>
