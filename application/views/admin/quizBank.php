<?php require_once 'header.php';

?>

<section class="wrapper">
 <input type="hidden" id="exam_code" value = "<?php echo $_GET['id']; ?>" />
 <input type="hidden" id="subject" value = "<?php echo $_GET['sub']; ?>" />
 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <p id="message"></p>
    <table id="questionTable" class="table table-bordered table-hover  h6">
                <thead style="color:white; background-color:black;">
                <tr>
                <th style="text-align:center" width="10%">Subject</th>
                <th style="text-align:center" width="45%">Question</th>
                <th style="text-align:center" width="15%">Question Type</th>
                <th style="text-align:center" width="10%">Edit</th>
                <th style="text-align:center" width="10%">Delete</th>
                </tr>
                </thead>

                <tbody>

                </tbody>
              </table>
            </div>
          </div><!-- /content-panel -->
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->


<!-- ====================================  Question Modal ======================================================== -->

      <div class="modal fade" id="questionModal" role="dialog">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="question_modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
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
                      <label class="col-md-4 text-right">Correct Option <span class="text-danger">*</span></label>
                      <div class="col-md-8">
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

              <input type="hidden" name="page" value="quizBank" />

              <input type="hidden" name="check" id="check" value="addQuestion" />

    <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>

<input type="submit" name="btnQuestion" id="btnQuestion" class="btn btn-outline-success btn-sm pull-right col-sm-2" value="Add" />
              </fieldset>
              </form>
              </div>
            <!-- Modal footer -->
           <div class="modal-footer" style="background-color: grey;">
              <b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
            </div>
          </div>
    </div>
</div>

<!-- ====================================  Delete Modal ======================================================== -->
<div class="modal fade" id="delete_quest_Modal">
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
            <h5 align="center" class="text-danger">Are you sure you want to Delete this Question ?</h5>
            <hr/>
            <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>
            <button type="button" name="delet_quest_Button" id="delete_quest_Button"
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

<!-- ====================================  Edit Modal ======================================================== -->
<div class="modal fade" id="edit_quest_Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="desc_modal-title">Edit Question Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
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
              <input type="hidden" name="quest_type" id="quest_type" value="DES" />
              <input type="hidden" name="page" value="quizBank" />

              <input type="hidden" name="check" id="check" value="Edit_Quest_Desc" />

        <button type="button" class="btn btn-outline-danger btn-sm pull-right col-sm-2" data-dismiss="modal">Close</button>

              <input type="submit" name="btnQuestion_desc" id="btnQuestion_desc"
              class="btn btn-outline-success btn-sm pull-right col-sm-2" value="Add" />
          </fieldset>
        </form>
         </div>
          <!-- Modal footer -->

          <div class="modal-footer" style="background-color: grey;">
              <b class="logo">online&nbsp;<span>Examination</span>&nbsp;System</b>
            </div>
    </div>
</div>

<input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</section>




<?php include_once 'footer.php';?>
