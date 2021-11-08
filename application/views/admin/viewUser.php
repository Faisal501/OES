<?php require_once 'header.php';

?>
<div class="btn col-lg-12">
  <span><a href="enrollUser" id="enrollUser" class="btn btn-outline-info btn-sm pull-right">
  Enrolled in Exams </a>
</span>
  <i class="fa fa-fighter-jet pull-left"></i>
</div>
<section class="wrapper">
 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <p id="message"></p>
    <table id="regUsersTable" class="table table-bordered table-hover  h6">
                <thead style="color:white; background-color:black;">
                <tr>
                <th style="text-align:center" width="5%">ID</th>
                <th style="text-align:center" width="40%">Full-Name</th>
                <th style="text-align:center" width="30%">Email</th>
                <th style="text-align:center" width="20%">Mobile</th>
                <th style="text-align:center" width="5%">Verified</th>
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
