<?php

$obj = new Admin();
$result = $obj->examResultPDF();

$output = '
          <h2 style="text-align:center"> Rank wise Result </h2>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
            <thead style="color:black; ">
            <tr style="font-weight: bold;">
            <th>Rank</th>
            <th>Subject</th>
            <th>Student Name</th>
            <th>Total Marks</th>
            <th>Marks Obtained</th>
            </tr>
            </thead>
            <tbody>
';

  $count = 1;
  foreach ($result as $row) {
    $output .= '
        <tr>
          <td>'.$count.'</td>
          <td>'.$row['Exam_Title'].'</td>
          <td>'.$row['full_name'].'</td>
          <td>'.$row['Total_Marks'].'</td>
          <td>'.$row['Marks_Obtained'].'</td>
        </tr>
    ';
    $count++;
  }

  $output .= '</tbody></table>';



  $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $obj_pdf->SetTitle("Exam Result");
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);
      $obj_pdf->SetAutoPageBreak(TRUE, 10);
      $obj_pdf->SetFont('helvetica', '', 12);
      $obj_pdf->AddPage();
      $obj_pdf->writeHTML($output);
      $obj_pdf->Output('Exam_Result.pdf', 'I');
