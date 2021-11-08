<?php require_once 'header.php';

?>
<div class="btn col-lg-12">
  <span><a target="_blank" href="exam_Result_PDF" id="examPDF" class="btn btn-info btn-sm pull-right">
  View in PDF </a>
</span>
  <i class="fa fa-fighter-jet pull-left"></i>
</div>
<section class="wrapper">
    <div class="row mt">
             <div class="col-lg-12">
               <div class="content-panel">
                 <div class="table-responsive">
                   <p id="message"></p>

         <table id="resultTable" class="table table-bordered table-hover text-center  h6">
                     <thead style="color:white; background-color:black;">
                     <tr>
                     <th style="text-align:center" width="10%">Rank</th>
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
    <?php linkJS("assets/js/jquery.min.js"); ?>
    <?php linkJS("assets/js/bootstrap.min.js"); ?>
    <?php linkJS("assets/js/jquery.dataTables.min.js"); ?>
    <?php linkJS("assets/js/dataTables.bootstrap4.min.js"); ?>
    <script type="text/javascript">
    $(document).ready(function(){
      var viewResult =  $('#resultTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':$('#url').val()+'/admin/getJQueryTable',
                'data':{check:'view_Result', page:'viewResult'}
            },

            'columns': [
               { data: 'S_No'},
               { data: 'Exam_Title' },
               { data: 'User_Name' },
               { data: 'Total_Marks' },
               { data: 'Marks_Obtained' },
               { data: 'View'},
            ],

          });

          $('#viewResult').click(function(){
            viewResult.ajax.reload();
          });

    });

    </script>



</body>
</html>
