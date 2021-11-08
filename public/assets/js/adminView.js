$(document).ready(function(){


      /* ======================== checking time of exam ======================= */
/*
        setInterval(function(){

          $.ajax({
              url: $('#url').val()+'/user/checkExamTime',
              method: 'POST',
              data:{check:'checkExamTime', page:'user'},
              dataType:'json',
              success:function(data)
              {

              }

          });
        },10000); */
  /*    =========================== ============= Fetching data for display =============== ===========================  */

var dataTable = $('#examTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':$('#url').val()+'/admin/getJQueryTable',
          'data':{check:'tableData', page:'admin'}
      },
      'columns': [
         { data: 'Exam_Title' },
         { data: 'Total_Question' },
         { data: 'Duration' },
         { data: 'Date_Time' },
         { data: 'Exam_Status' },
         { data: 'exam'},
         { data: 'question'},
      ]

    });


/*    =========================== ============ Reseting the Modal form =========== ===========================  */
    function reset_form()
    {
        $('#modal_title').text('Add Exam Details');
        $('#check').val('Add');
        $('#btnModal').val('Add');
        $('#questionForm')[0].reset();
        $('#questionForm').parsley().reset();
    }
/*    =========================== ================ Displaying the Modal ================ ===========================  */

    $("#modalBtn").click(function(){
        reset_form();
        $("#myModal").modal("show");
        $('#message_operation').html('');

    });

/*    =========================== ==============Inserting exam from Modal ================ ===========================  */

    var date = new Date();

    date.setDate(date.getDate());

    $('#examDatetime').datetimepicker({
      startDate :date,
      format: 'yyyy-mm-dd hh:ii',
      autoclose:true
    });

    $('#questionForm').parsley();

    $('#questionForm').on('submit', function (event)
    {

        event.preventDefault();

        $('#title').attr('required', 'required');

        $('#examDatetime').attr('required', 'required');

        $('#duration').attr('required', 'required');

        $('#totalQuestion').attr('required', 'required');

        $('#marks').attr('required', 'required');

        $('#descMarks').attr('required', 'required');

        if ($('#questionForm').parsley().validate())
        {

            $.ajax({

                method: "POST",
                url:$('#url').val()+'/admin/addExam',
                data: $(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                  $('#btnModal').attr('disabled', 'disabled');
                  $('#btnModal').val('Validate...');
                },
                success:function(data)
                {
                   if(data.success)
                      {
                        $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
                        reset_form();
                        dataTable.ajax.reload();
                        $('#btnModal').val('Add');
                        $('#myModal').modal('hide');
                      }
                      else
                      {
                        $('#message').html('<div class="alert text-danger">'+data+'</div>');
                      }

                      $('#btnModal').attr('disabled', false);

                      $('#btnModal').val($('#action').val());
                }
                  });
          }
      });

/*    =========================== ============== Editing exam with Modal ================ ===========================  */

  var exam_id = '';

  $(document).on('click','.edit', function()
  {
        exam_id = $(this).attr('id');
        reset_form();
        $.ajax({
          url:$('#url').val()+'/admin/editExam',
          method:"POST",
          data:{check:'edit', exam_id:exam_id, page:'admin'},
          dataType:"json",
          success:function(data)
          {

            $('#title').val(data.Exam_Title);

            $('#examDatetime').val(data.Date_Time);

            $('#duration').val(data.Duration);

            $('#totalQuestion').val(data.Total_Question);

            $('#marks').val(data.Marks_MCQ);

            $('#descMarks').val(data.Marks_Desc);

            $('#Exam_id').val(exam_id);

            $('#modal_title').text('Edit Exam Details');

            $('#btnModal').val('Edit');

            $('#check').val('EditDone');

            $('#myModal').modal('show');
          }
              })

  });

/*    =========================== =============== Deleting Exam ================== ===========================  */

var exam_id = '';
  $(document).on('click', '.delete', function(){
    exam_id = $(this).attr('id');
    $('#deleteModal').modal('show');
  });

  $('#deleteButton').click(function(){
    $.ajax({
      url:$('#url').val()+'/admin/deleteExam',
      method:"POST",
      data:{exam_id:exam_id, check:'delete', page:'admin'},
      dataType:"json",
      success:function(data)
      {
        $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
        $('#deleteModal').modal('hide');
        dataTable.ajax.reload();
      }
    })
  });



