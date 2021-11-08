<?php require_once 'header.php';

$exam_id = $_GET['exam_id'];
$user_id = $_GET['user_id'];
?>

<section class="wrapper">

  <input type="hidden" id ="exam_id" name="exam_id" value="<?php echo $exam_id; ?>"/>
  <input type="hidden" id ="user_id" name="user_id" value="<?php echo $user_id; ?>"/>


 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <table id="paper_marking" class="table table-bordered table-hover h6">
              <thead style="color:white; background-color:black; text-align:center; ">
              <tr>
              <th width="10%">Exam_Title</th>
              <th width="25%">Question</th>
              <th width="10%">Answer</th>
              <th width="35%">User Answer</th>
              <th width="5%">Total Marks</th>
              <th width="5%">Marks Obtained</th>
              <th width="10%">Save</th>
              </tr>
              </thead>
            </table>
            </div>
            <div class="btn col-lg-12">
              <button type="button" id="saveMarked" class="btn btn-outline-success btn-sm pull-right">
              Save as Marked
            </button>
              <i class="fa fa-fighter-jet pull-left"></i>
            </div>
          </div><!-- /content-panel -->
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
      <input type="hidden" name="url" id="url" value="<?php echo BASEURL; ?>" />
</section>
</div>




<!-- ################################################ Scripts#######################################################-->
<?php linkJS("assets/js/jquery.min.js"); ?>
<?php linkJS("assets/js/bootstrap.min.js"); ?>
    <script type="text/javascript">
      $(document).ready(function(){
        var exam_id = $('#exam_id').val();
        var user_id = $('#user_id').val();
        var total = 0;
        var obtained = 0;

          $.ajax({
            url:$('#url').val()+'/admin/result',
            method:"POST",
            dataType:"json",
            data:{check:'result', page:'marking', user_id:user_id, exam_id:exam_id},
            success:function(data)
            {
              load_marking(data);
            }
          });

          function load_marking(data)
          {
            var marking = '';
            $.each(data, function(key,value)
            {
              marking += '<tr style="text-align:center">';
              marking += '<td>'+value.Exam_Title+'</td>';
              marking += '<td>'+value.Question+'</td>';
              marking += '<td>'+value.Answer+'</td>';
              marking += '<td>'+value.User_Answer+'</td>';
              marking += '<td>'+value.Total_Marks+'</td>';
              marking += '<td>'+value.Marks_Obtained+'</td>';
              marking += '<td>'+value.Save+'</td>';
              marking += '</tr>';

              total += Number(value.Total_Marks);
            });
            $("#paper_marking").append(marking);
          }

          $(document).on('click','.save_marks', function(){
            var question_id = $(this).attr('id');
            var marks = $("#marks"+question_id).val();
            obtained += Number(marks);
            $(this).attr('id','saved'+question_id);

            $.ajax({
              url:$('#url').val()+'/admin/result',
              method:"POST",
              dataType:"json",
              data:{check:'marks', page:'marking', marks:marks,question_id:question_id,user_id:user_id, exam_id:exam_id},
              success:function(data)
              {
                  if(data.success)
                  {
                      $('#saved'+question_id).val('Saved');
                      $('#saved'+question_id).attr('disabled',true);
                  }
              }
            });
          });


  // =========================   save markings ==============================

  $(document).on('click','#saveMarked', function(){
    $.ajax({
      url:$('#url').val()+'/admin/result',
      method:"POST",
      dataType:"json",
      data:{check:'saveMarked', page:'marking',user_id:user_id, exam_id:exam_id, total:total, obtained:obtained},
      success:function(data)
      {
          if(data.success)
          {
              $('#saveMarked').val('Saving');
              $('#saveMarked').attr('disabled',true);

              alert('Paper Marked successfully');
              window.location = "admin?check=prepareResult";
          }
          else {
            alert('SomeThing went Wrong');
          }
      }
    });
  });

      });

    </script>



</body>
</html>
