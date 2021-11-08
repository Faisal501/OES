<?php require_once 'header.php';

$exam_id = $_GET['exam_id'];
$user_id = $_GET['user_id'];
?>

<section class="wrapper">

  <input type="hidden" id ="exam_id" name="exam_id" value="<?php echo $exam_id; ?>"/>
  <input type="hidden" id ="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
  <div class="btn col-lg-12">
    <span><a target="_blank" href="user_Result_PDF?exam_id=<?php echo $exam_id; ?>&user_id=<?php echo $user_id; ?>"
      class="btn btn-info btn-sm pull-right">
    View in PDF </a>
  </span>
    <i class="fa fa-fighter-jet pull-left"></i>
  </div>

 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <table id="single_Result" class="table table-bordered table-hover h6">
              <thead style="color:white; background-color:black; text-align:center; ">
              <tr>
              <th width="5%">Exam_Title</th>
              <th width="25%">Question</th>
              <th width="5%">Type</th>
              <th width="5%">Answer</th>
              <th width="40%">User Answer</th>
              <th width="5%">Marks Obtained</th>
              </tr>
              </thead>
            </table>
            <table class="table table-bordered table-hover h6">
            <tr style="text-align:center">
            <td> <h3> Total Marks : </h3></td><td><h3 id="total"></h3></td>
            <td> <h3> Marks Obtained : </h3></td><td><h3 id="obtained"></h3></td>
            </tr>
            </table>
            </div>
          </div><!-- /content-panel -->
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
</section>
<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</div>




<!-- ################################################ Scripts#######################################################-->

<?php include_once 'footer.php' ?>
