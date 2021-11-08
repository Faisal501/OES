<?php require_once 'header.php';

?>
<section class="wrapper">
    <div class="row mt">
             <div class="col-lg-12">
               <div class="content-panel">
                 <div class="table-responsive">
                   <p id="message"></p>

         <table id="resultTable" class="table table-bordered table-hover text-center  h6">
                     <thead style="color:white; background-color:black;">
                     <tr>
                     <th style="text-align:center" width="10%">S.No</th>
                     <th style="text-align:center" width="20%">Exam_Title</th>
                     <th style="text-align:center" width="30%">User_Name</th>
                     <th style="text-align:center" width="15%">Total_Marks</th>
                     <th style="text-align:center" width="15%">Marks_Obtained</th>
                     <th style="text-align:center" width="10%">View</th>
                     </tr>
                     </thead>
                     <tbody>

                     </tbody>
                   </table>
                 </div>
               </div><!-- /content-panel -->
             </div><!-- /col-lg-4 -->
           </div><!-- /row -->
           <input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</section>
<!-- ################################################ Scripts#######################################################-->



<?php require_once 'footer.php'; ?>
