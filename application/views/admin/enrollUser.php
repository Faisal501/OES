<?php require_once 'header.php';

?>

<section class="wrapper">
 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <p id="message"></p>
    <table id="enrollExamTable" class="table table-bordered table-hover text-center  h6">
                <thead style="color:white; background-color:black;">
                <tr>
                <th style="text-align:center" width="10%">Exam_ID</th>
                <th style="text-align:center" width="40%">Subject</th>
                <th style="text-align:center" width="30%">Time</th>
                <th style="text-align:center" width="20%">Enrolled_Users</th>
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
<?php include_once 'footer.php';?>
