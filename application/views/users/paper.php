<?php require_once 'header.php';

$exam_id='';
$user_id = '';

if(isset($_GET['uid']))
{
	$exam_id = $_GET['eid'];
	$user_id = $_GET['uid'];
}
?>
<input type="hidden" id="exam_id" value="<?php echo $exam_id; ?>"/>
<input type="hidden" id="user_id" value="<?php echo $user_id; ?>"/>
<section class="wrapper">
	<div class="countdown"></div>
	<div class="question-panel" id="question-panel" >
		<div class="col-lg-9">
			<div id="single_question_area">

			</div>
			<div id="question_navigation_area">

			</div>
		</div>
		<div class="col-lg-3">
			<div id="user_details_area" style="background-color: grey; color: white;">
				<img src="<?php echo BASEURL; ?>/assets/img/logo.png" alt="<?php echo $this->getSession('name');?>" style="max-height: 100px; max-width: 100px;">
				<table class="table table-hover" style="color:white;">
					<tr>
						<th>Name</th>
						<td><?php echo $this->getSession('name');  ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?php echo $this->getSession('email');  ?></td>
					</tr>
					<tr>
						<th>Mobile</th>
						<td><?php echo $this->getSession('mobile');  ?></td>
					</tr>
				</table>
			</div>
			<input type="submit" class="btn-sm btn-success col-sm-12" id="startPaper" value="START"/>
			<input type="submit" class="btn-sm btn-danger col-sm-12" id="finishPaper" value="FINISH" hidden/>
		</div>



	</div>

	<!-- ====================================  Delete Modal ======================================================== -->
	<div class="modal fade" id="endPaper">
	    <div class="modal-dialog">
	      <div class="modal-content">

	          <!-- Modal Header -->
	          <div class="modal-header">
	            <h4 class="modal-title">Confirmation For Ending</h4>
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	          </div>

	          <!-- Modal body -->
	          <div class="modal-body">
	            <fieldset>
								<h5 id="total"></h5>
								<h5 id="attempt"></h5>
	            <h5 align="center" class="text-danger">Are you sure you want to End Exam</h5>
	            <hr/>
	            <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>
	            <button type="button" name="endButton" id="endButton"
	                    class="btn btn-outline-success btn-sm pull-right col-sm-2">FINISH</button>
	            </div>
	          </fieldset>
	          <!-- Modal footer -->
	          <div class="modal-footer" style="background-color: grey;">
	              <b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
	            </div>
	      </div>
	    </div>
	</div>
</section>
	<input type="hidden" name="clock" id="clock" value="">
 	<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</div>
<!-- ################################################ Scripts#######################################################-->
		<?php linkJS("assets/js/jquery.min.js"); ?>
		<?php linkJS("assets/js/bootstrap.min.js"); ?>
		<?php linkJS("assets/js/parsley.js"); ?>
		<?php linkJS("assets/js/popper.min.js"); ?>
		<?php linkJS("assets/js/jquery.dataTables.min.js"); ?>
		<?php linkJS("assets/js/dataTables.bootstrap4.min.js"); ?>
		<?php linkJS("assets/js/userView.js"); ?>
		<?php linkJS("assets/js/flipclock.js"); ?>


</body>
</html>
