<?php require_once 'header.php';

  $exam_id = $_GET['enroll_id'];
  $subject = $_GET['sub'];

?>
<section class="wrapper">
  <h3 align="center" class="text-danger">List of Enrolled Users For : <?php echo $subject; ?></h3>
  <input type="hidden" id="enroll_id" value="<?php echo $exam_id; ?>">
    <div class="row mt">
             <div class="col-lg-12">
               <div class="content-panel">
                 <div class="table-responsive">
                   <p id="message"></p>

         <table id="enrollUserTable" class="table table-bordered table-hover text-center  h6">
                     <thead style="color:white; background-color:black;">
                     <tr>
                     <th style="text-align:center" width="33%">User_ID</th>
                     <th style="text-align:center" width="33%">Name</th>
                     <th style="text-align:center" width="33%">Email</th>
                     </tr>
                     </thead>
                     <tbody>

                     </tbody>
                   </table>
                 </div>
               </div><!-- /content-panel -->
             </div><!-- /col-lg-4 -->
           </div><!-- /row -->
</section>
<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
<?php include_once 'footer.php';?>