/*   ===========================================================================================================
                              Page = quizBank started
   =============================================================================================================  */


    /*   =========================== ================ question display =================== ===========================  */

  var exam_id = '';
  var subject = '';

   exam_id = $('#exam_code').val();
   subject = $('#subject').val();

   var questionTable = $('#questionTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax':
      {
          'url':$('#url').val()+'/admin/getJQueryTable',
          'data':{check:'questionTableData', page:'quizBank' , exam_id:exam_id , subject:subject }
      },
      'columns': [

         { data: 'Subject' },
         { data: 'Question' },
         { data: 'Question_Type' },
         { data: 'edit_btn'},
         { data: 'delete_btn' },
      ]

    });


   /*    =========================== question bank table (Page QuestionBank)===========================  */

      var quizBankTable = $('#quizBankTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax':
      {
          'url':$('#url').val()+'/admin/getJQueryTable',
          'data':{check:'quizBankTableData', page:'quizBank'}
      },
      'columns': [

         { data: 'Subject' },
         { data: 'Question' },
         { data: 'Question_Type' },
         { data: 'edit_btn'},
         { data: 'delete_btn' },
      ]

    });
      $('#quizBankData').click(function(){
        quizBankTable.ajax.reload();
    });

/*    =========================== ================ Adding Question =================== ===========================  */

var exam_id = '';
    function reset_question_form()
  {
    $('#question_modal_title').text('Add Question');
    $('#btnQuestion').val('Add');
    $('#check').val('Add');
    $('#add_question_form')[0].reset();
    $('#add_question_form').parsley().reset();
    $('#add_question_form_desc')[0].reset();
    $('#add_question_form_desc').parsley().reset();
  }

  $(document).on('click', '.add', function(){
    reset_question_form();
    $('#questionModal').modal('show');
    $('#message').html('');
    exam_id = $(this).attr('id');
    $('#exam_id').val(exam_id);
    $('#exam_id_desc').val(exam_id);
    $('.subjective').hide();
    $('.mcqs').hide();
  });

  $('#subjective').click(function(){
    $('.subjective').show();
    $('.mcqs').hide();
  });

  $('#mcqs').click(function(){
    $('.mcqs').show();
    $('.subjective').hide();
  });

// ============================ MCQs ============================//
  $('#add_question_form').parsley();
  $('#add_question_form').on('submit', function(event){
    event.preventDefault();

    $('#question').attr('required', 'required');

    $('#optionA').attr('required', 'required');

    $('#optionB').attr('required', 'required');

    $('#optionC').attr('required', 'required');

    $('#optionD').attr('required', 'required');

    $('#correct').attr('required', 'required');

    if($('#add_question_form').parsley().validate())
    {
      $.ajax({
        url:$('#url').val()+'/admin/addQuestion',
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
          $('#btnQuestion').attr('disabled', 'disabled');
          $('#btnQuestion').val('Validate...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">'+data.success+'</div>');

            reset_question_form();
            questionTable.ajax.reload();
            quizBankTable.ajax.reload();
            $('#questionModal').modal('hide');
          }
          if(data.error)
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
            reset_question_form();
            questionTable.ajax.reload();
            quizBankTable.ajax.reload();
            $('#questionModal').modal('hide');
          }
          $('#btnQuestion').attr('disabled', false);

          $('#btnQuestion').val($('#action').val());

        }
      });
    }
  });

// ============================ Descriptive ==========================//
   $('#add_question_form_desc').parsley();
  $('#add_question_form_desc').on('submit', function(event){
    event.preventDefault();

    $('#question_desc').attr('required', 'required');

    if($('#add_question_form_desc').parsley().validate())
    {
      $.ajax({
        url:$('#url').val()+'/admin/addQuestion',
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
          $('#btnQuestion_desc').attr('disabled', 'disabled');
          $('#btnQuestion_desc').val('Validate...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
            reset_question_form();
            questionTable.ajax.reload();
            quizBankTable.ajax.reload();
            $('#questionModal').modal('hide');
            $('#edit_quest_Modal').modal('hide');
          }
          if(data.error)
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
            reset_question_form();
            questionTable.ajax.reload();
            quizBankTable.ajax.reload();
            $('#questionModal').modal('hide');
            $('#edit_quest_Modal').modal('hide');

          }
          $('#btnQuestion_desc').attr('disabled', false);

          $('#btnQuestion_desc').val('Add');

        }
      });
    }
  });


