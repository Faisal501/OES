<?php require_once 'header.php';

?>

<section class="wrapper">
 <div class="row mt">
        <div class="col-lg-12">
          <div class="content-panel">
            <div class="table-responsive">
              <table id="prepare_Result" class="table table-bordered table-hover h6">
              <thead style="color:white; background-color:black; text-align:center; ">
              <tr>
              <th width="25%">Exam_Title</th>
              <th width="25%">Full-Name</th>
              <th width="25%">Total_Question</th>
              <th width="25%">Marking</th>
              </tr>
              </thead>
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
          var prepareresult = $.ajax({
            url:$('#url').val()+'/admin/result',
            method:"POST",
            dataType:"json",
            data:{check:'result', page:'prepareResult'},
            success:function(data)
            {
              load_prepareResult(data);
            }
          })

          function load_prepareResult(data)
          {
            var prepareResult = '';
            $.each(data, function(key,value)
            {
              prepareResult += '<tr style="text-align:center">';
              prepareResult += '<td>'+value.Exam_Title+'</td>';
              prepareResult += '<td>'+value.User_Name+'</td>';
              prepareResult += '<td>'+value.Total_Question+'</td>';
              prepareResult += '<td>'+value.Marking+'</td>';
              prepareResult += '</tr>';
            });
            $("#prepare_Result").append(prepareResult);
          }

          $('#prepareResult').click(function(){
            prepareresult.ajax.reload();
          });
      });

    </script>



</body>
</html>
