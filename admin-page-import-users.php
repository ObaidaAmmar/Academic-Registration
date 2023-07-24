<!DOCTYPE html>
<html lang="en">
<head>
    <!--header start-->
    <?php
      require("templates/admin-header.php");
    ?>
    <!--header end-->
</head>
<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>
<body>
<?php
   session_start();
   require("classes/dal.php");
   require("classes/user_dal.php");
   require("classes/student_dal.php");
   require("templates/login_validate.php");
   require("templates/permissions.php");  
   
   $user_dal=new User_DAL();
   $student_dal=new Student_DAL();

    //get all enrolled students
   $students_info=$student_dal -> getAllStudents();
  ?>
<div class="main-container d-flex">
        <!--sidebar start-->
        <?php
          require("templates/admin-sidebar.php");
            ?>
        <!--sidebar end-->

        <!--Main content nav and body start-->
        <div class="content openSide">
            <!--navbar start-->
            <?php
              require("templates/admin-navbar.php");
             ?>
            <!--navbar end-->
            <!--breadcrumb start-->
            <?php
              require("templates/admin-breadcrumb.php");
            ?>
            <!--breadcrumb end-->
            <div class="container-fluid">
            <section id="users_import_accounts_section">
            <div class="container mt-5 bg-light rounded shadow p-5 mb-5 mx-sm-3 mx-lg-auto">
                <div class="row d-flex justify-content-center">
                  <div class="row p-3">
                  <!-- Import link -->
                   <div class="col-md-12 head">
                    <div class="float-start mb-4">
                      <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i>Import Accounts</a>
                    </div>
                   </div>
                  <!-- Excel file upload form -->
                  <div class="col-md-12" id="importFrm" style="display: none;">
                    <form class="row g-3" action="" enctype="multipart/form-data" id="import_accounts_form">
                      <div class="col-auto">
                        <label for="fileInput" class="visually-hidden">File</label>
                        <input type="file" class="form-control" name="file" id="fileInput" />
                      </div>
                      <div class="col-auto">
                        <input type="submit" class="btn btn-primary mb-3" name="importSubmit" value="Import" id="import_accounts">
                      </div>
                    </form>
                  </div>
                 </div>
                 <div class="col-sm-12 col-md-10 col-lg-6">
                   <h2 class="page-title">Student Accounts</h2>
                      <hr>
                 </div>
                </div>
                <div class="row">
                    <div class="col-12 overflow-auto p-3">
                        <table class="table table-striped" id="users_accounts_request_table">
                            <thead>
                                <tr>
                                    <td>Student ID</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Major</td>
                                    <td>Year</td>
                                    <td>Enrollment Date</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              foreach($students_info as $v){
                                ?>
                                <tr>
                                  <td class="p-2"><?php echo $v['StudentId']; ?></td>
                                  <td class="p-2"><?php echo $v['Fname'].' '.$v['Lname']; ?></td>
                                  <td class="p-2"><?php echo $v['Email']; ?></td>
                                  <td class="p-2"><?php $major = $student_dal -> getMajorName($v['Major']); echo $major[0]["Major"]; ?></td>
                                  <td class="p-2"><?php echo $v['Year']; ?></td>
                                  <td class="p-2"><?php echo $v['EnrollmentDate']; ?></td>
                                  <td class="p-2">
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-outline-success manage-student-account-btn p-2 mx-2"><i
                                                    class="fa-solid fa-check fa-lg mx-2 rounded"></i>Manage</button>
                                        </div>
                                    </td>
                                </tr>
                              <?php
                              }
                              ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
                <!--footer start -->
                <?php
                  require("templates/admin-footer.php");
                ?>
                <!-- footer end -->
                <!-- Blank End -->
            </div>
        </div>
    </div>
<!--scripts start-->
<?php
  require("templates/admin-scripts.php");
?>
<script src="js/admin-page-import-accounts.js"></script>
<!--scripts end-->
</body>
</html>