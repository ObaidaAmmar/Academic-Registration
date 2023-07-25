<?php

    class Grades_DAL extends DAL{

      public function getAllStudentsGrades()
      {
          $sql = "SELECT C.CourseCode, 
                         C.CourseName,
                         C.Credits,
                         G.StudentId,
                         S.Fname,
                         S.Lname,
                         M.Major,
                         G.Grade
                         FROM Courses As C, Grades AS G, Students AS S, Majors AS M
                         WHERE G.CourseId = C.CourseId 
                         AND S.StudentId = G.StudentId
                         AND M.Id = S.Major
                         AND G.Grade IS NOT NULL
                  ";
          $grades = $this -> getData($sql);
          return $grades;
      }

      public function getGradesForStudent($student_id, $e_date){
        $sql = "SELECT Grade FROM Grades WHERE StudentId = $student_id AND EnrollmentDate = '$e_date'";
        $grades = $this -> getData($sql);
        return $grades;
      }

      public function editStudentCourseGrade($courseId,$studentId,$courseGrade, $session1, $session2, $e_date){
        $conn = $this->getConnection();
        $courseId= mysqli_real_escape_string( $conn, $courseId );
        $studentId= mysqli_real_escape_string( $conn, $studentId );
        $courseGrade= mysqli_real_escape_string( $conn, $courseGrade );
        $session1= mysqli_real_escape_string( $conn, $session1 );
        $session2= mysqli_real_escape_string( $conn, $session2 );
        $e_date= mysqli_real_escape_string( $conn, $e_date );

        if($session1 == '' && $session2 == '')
        {
          $sql="UPDATE Grades SET Grades.Grade=NULL, Grades.SessionOne = NULL, Grades.SessionTwo = NULL WHERE Grades.StudentId=$studentId AND Grades.CourseId=$courseId AND EnrollmentDate = '$e_date'";
        }
        if ($session2 == ''){
          $sql="UPDATE Grades SET Grades.Grade=$session1, Grades.SessionOne = $session1, Grades.SessionTwo = NULL WHERE Grades.StudentId=$studentId AND Grades.CourseId=$courseId AND EnrollmentDate = '$e_date'";
        }
        else if($session1 == '')
        {
          $sql="UPDATE Grades SET Grades.Grade=$session2, Grades.SessionOne = NULL, Grades.SessionTwo = $session2 WHERE Grades.StudentId=$studentId AND Grades.CourseId=$courseId AND EnrollmentDate = '$e_date'";
        }
        else{
          $sql="UPDATE Grades SET Grades.Grade=$courseGrade, Grades.SessionOne = $session1, Grades.SessionTwo = $session2 WHERE Grades.StudentId=$studentId AND Grades.CourseId=$courseId AND EnrollmentDate = '$e_date'";
        }
        return $this->update($sql);
      }

      public function GradeRowExists($student_id, $course_id, $e_date){
        
        $sql = "SELECT *
                FROM Grades AS G
                WHERE G.StudentId = $student_id
                AND G.CourseId = $course_id
                AND G.EnrollmentDate = '$e_date'";
                
          $row_exist = $this -> getData($sql);
          return count($row_exist)>0;
      }
      
    }

?>