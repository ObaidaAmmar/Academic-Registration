<?php
    
    class Student_DAL extends DAL {

        public function getStudentInfo($student_id)
        {
            $sql = "SELECT * FROM Students WHERE StudentId = $student_id";
            $info = $this -> getData($sql);
            return $info;
        }

        public function getAllStudents()
        {
            $sql = "SELECT * FROM Students";
            $info = $this -> getData($sql);
            return $info;
        }
        public function getAllMajors(){
            $sql="SELECT * FROM Majors";
            return $this->getData($sql); 
        }
        public function getMajorName($majorId)
        {
            $sql = "SELECT Major FROM Majors WHERE Id = $majorId";
            $info = $this -> getData($sql);
            return $info;
        }

        public function isEmailExist($student_id,$email)
        {
            $sql = "SELECT StudentId FROM Students WHERE Email = '$email' AND StudentId<>$student_id";
            $info = $this -> getData($sql);
            return $info;
        }

        public function idExist($student_id)
        {
            $sql = "SELECT StudentId FROM Students WHERE StudentId = $student_id";
            $info = $this -> getData($sql);
            return $info;
        }

        public function emailExist($email)
        {
            $sql = "SELECT StudentId FROM Students WHERE Email = '$email'";
            $info = $this -> getData($sql);
            return $info;
        }

        public function getStudentAsID($stdId){
            $conn = $this->getConnection();
            $stdId= mysqli_real_escape_string( $conn, $stdId );
            $sql="SELECT
            students.StudentId,
            students.Fname,
            students.Lname,
            students.Email,
            students.Password,
            students.Major,
            students.Year,
            students.EnrollmentDate
        FROM
            students
        WHERE
            students.StudentId=$stdId";
            return $this -> getDataAssoc($sql);
        }

        public function getStudentGrades($student_id, $year, $semester)
        {
            $sql = "SELECT C.CourseCode, 
                           C.CourseName,
                           C.Credits,
                           C.Optional,
                           G.SessionOne,
                           G.SessionTwo,
                           G.Grade
                           FROM Courses As C, Grades AS G
                           WHERE G.CourseId = C.CourseId 
                           AND G.StudentId = '{$student_id}' 
                           AND C.Year = '{$year}' 
                           AND C.Semester = '{$semester}'";
            $grades = $this -> getData($sql);
            return $grades;
        }

        //This function is used to get the student max year which he is enrolled in and has grades
        //It is used to display the grades based on the year incase he registered in this year courses and have grades
        public function getStudentYear($student_id)
        {
            $sql = "SELECT MAX(C.Year)
                    FROM Courses AS C, Grades AS G
                    WHERE C.CourseId = G.CourseId
                    AND G.StudentId = '{$student_id}'
                    AND G.Grade IS NOT NULL";
            
            $year = $this -> getData($sql);
            return $year[0]["MAX(C.Year)"];

        }

        //Get all students enrolled in a certain course
        public function getStudentsInCourse($courseCode)
        {
          $sql = "SELECT 
                         S.StudentId,
                         S.Fname,
                         S.Lname,
                         G.SessionOne,
                         G.SessionTwo,
                         G.Grade,
                         G.EnrollmentDate
                         FROM Grades AS G,Students AS S,Courses AS C
                         WHERE S.StudentId = G.StudentId
                         AND G.CourseId = C.CourseId
                         AND C.CourseCode = '$courseCode'";
                  
          $course_students = $this -> getData($sql);
          return $course_students;
        }

        public function registerCourses($student_id, $choosenCourses, $studentMessage)
        {
            $sql = "INSERT INTO CoursesRegistration
                        (StudentId, 
                         Courses, 
                         StudentMessage, 
                         Status) 
                     VALUES
                        ($student_id, 
                         '$choosenCourses', 
                         '$studentMessage', 
                         0)";

            return $this -> update($sql); 

        }

        //this function checks if student has registered in courses
        //used to prevent student to submit another registration request if he/she already did
        public function studentRegisteredInCourses($student_id)
        {
            $sql = "SELECT * FROM CoursesRegistration WHERE StudentId = $student_id";
            $result = $this -> getData($sql);
            return $result;
        }

        public function getGradesAssocArray($student_id){
            $sql = "SELECT CourseId, Grade FROM Grades WHERE StudentId = $student_id";
            $res = $this->getData($sql);
            $arr = array();
            foreach ($res as $r){
                $arr += array($r["CourseId"] => $r["Grade"]);
            }
            return $arr;
        }

        public function getAverage($student_id, $year, $semester){
            $sql = "SELECT C.CourseId, G.Grade
                    FROM Courses As C, Grades AS G
                    WHERE G.CourseId = C.CourseId 
                    AND G.StudentId = $student_id 
                    AND C.Year = $year
                    AND C.Semester = $semester";
            
            $grades = $this->getData($sql);
            $course_dal = new Course_DAL();
            $credits = $course_dal->getCourseCreditsAssoc($year);
            $creditSum = 0;
            $gradeSum = 0;
            foreach ($grades as $g){
                $grade = $g["Grade"];
                $credit = $credits[$g["CourseId"]];
                $gradeSum += $grade*$credit;
                $creditSum += $credit;
            }
            if ($creditSum == 0)
                return 0;
            return $gradeSum / $creditSum; 
        }

        public function passedWithAverage($student_id){
            $avg1 = $this->getAverage($student_id, 1, 1);
            $avg2 = $this->getAverage($student_id, 1, 2);
            $avg = ($avg1 + $avg2) / 2;

            if ($avg > 49.99)
                return true;
            return false;
        }

        public function updateStudentProfile($studentId, $email, $password, $image)
        {   
            
            $sql = "UPDATE Students SET
                    Email = '{$email}',
                    Password = '{$password}',
                    Image = '{$image}'
                    WHERE StudentId = $studentId";
            
            $result = $this -> update($sql);
            
            return $result;
        }

        public function updateStudentAccount($student_id,$fname,$lname,$email,$password,$major,$year,$enrolment_date)
        {   
            
            $sql = "UPDATE Students SET
                    Fname = '{$fname}',
                    Lname = '{$lname}',
                    Email = '{$email}',
                    `Password` = '{$password}',
                    Major = $major,
                    `Year` = $year,
                    EnrollmentDate = '{$enrolment_date}'
                    WHERE StudentId = $student_id";
            
            $result = $this -> update($sql);
            
            return $result;
        }

        public function getCurrentStudentYear($student_id){
            $sql = "SELECT `Year` FROM Students WHERE StudentId = $student_id";
            $result = $this -> getData($sql);
            return $result[0]["Year"];
        }

        public function incrementYear($student_id){   
            $oldyear = $this->getCurrentStudentYear($student_id);
            $newYear = $oldyear + 1;
            $sql = "UPDATE Students SET `Year` = $newYear WHERE StudentId = $student_id";
            $result = $this -> update($sql);
            return $result;
        }

        public function updateStudentEmailPassword($studentId, $email, $password)
        {   
            
            $sql = "UPDATE Students SET
                    Email = '{$email}',
                    Password = '{$password}'
                    WHERE StudentId = $studentId";
            
            $result = $this -> update($sql);
            
            return $result;
        }

        public function updateAccountPassword($email, $password)
        {   
            
            $sql = "UPDATE Students SET
                    Password = '{$password}'
                    WHERE Email = '{$email}'";
            
            $result = $this -> update($sql);
            
            return $result;
        }

        public function getStudentImage($student_id)
        {
            $sql = "SELECT Image FROM Students WHERE StudentId = $student_id";

            $result = $this -> getDataAssoc($sql);
            return $result;
        }
        
        public function addStudent($student_id,$fname,$lname,$email,$password,$major,$year,$enrolment_date){
            $conn = $this->getConnection();
            $student_id= mysqli_real_escape_string( $conn, $student_id );
            $fname= mysqli_real_escape_string($conn, $fname);
            $lname= mysqli_real_escape_string($conn, $lname);
            $email= mysqli_real_escape_string($conn, $email);
            $password= mysqli_real_escape_string($conn, $password);
            $major= mysqli_real_escape_string($conn, $major);
            $year= mysqli_real_escape_string($conn, $year);
            $enrolment_date= mysqli_real_escape_string($conn, $enrolment_date);
            $sql="INSERT
            INTO
                students(
                    students.StudentId,
                    students.Fname,
                    students.Lname,
                    students.Email,
                    students.Password,
                    students.Major,
                    students.Year,
                    students.EnrollmentDate
                )
            VALUES(
                $student_id,
                '$fname',
                '$lname',
                '$email',
                '$password',
                $major,
                $year,
                '$enrolment_date'
            )";
            return $this->update($sql);
        }

        public function getStudentsRequestsRejestrationAsStatus($status){
            $conn = $this->getConnection();
            $status= mysqli_real_escape_string( $conn, $status);
            $sql="SELECT
            students.StudentId,
            students.Fname,
            students.Lname,
            students.Email,
            coursesregistration.Courses,
            coursesregistration.StudentMessage,
            coursesregistration.Status
        FROM
            students
        INNER JOIN coursesregistration ON coursesregistration.StudentId = students.StudentId
        WHERE
            coursesregistration.Status = $status";
            return $this -> getData($sql);
        }
        public function getTotalStudents(){
            $sql="SELECT COUNT(students.Id) AS 'total_students' FROM students";
            $res=$this->getDataAssoc($sql);
            return $res['total_students'];
        }
        public function getTotalRequestsRegisterCourses(){
            $sql="SELECT COUNT(*) AS 'total_register_request' FROM coursesregistration WHERE coursesregistration.Status=1";
            $res=$this->getDataAssoc($sql);
            return $res['total_register_request'];
        }
        public function editStatusRegester($stdId,$status) {
            $conn = $this->getConnection();
            $stdId= mysqli_real_escape_string( $conn, $stdId );
            $status= mysqli_real_escape_string( $conn, $status );
            $sql="UPDATE coursesregistration SET coursesregistration.Status=$status WHERE coursesregistration.StudentId=$stdId";
            return $this->update($sql);
        }
        public function editAdminMessage($stdId,$message){
            $conn = $this->getConnection();
            $stdId= mysqli_real_escape_string( $conn, $stdId );
            $message=mysqli_real_escape_string( $conn, $message );
            $sql="UPDATE coursesregistration SET coursesregistration.AdminMessage='$message' WHERE coursesregistration.StudentId=$stdId";
            return $this->update($sql);
        }
        public function addRegesterStudentCourse($stdId,$courseId,$major,$enrolment_date){
            $conn = $this->getConnection();
            $stdId= mysqli_real_escape_string( $conn, $stdId );
            $courseId=mysqli_real_escape_string( $conn, $courseId );
            $major=mysqli_real_escape_string( $conn, $major );
            $enrolment_date=mysqli_real_escape_string( $conn, $enrolment_date );
            $sql="INSERT INTO grades (grades.StudentId,grades.CourseId,grades.Major,grades.EnrollmentDate) VALUES ($stdId,$courseId,$major,'$enrolment_date')";
            return $this->update($sql);
        }
        public function editRegesterCoursesAdminMessage($stdId,$message){
            $sql="UPDATE coursesregistration SET coursesregistration.AdminMessage='$message' WHERE coursesregistration.StudentId=$stdId AND coursesregistration.Status=0";
            return $this->update($sql);
        }
        public function getStudentRequestRegiterCourses($stdId){
            $conn = $this->getConnection();
            $stdId= mysqli_real_escape_string( $conn, $stdId );
            $sql="SELECT
            coursesregistration.StudentId,
            coursesregistration.Courses,
            coursesregistration.StudentMessage,
            coursesregistration.AdminMessage,
            coursesregistration.Status
        FROM
            coursesregistration
        WHERE
            coursesregistration.StudentId =$stdId AND coursesregistration.Status = 0";
            return $this -> getDataAssoc($sql);
        }
        public function deleteAllStudentRegisterCourses() {
            $sql="DELETE FROM coursesregistration";
            return $this->update($sql);
        }
    }
?>