/*   =========================== ================ edit question =================== ===========================  */

  var question_id = '';

  $(document).on('click','.edit_quest', function()
  {
        question_id = $(this).attr('id');
        reset_question_form();

        $.ajax({
          url:$('#url').val()+'/admin/editQuestion',
          method:"POST",
          data:{check:'edit_quest', question_id:question_id, page:'admin'},
          dataType:"json",
          success:function(data)
          {

            $('#question').val(data.Question);

            $('#optionA').val(data.Option_A);

            $('#optionB').val(data.Option_B);

            $('#optionC').val(data.Option_C);

            $('#optionD').val(data.Option_D);

            $('#correct').val(data.Answer);

            $('#question_id').val(question_id);

            $('#question_modal_title').text('Edit Question Details');

            $('#btnQuestion').val('Edit');

            $('#check').val('Edit_Quest_Done');

            $('#questionModal').modal('show');

          }

              });
  });

/*   =========================== ================ edit desc quest =================== ===========================  */
  var question_id = '';

  $(document).on('click','.edit_quest_desc', function()
  {
        question_id = $(this).attr('id');
        reset_question_form();

        $.ajax({
          url:$('#url').val()+'/admin/editQuestion',
          method:"POST",
          data:{check:'edit_quest_desc', question_id:question_id, page:'admin'},
          dataType:"json",
          success:function(data)
          {

            $('#question_desc').val(data.Question);

            $('#question_id_desc').val(question_id);

            $('#desc_modal_title').text('Edit Question Details');

            $('#btnQuestion_desc').val('Edit');

            $('#check').val('Edit_Quest_Desc');

            $('#edit_quest_Modal').modal('show');

          }

              });
  });

/*   =========================== ================ deleting question =================== ===========================  */

var question_id = '';
  $(document).on('click', '.delete_quest', function(){
    question_id = $(this).attr('id');
    exam_id = $(this).attr('data-id');
    $('#delete_quest_Modal').modal('show');
  });

  $('#delete_quest_Button').click(function(){
    $.ajax({
      url:$('#url').val()+'/admin/deleteQuestion',
      method:"POST",
      data:{question_id:question_id, exam_id:exam_id, check:'Delete_Quest', page:'quizBank'},
      dataType:"json",
      success:function(data)
      {
        $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
        questionTable.ajax.reload();
        quizBankTable.ajax.reload();
        $('#delete_quest_Modal').modal('hide');
      }
    })
  });

/*   =========================== ================  =================== ===========================  */
/*    =========================== Registered Users===========================  */

   var regUsersTable = $('#regUsersTable').DataTable({
   'processing': true,
   'serverSide': true,
   'serverMethod': 'post',
   'ajax':
   {
       'url':$('#url').val()+'/admin/getJQueryTable',
       'data':{check:'regUsersTableData', page:'viewUser'}
   },
   'columns': [

      { data: 'ID' },
      { data: 'Full-Name' },
      { data: 'Email' },
      { data: 'Mobile'},
      { data: 'Verified' },
   ]

 });
   $('#viewUser').click(function(){
     regUsersTable.ajax.reload();
 });
 /*   =========================== ================  =================== ===========================  */
 /*    =========================== Enrolled exam ===========================  */

    var enrollExamTable = $('#enrollExamTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax':
    {
        'url':$('#url').val()+'/admin/getJQueryTable',
        'data':{check:'enrollExamTableData', page:'enrollUser'}
    },
    'columns': [

       { data: 'Exam_ID' },
       { data: 'Exam_Title' },
       { data: 'Time' },
       { data: 'Enrolled_Users'},
    ]

  });
    $('#enrollUser').click(function(){
      enrollExamTable.ajax.reload();
  });

  /*   =========================== ================  =================== ===========================  */
  /*    =========================== Enrolled usser ===========================  */
var enroll_id = $('#enroll_id').val();
     var enrollUserTable = $('#enrollUserTable').DataTable({
     'processing': true,
     'serverSide': true,
     'serverMethod': 'post',
     'ajax':
     {
         'url':$('#url').val()+'/admin/getJQueryTable',
         'data':{check:'enrollUserTableData', page:'enrolledUser', exam_id:enroll_id}
     },
     'columns': [

        { data: 'User_ID' },
        { data: 'Name' },
        { data: 'Email' },
     ]

   });
  /*    =========================== Enrolled usser ends ===========================  */
  /*    =========================== Prepare Result ===========================  */



});
