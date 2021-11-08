$(document).ready(function(){

/*    =========================== ============= Fetching Exam List =============== ===========================  */
var examList = $('#examList').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':$('#url').val()+'/user/getExamList',
          'data':{check:'examList', page:'userIndex'}
      },
      'columns': [
         { data: 'Exam_Title' },
         { data: 'Total_Question' },
         { data: 'Duration' },
         { data: 'Date_Time' },
         { data: 'MCQ' },
         { data: 'DESC'},
         { data: 'Enroll'},
      ]

    });


/*    =========================== =============== Enroll in Exam ================== ===========================  */

var exam_id = '';
  $(document).on('click', '.enroll', function(){
    exam_id = $(this).attr('id');
    $('#enrollModal').modal('show');
  });

  $('#enrollButton').click(function(){
    $.ajax({
      url:$('#url').val()+'/user/enroll',
      method:"POST",
      data:{exam_id:exam_id, check:'enroll', page:'userIndex'},
      dataType:"json",
      success:function(data)
      {
      	if(data.success)
      	{
      		$('#message').html('<div class="alert alert-success">'+data.success+'</div>');
	        $('#enrollModal').modal('hide');
	        examList.ajax.reload();
      	}
      	else if (data.error)
      	{
      		$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
	        $('#enrollModal').modal('hide');
	        examList.ajax.reload();
      	}

      }
    })
  });

/*    =========================== =============== my Exams ================== ===========================  */

var myExam = $('#myExam').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':$('#url').val()+'/user/myExams',
          'data':{check:'myExams', page:'myexam'}
      },
      'columns': [
         { data: 'Exam_Title' },
         { data: 'Date_Time' },
         { data: 'Total_Question' },
         { data: 'Duration' },
         { data: 'Quit' },
         { data: 'Start'},
      ]

    });

/*    =========================== =============== Quitting from Exam ================== ===========================  */

var exam_id = '';
  $(document).on('click', '.quit', function(){
    exam_id = $(this).attr('id');
    $('#quitModal').modal('show');
  });

  $('#quitButton').click(function(){
    $.ajax({
      url:$('#url').val()+'/user/quitExam',
      method:"POST",
      data:{exam_id:exam_id, check:'quit', page:'myexam'},
      dataType:"json",
      success:function(data)
      {
      	if(data.success)
      	{
      		$('#message').html('<div class="alert alert-success">'+data.success+'</div>');
	        $('#quitModal').modal('hide');
	        myExam.ajax.reload();
      	}
      	else if (data.error)
      	{
      		$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
	        $('#quitModal').modal('hide');
	        myExam.ajax.reload();
      	}

      }
    })
  });

/*    =========================== =============== profile setting ================== ===========================  */

$('#user_profile_form').on('submit', function(e){
    e.preventDefault();
  $.ajax({

            method: "POST",
            url: $('#url').val()+'/user/updateProfile',
            data: $(this).serialize(),
            dataType:"json",
            beforeSend:function(){
              $('#update').attr('disabled', 'disabled');
              $('#update').val('Updating...');
            },
            success:function(data)
            {
               if(data.success)
                  {
                    $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
                  }
                  else
                  {
                    $('#message').html('<div class="alert text-danger">'+data+'</div>');
                  }

                  $('#update').attr('disabled', false);

                  $('#update').val('Update');

                     setTimeout(function(){

                                           location.reload();

                                       },3000);
                                  }
          });
    });

/*    =========================== =============== Exam starting ================== ===========================  */

var exam_id='';
var user_id='';
  $('#startPaper').click(function(){

    $.ajax({
        url: $('#url').val()+'/user/checkExamTime',
        method: 'POST',
        data:{check:'checkExamTime', page:'user'},
        dataType:'json',
        success:function(data)
        {

        }

    });

    exam_id = $('#exam_id').val();
    user_id = $('#user_id').val();
    $.ajax({
      url:$('#url').val()+'/user/startExam',
      method:"POST",
      data:{exam_id:exam_id, user_id:user_id, check:'startPaper', page:'paper'},
      dataType:"json",
      success:function(data)
      {
        if(data.error)
        {
            $('#save').attr('hidden',true);
            $('#question-panel').attr('hidden', false);
            $('#single_question_area').html('<p class="alert alert-danger">'+data.error+'</p>');

          setTimeout(function(){
            window.location = $('#url').val()+'/user/users?check=myexam';
          },3000);
        }
        else
        {
          $('#clock').val(data.remaining_time);
          load_question();
          question_navigation();
          start_timer();
          $('#startPaper').attr('hidden','hidden');
          $('#question-panel').attr('hidden', false);
        }
      }
    });

  });

  $(document).on('click','.answer',function(){
    $('.save').attr('disabled',false);
     $('#finishPaper').attr('disabled', false);
  });
  $(document).on('click','.desc_answer',function(){
    $('.save').attr('disabled',false);
     $('#finishPaper').attr('disabled', false);
  });

  $(document).on('click', '.next', function(){
    var question_id = $(this).attr('id');
    load_question(question_id);
  });

  $(document).on('click', '.previous', function(){
    var question_id = $(this).attr('id');
    load_question(question_id);
  });



  $(document).on('click', '.question_navigation', function(){
    var question_id = $(this).attr('id');
    load_question(question_id);
  });


