<?php 
  session_start();
  
  // Include PhpSpreadsheet library autoloader 
  require_once '../vendor/autoload.php'; 
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    
    if(isset($_FILES['file']))
    {       
            require("../classes/dal.php");
            require("../classes/student_dal.php");
            require("../classes/grades_dal.php");
            require("../classes/courses_dal.php");

            $student_dal=new Student_DAL();
            $grade_dal = new Grades_DAL();
            $course_dal = new Course_DAL();

            // Allowed mime types 
            $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
   
            // Validate whether selected file is a Excel file 
            if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes))
            { 
             // If the file is uploaded 
             if(is_uploaded_file($_FILES['file']['tmp_name']))
             {  
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 

                // Remove header row 
                unset($worksheet_arr[0]); 
                $finalResult = 0;
                
                $count=0;
                foreach($worksheet_arr as $row) 
                {   
                    $student_id = (int)$row[0];
                    
                    $session_one = $row[3]; 
                    $session_two = $row[4];
                    $enrollment_date = $row[5];
                    $course_id = (int)$course_dal->getIdFromCode($_POST["course_code_value"]);
                    
                    $student_not_found = "";
                    if (!$grade_dal->GradeRowExists($student_id, $course_id, $enrollment_date)){
                        $student_not_found .= "$student_id - ";
                        continue;
                    }
                    
                    $course_grade = $session_one;
                    if($session_two != '')
                        $course_grade = $session_two;
                    if ($session_two == '')
                        $session_two = NULL;

                    $grade_dal -> editStudentCourseGrade($course_id, $student_id, $course_grade, $session_one, $session_two, $enrollment_date);
                    
                    //make the student go up a year if all grades have been given
                    require("increment_student_year.php");
                    
                    ++$finalResult;
                } 
                if($finalResult>0)
                    {
                        $v=array(
                        'result'=>true,
                        'not found'=>$student_not_found,
                        'error'=>'no error'
                        );
                    }
                else 
                    {
                        $v=array(
                        'result'=>false,
                        'not found'=>$student_not_found,
                        'error'=>'exist in database'
                        );
                    }
                    $dataResult=$v;
                    echo json_encode($dataResult);
                
            }
           }
        }
    
        
?>