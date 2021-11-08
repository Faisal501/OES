<?php


$exam_id = $_GET['exam_id'];
$user_id = $_GET['user_id'];

$obj = new User();
$result = $obj->singleResultPDF($exam_id,$user_id);
$name = '';
$total = '';
$obtained = '';

  foreach ($result as $row) {
    $total = $row['Total_Marks'];
    $obtained = $row['Marks_Obtained'];
    $name = $row['full_name'];
    $title = $row['Exam_Title'];
  }
  $output = '
            <h2 style="text-align:center;">RESULT : '.$title.'</h2>
            <div>
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr style="font-weight: bold;">
            <td>STUDENT ID      </td><td align="center"><b>'.$user_id.'</b></td>
            </tr>
            <tr style="font-weight: bold;">
            <td>STUDENT NAME    </td><td align="center"><b>'.$name.'</b></td>
            </tr>
            <tr style="font-weight: bold;">
            <td>TOTAL MARKS     </td><td align="center"><b>'.$total.'</b></td>
            </tr>
            <tr style="font-weight: bold;">
            <td>MARKS OBTAINED  </td><td align="center"><b>'.$obtained.'</b></td>
            </tr>
            </table>
            </div>
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
              <thead style="color:black;">
              <tr style="font-weight: bold;">
              <th style="width:40%">Question</th>
              <th style="width:10%">Answer</th>
              <th style="width:41%">User Answer</th>
              <th style="width:9%">Marks</th>
              </tr>
              </thead>
              <tbody>
  ';


    foreach ($result as $row) {

      $output .= '
          <tr>
          <td style="width:40%">'.$row['Question'].'</td>
          <td style="width:10%">'.$row['Answer'].'</td>
          <td style="width:41%">'.$row['User_Answer'].'</td>
          <td style="width:9%;text-align:right;">'.$row['Single_Marks'].'</td>
          </tr>
      ';

    }

    $output .= '
                </tbody>
                <tr >
                  <td colspan="2" align="center"></td>
                  <td colspan="1" align="center"><h3>Total</h3></td>
                  <td colspan="1" align="right"><h3>'.$obtained.'</h3></td>
                </tr>
                </table>

                ';

  $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $obj_pdf->SetTitle("User Result");
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);
      $obj_pdf->SetAutoPageBreak(TRUE, 10);
      $obj_pdf->SetFont('helvetica', '', 12);
      $obj_pdf->AddPage();
      $obj_pdf->writeHTML($output);
      $obj_pdf->Output('user_Result.pdf', 'I');
