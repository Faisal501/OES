<?php require_once 'header.php';

?>
	<!-- ==================================== Create Exam started ============================================= -->

  <section class="wrapper">
<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
                    <!-- Modal Button -->
  <div class="btn col-lg-12">
    <button type="button" id="modalBtn" class="btn btn-outline-primary btn-sm pull-right">
    Create Exam
  </button>
    <i class="fa fa-fighter-jet pull-left"></i>
  </div>

  <!-- ====================================  Main Table ======================================================== -->
      <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <p id="message"></p>
    <table id="examTable" class="table table-bordered table-hover text-center">
                <thead style="color:white; background-color:black;">
                <tr>
                <th style="text-align:center" width="20%">Exam Title</th>
                <th style="text-align:center" width="5%">Questions</th>
                <th style="text-align:center" width="5%">Duration</th>
                <th style="text-align:center" width="15%">Date Time</th>
                <th style="text-align:center" width="10%">Status</th>
                <th style="text-align:center" width="20%">Action for Exam</th>
                <th style="text-align:center" width="20%">Action for Questions</th>
                </tr>
                </thead>

                <tbody>

                </tbody>
              </table>
            </div>
          </div><!-- /content-panel -->
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->

<!-- ====================================  Main Table ======================================================== -->

<!-- ====================================  Exam Modal ======================================================== -->
            <!-- Modal -->
      	<div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">

      <!-- Modal for data collection starts -->

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id ="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        	</div>
        	<div class="modal-body">
            <form class="form-horizontal" id="questionForm" name="questionForm" method="POST">
				      <fieldset>
                <div class="form-group">
                <div class="row">
                <label class="col-md-4">Exam Title<span class="text-danger">:</span></label>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="title" name="title">
                </div>
                </div>
                </div>
                <div class="form-group">
                  <div class="row">
                  <label class="col-md-4">Exam Date & Time <span class="text-danger">:</span></label>
                  <div class="col-md-8">
                  <input type="text" name="examDatetime" id="examDatetime" class="form-control" readonly />
                  </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                <label class="col-md-4">Exam Duration<span class="text-danger">:</span></label>
                <div class="col-md-8">
                  <select class="form-control" name="duration" id="duration">
                  <option value="">Select</option>
                  <option value="10">10 min</option>
                  <option value="20">20 min</option>
                  <option value="30">30 min</option>
                  <option value="40">40 min</option>
                  <option value="50">50 min</option>
                  <option value="60">60 min</option>
	                </select>
                </div>
                </div>
              </div>
                <div class="form-group">
                  <div class="row">
                <label class="col-md-4">Total Question<span class="text-danger">:</span></label>
                <div class="col-md-8">
                  <input type="number" min="2" class="form-control" name="totalQuestion" id="totalQuestion"/>
                </div>
                </div>
              </div>
                 <div class="form-group">
                  <div class="row">
                <label class="col-md-4">Marks For MCQs<span class="text-danger">:</span></label>
                <div class="col-md-8">
                  <select class="form-control" name="marks" id="marks" >
                  <option value="">Select</option>
                  <option value="1">1 marks</option>
                  <option value="2">2 marks</option>
	                </select>
                </div>
                </div>
              </div>
                 <div class="form-group">
                  <div class="row">
                <label class="col-md-4">Marks For Descriptive Question<span class="text-danger">:</span></label>
                <div class="col-md-8">
                  <select class="form-control" name="descMarks" id="descMarks">
                  <option value="">Select</option>
                  <option value="5">5 marks</option>
                  <option value="10">10 marks</option>
	                </select>
                </div>
                </div>
                </div>
              <input type="hidden" name="Exam_id" id="Exam_id" />

              <input type="hidden" name="page" id="page" value="admin"  />

              <input type="hidden" name="check" id="check" value="Add" />

    <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>

<input type="submit" name="btnModal" id="btnModal" class="btn btn-outline-success btn-sm pull-right col-sm-2" value="Add" />
			        </fieldset>
  			    </form>
        		</div>
        		  <div class="modal-footer" style="background-color: grey;">
        			<b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
        		  </div>
            </div>
          </div>
        </div>
        <!-- Modal Ends -->




        <!-- ====================================  Question Modal ======================================================== -->

      <div class="modal fade" id="questionModal" role="dialog">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <h4 class="modal-title" id="question_modal_title"></h4>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <button type="button" class="btn btn-outline-danger btn-sm col-sm-2" id="mcqs" name="mcqs">MCQs</button>
        &emsp;&emsp;<p>OR</p>&emsp;&emsp;
        <button type="button" class="btn btn-outline-danger btn-sm col-sm-2" id="subjective"
          name="subjective">DESCRIPTIVE</button>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="mcqs">
              <form method="post" id="add_question_form">
                <fieldset>
                <div class="form-group">
                <div class="row">
                <label class="col-md-2">Question  <span class="text-danger">*</span></label>
                <div class="col-md-10">
                  <textarea name="question" id="question" autocomplete="off" class="form-control" rows="2"></textarea>
                </div>
                </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-2">Option A <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <input type="text" name="optionA" id="optionA" autocomplete="off" class="form-control" />
                      </div>
                      <label class="col-md-2">Option B <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <input type="text" name="optionB" id="optionB" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-2">Option C <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <input type="text" name="optionC" id="optionC" autocomplete="off" class="form-control" />
                      </div>
                      <label class="col-md-2">Option D <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <input type="text" name="optionD" id="optionD" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-2">Correct Option <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <select name="correct" id="correct" class="form-control">
                          <option value="">Select</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>
                      </div>
                  </div>
                </div>
              <input type="hidden" name="question_id" id="question_id" />
              <input type="hidden" name="exam_id" id="exam_id" />
              <input type="hidden" name="quest_type" id="quest_type" value="MCQ" />
              <input type="hidden" name="page" value="admin" />

              <input type="hidden" name="check" id="check" value="addQuestion" />

    <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>

<input type="submit" name="btnQuestion" id="btnQuestion" class="btn btn-outline-success btn-sm pull-right col-sm-2" value="Add" />
              </fieldset>
              </form>
              </div>

              <div class="subjective">
              <form method="post" id="add_question_form_desc">
                <fieldset>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-2">Question  <span class="text-danger">*</span></label>
                      <div class="col-md-10">
                <textarea name="question_desc" id="question_desc" autocomplete="off" class="form-control" rows="4"></textarea>
                      </div>
                  </div>
                </div>
              <input type="hidden" name="question_id_desc" id="question_id_desc" />
              <input type="hidden" name="exam_id_desc" id="exam_id_desc" />
              <input type="hidden" name="quest_type" id="quest_type" value="DESC" />
              <input type="hidden" name="page" value="admin" />

              <input type="hidden" name="check" id="check" value="addQuestion_desc" />

    <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>

<input type="submit" name="btnQuestion_desc" id="btnQuestion_desc"
class="btn btn-outline-success btn-sm pull-right col-sm-2" value="Add" />
              </fieldset>
              </form>
              </div>

              </div>
            <!-- Modal footer -->
           <div class="modal-footer" style="background-color: grey;">
              <b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
            </div>
          </div>
    </div>
</div>

<!-- ====================================  Delete Modal ======================================================== -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Confirmation For Delete</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <fieldset>
            <h5 align="center" class="text-danger">Are you sure you want to Delete this Exam ?</h5>
            <hr/>
            <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>
            <button type="button" name="deletButton" id="deleteButton"
                    class="btn btn-outline-success btn-sm pull-right col-sm-2">Delete</button>
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

	<!-- ==================================== Create Exam Ends ======================================================== -->


  <?php require_once 'footer.php';?>
