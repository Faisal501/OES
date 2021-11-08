<?php require_once 'header.php';


$exam_id = $_GET['exam_id'];
$user_id = $_GET['user_id'];
?>

<section class="wrapper">

  <input type="hidden" id ="exam_id" name="exam_id" value="<?php echo $exam_id; ?>"/>
  <input type="hidden" id ="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
  <div class="btn col-lg-12">
    <span><a target="_blank" href="single_Result_PDF?exam_id=<?php echo $exam_id; ?>&user_id=<?php echo $user_id; ?>"
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


          $.ajax({
            url:$('#url').val()+'/admin/result',
            method:"POST",
            dataType:"json",
            data:{check:'singleResult', page:'single_Result', user_id:user_id, exam_id:exam_id},
            success:function(data)
            {
              load_marking(data);
            }
          });


          function load_marking(data)
          {
            var marking = '';
            var total = '';
            var obtained = '';

            $.each(data, function(key,value)
            {
              marking += '<tr style="text-align:left">';
              marking += '<td>'+value.Exam_Title+'</td>';
              marking += '<td>'+value.Question+'</td>';
              marking += '<td>'+value.Type+'</td>';
              marking += '<td>'+value.Answer+'</td>';
              marking += '<td>'+value.User_Answer+'</td>';
              marking += '<td>'+value.Marks+'</td>';
              marking += '</tr>';
              total = Number(value.Total_Marks);
              obtained = Number(value.Marks_Obtained);
            });
            $("#single_Result").append(marking);
            $("#total").text(total);
            $("#obtained").text(obtained);
          }

  });

    </script>



</body>
</html>
