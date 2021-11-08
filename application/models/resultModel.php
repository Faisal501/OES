<?php
  class resultModel extends Database{
//============================================ exam result PDF ==================
    public function exam_Result_PDF()
    {
      try {
        $sql = "SELECT h.*,e.Exam_Title,u.full_name FROM historytable as h
        INNER JOIN examtable AS e ON h.Exam_ID = e.Exam_ID
        INNER JOIN users AS u ON h.User_ID = u.id ORDER BY h.Marks_Obtained DESC";
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchALL();
        return $result;

      } catch (PDOException $e) {
        echo $e->getMessage();
      }

    }
// ============================= student result PDF ======================================
    public function single_Result_PDF($exam_id,$user_id)
    {
        try
        {
          $sql = "SELECT e.Exam_Title,q.Question,q.Answer,
                  r.User_Answer,r.Marks_Obtained AS Single_Marks,
                  h.Total_Marks,h.Marks_Obtained,u.full_name
                from questiontable as q inner join resulttable as r
                on q.Question_ID = r.Question_ID AND r.Exam_ID = ? AND r.User_ID = ?
                inner join examtable as e ON e.Exam_ID = ? inner join historytable as h on h.Exam_ID = ? AND h.User_ID = ?
                inner join users as u ON u.id = ?";

                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$exam_id,$user_id,$exam_id,$exam_id,$user_id,$user_id]);
                $result = $stmt->fetchAll();
                return $result;


        } catch (PDOException $e) {
          $e->getMessage();
        }

    }

// ======================================= view exam resuult ====================
      public function view_Exam_Result()
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
              $searchQuery = " AND (Exam_Title like '%".$searchValue."%' OR full_name like '%".$searchValue."%' )";
            }
            // Total number of records without filtering
            $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM historyTable AS h INNER JOIN examTable AS e
            INNER JOIN users AS u ON h.User_ID = u.id ");

                  $records = mysqli_fetch_assoc($sql);

                  $totalRecords = $records['allcount'];


            //Total number of record with filtering
            $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM historyTable AS h INNER JOIN examTable AS e
            INNER JOIN users AS u ON h.User_ID = u.id WHERE 1".$searchQuery);

                  $records = mysqli_fetch_assoc($sql);
                  $totalRecordwithFilter = $records['allcount'];

            $Query = "SELECT h.*,e.Exam_Title,u.full_name FROM historytable AS h INNER JOIN examtable AS e
            ON h.Exam_ID = e.Exam_ID INNER JOIN users AS u ON h.User_ID = u.id
            ".$searchQuery." ORDER BY h.Marks_Obtained DESC LIMIT ".$row.",".$rowperpage;

                  $exams = mysqli_query($this->conn(), $Query);
                   $data = array();
                   $count = 1;
            while ($row = mysqli_fetch_assoc($exams))
            {
              $dataSub[] = array();

              $dataSub["S_No"]         =        $count;
              $dataSub["Exam_Title"]   =        $row['Exam_Title'];
              $dataSub["User_Name"]    =        $row['full_name'];
              $dataSub["Total_Marks"]  =        $row['Total_Marks'];
              $dataSub["Marks_Obtained"]    =   $row['Marks_Obtained'];
              $dataSub["View"]         =        '<a href="singleUser_Result?exam_id='.$row['Exam_ID'].'&user_id='.$row['User_ID'].'"
                                                class="btn btn-outline-success btn-sm view">
                                                  <i class="fa fa-file">&nbsp;</i>View</a>';
              $data[] = $dataSub;
              $count++;
            }

            // Response to admin controller

                  $response = array(
                        "draw" => intval($draw),
                        "iTotalRecords" => $totalRecords,
                        "iTotalDisplayRecords" => $totalRecordwithFilter,
                        "aaData" => $data
                  );
                      return $response;
        } catch (PDOException $e) {
          $e->getMessage();
        }

      }

