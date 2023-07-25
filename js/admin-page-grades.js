//For Table Filters
$(document).ready(function(){
  $("#students_grades_table").dataTable();
  $("#courses_table").dataTable();
  $("#courses_grades_table").dataTable();

  $('#courses_table').on('click', '.btn-assign-grades', function () {
     var courseCode=$(this).parent().parent().find("td:eq(0)").text();
     window.location.href='admin-page-course-grades-assign.php?courseCode='+courseCode;
  });

  $('#submit_course_grades').on('click',function(){
    let courseCode=$('.course_code').text();
    let session1Array=[];
    let session2Array=[];
    let studentsIdArray=[];
    let enrollDatesArray = [];
    $('.studentId').each(function(){
      var stdId=parseInt($(this).text());
      studentsIdArray.push(stdId);
    });
    $('.session1_grade').each(function(){
      var grade=parseFloat($(this).val());
      session1Array.push(grade);
    });
    $('.session2_grade').each(function(){
      var grade=parseFloat($(this).val());
      session2Array.push(grade);
    });
    $('.enrollDate').each(function(){
      var date=$(this).text();
      enrollDatesArray.push(date);
    });

    $.ajax({
      url: "Actions/add_course_grades.php",
      type: "POST",
      data: {
        courseCode:courseCode,
        studentsId:studentsIdArray,
        session1Grades:session1Array,
        session2Grades:session2Array,
        enrollDates:enrollDatesArray
      },
      dataType: "json",
      success: function (dataResult) {
        if (dataResult.result) {
          swal(
            "Submit Course Grade Success",
            "You Submit The Grades Of Course "+courseCode,
            "success"
          ).then((value) => {
            window.location.href='admin-page-assign-grades.php';
          });
        } else {
          swal("Submit Course Grade Failed!!", dataResult.error, "error");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error: " + textStatus + " " + errorThrown);
      },
    });
  });
});

