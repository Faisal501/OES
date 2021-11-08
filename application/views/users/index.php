<?php require_once 'header.php';

?>

<section class="wrapper">
<!-- ====================================  Exam list Table ======================================================== -->
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <p id="message"></p>
    <table id="examList" class="table table-bordered table-hover text-center">
                <thead style="color:white; background-color:black;">
                <tr>
                <th style="text-align:center" width="20%">Exam Title</th>
                <th style="text-align:center" width="10%">Questions</th>
                <th style="text-align:center" width="10%">Duration</th>
                <th style="text-align:center" width="15%">Date Time</th>
                <th style="text-align:center" width="10%">MCQ Marks</th>
                <th style="text-align:center" width="10%">DESC Marks</th>
                <th style="text-align:center" width="20%">Enroll</th>
                </tr>
                </thead>

                <tbody>

                </tbody>
              </table>
            </div>
          </div><!-- /content-panel -->
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->

<!-- ====================================  Exan list Table ======================================================== -->

<!-- ====================================  enroll Modal ======================================================== -->
<div class="modal fade" id="enrollModal">
    <div class="modal-dialog">
      <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Confirmation For Enrollment</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <fieldset>
            <h5 align="center" class="text-danger">Are you sure you want to Enroll for this Exam ?</h5>
            <hr/>
            <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>
            <button type="button" name="enrollButton" id="enrollButton"
                    class="btn btn-outline-success btn-sm pull-right col-sm-2">Enroll</button>
            </div>
          </fieldset>
          <!-- Modal footer -->

          <div class="modal-footer" style="background-color: grey;">
              <b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
            </div>
      </div>
    </div>
</div>
<!-- ====================================  enroll Modal ======================================================== -->
  <input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</section>
<?php require_once 'footer.php' ?>