// =====================================  single result web  ===============================
      public function view_Single_Result($exam_id,$user_id)
      {
          try
          {
            $sql = "SELECT e.Exam_Title,q.Question,q.Question_Type,q.Answer,
                    r.User_Answer,r.Marks_Obtained AS Single_Marks,
                    h.Total_Marks,h.Marks_Obtained
                  from questiontable as q inner join resulttable as r
                  on q.Question_ID = r.Question_ID AND r.Exam_ID = ? AND r.User_ID = ?
                  inner join examtable as e ON e.Exam_ID = ? inner join historytable as h on h.Exam_ID = ? AND h.User_ID = ?";

                  $stmt = $this->connect()->prepare($sql);
                  $stmt->execute([$exam_id,$user_id,$exam_id,$exam_id,$user_id]);
                  $result = $stmt->fetchAll();

                  $output = array();
                  foreach ($result as $row)
                  {
                    $sub_data = array();

                    $sub_data['Exam_Title'] = $row['Exam_Title'];
                    $sub_data['Question'] = $row['Question'];
                    $sub_data['Type'] = $row['Question_Type'];
                    $sub_data['Answer'] = $row['Answer'];
                    $sub_data['User_Answer'] = $row['User_Answer'];
                    $sub_data['Marks'] = $row['Single_Marks'];
                    $sub_data['Total_Marks'] = $row['Total_Marks'];
                    $sub_data['Marks_Obtained'] = $row['Marks_Obtained'];

                    $output[] = $sub_data;
                  }
                  return $output;


          } catch (PDOException $e) {
            $e->getMessage();
          }

      }

// ======================================= user exam resuult web ====================
        public function user_Exam_Result($user_id)
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
                $searchQuery = " AND (Exam_Title like '%".$searchValue."%' OR full_name like '%".$searchValue."%' )";
              }
              // Total number of records without filtering
              $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM historyTable AS h INNER JOIN examTable AS e
              INNER JOIN users AS u ON h.User_ID = u.id ");

                    $records = mysqli_fetch_assoc($sql);

                    $totalRecords = $records['allcount'];


              //Total number of record with filtering
              $sql = mysqli_query($this->conn(),"SELECT COUNT(*) AS allcount FROM historyTable AS h INNER JOIN examTable AS e
              INNER JOIN users AS u ON h.User_ID = u.id WHERE 1 ".$searchQuery);

                    $records = mysqli_fetch_assoc($sql);
                    $totalRecordwithFilter = $records['allcount'];

              $Query = "SELECT h.*,e.Exam_Title,u.full_name FROM historytable AS h INNER JOIN examtable AS e
              ON h.Exam_ID = e.Exam_ID INNER JOIN users AS u WHERE h.User_ID = ".$user_id." AND u.id = ".$user_id."
              ".$searchQuery." ORDER BY h.Marks_Obtained DESC LIMIT ".$row.",".$rowperpage;

                    $exams = mysqli_query($this->conn(), $Query);
                     $data = array();
                     $count = 1;
              while ($row = mysqli_fetch_assoc($exams))
              {
                $dataSub[] = array();

                $dataSub["S_No"]         =        $count;
                $dataSub["Exam_Title"]   =        $row['Exam_Title'];
                $dataSub["User_Name"]    =        $row['full_name'];
                $dataSub["Total_Marks"]  =        $row['Total_Marks'];
                $dataSub["Marks_Obtained"]    =   $row['Marks_Obtained'];
                $dataSub["View"]         =        '<a href="user_Result?exam_id='.$row['Exam_ID'].'&user_id='.$row['User_ID'].'"
                                                  class="btn btn-outline-success btn-sm view">
                                                    <i class="fa fa-file">&nbsp;</i>View</a>';
                $data[] = $dataSub;
                $count++;
              }

              // Response to admin controller

                    $response = array(
                          "draw" => intval($draw),
                          "iTotalRecords" => $totalRecords,
                          "iTotalDisplayRecords" => $totalRecordwithFilter,
                          "aaData" => $data
                    );
                        return $response;
          } catch (PDOException $e) {
            $e->getMessage();
          }

        }
//===================================== class ends here =======================================================
}



 ?>