/*    =========================== functions for papers page ===========================  */

      function start_timer()
      {
          var time = $('#clock').val();

          var clock = $('.countdown').FlipClock(time,{
            clockFace: 'MinuteCounter',
            countdown:true,

            callbacks: {
		        	stop: function() {
		        		alert('Time is Over');
                window.location = $('#url').val()+'/user/users?check=index';
		        	}
		        }
          });
      }

      function load_question(question_id = '')
        {
          $.ajax({
            url:$('#url').val()+'/user/loadQuestion',
            method:"POST",
            data:{exam_id:exam_id, question_id:question_id, check:'paper', action:'load_question'},
            success:function(data)
            {
              $('#single_question_area').html(data);
              $('#finishPaper').attr('hidden', false);
              $('#finishPaper').attr('disabled', true);

            }
          })

          $.ajax({
            url:$('#url').val()+'/user/loadQuestion',
            method:"POST",
            data:{question_id:question_id, check:'paper', checked:'checked'},
            dataType:"json",
            success:function(data)
            {
              if(data.length > 1)
              {
                $('.desc_answer').val(data);
              }
              else
              {
                $("input[name=answer][value=" + data + "]").prop('checked', true);
              }
            }
          });
        }

      function question_navigation()
        {
          $.ajax({
            url:$('#url').val()+'/user/loadQuestion',
            method:"POST",
            data:{exam_id:exam_id, check:'paper', action:'question_navigation'},
            success:function(data)
            {
              $('#question_navigation_area').html(data);
            }
          })
        }



/*    =========================== =============== paper page ends ================== ===========================  */
/*    =========================== =============== saving answer ================== ===========================  */

  $(document).on('click', '.save', function(){
    var desc_answer = '';
    desc_answer = $('.desc_answer').val();
    var exam_id = $('#exam_id').val();
    var question_id = $('.question').attr('id');
    var answer = $('.answer:checked').val();

$.ajax({
      url:$('#url').val()+'/user/saveAnswer',
      method:"POST",
      data:{check:'paper',action:'save_answer',question_id:question_id,answer:answer,desc_answer:desc_answer,exam_id:exam_id},
      success:function(data)
      {
        $('.save').val('SAVED');
        $('.save').attr('disabled', 'disabled');
        setTimeout(function(){
          $('.save').attr('disabled', false);
          $('.save').val('SAVE');
        },3000);


      }
    })

   });

   // ==============================  Ending paper ===============================
     $('#finishPaper').click(function(){
       $('#endPaper').modal('show');
       $.ajax({
         url:$('#url').val()+'/user/endExam',
         method:"POST",
         data:{exam_id:exam_id, check:'endPaper', page:'paper'},
         dataType:"json",
         success:function(data)
         {
           $('#total').html('<p> Total Questions :    ' + data.total + '</p>');
           $('#attempt').html('<p> Attempted     :    ' + data.attempt + '</p>');
         }
       })
     });

     $('#endButton').click(function(){

         $.ajax({
           url:$('#url').val()+'/user/endExam',
           method:"POST",
           data:{exam_id:exam_id, check:'finishPaper', action:'endPaper'},
           success:function(data)
           {
             if(data)
             {
               alert ('Thank you for Studying with Us !');
               window.location = $('#url').val()+'/user/users?check=index';
             }
             else
             {
               alert ('something went wrong');
             }

           }
         });

     });
// =======================  paper end =================================

// =======================================result ===========================
var viewResult =  $('#resultTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':$("#url").val()+'/user/result',
          'data':{check:'view_Result', page:'result'}
      },

      'columns': [
         { data: 'S_No'},
         { data: 'Exam_Title' },
         { data: 'User_Name' },
         { data: 'Total_Marks' },
         { data: 'Marks_Obtained' },
         { data: 'View'},
      ],

    });

    $('#viewResult').click(function(){
      viewResult.ajax.reload();
    });

// ================================ user result ================================
var exam_id = $('#exam_id').val();
var user_id = $('#user_id').val();
  $.ajax({
    url:$("#url").val()+'/user/result',
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
