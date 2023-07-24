#Project Title
Academic Registration

#Description
This project is developed to automate the process of student registration in courses at the Lebanese University Faculty of Science. Until now, it only supports the Department of Computer Science; However, it could be improved later to support all Departments in the Faculty of Science. Students will also be able to view their grades when they are published. Admins are responsible for **importing students account** or **accept-reject students signup requests**, also admins can **accept-reject student registration requests in courses** ,**import students grades for their registered courses** or **assign grades for each student separately** as well as **add admins to sites** .

#Installation and requirements
- Install an ide for web development like VsCode. from: https://code.visualstudio.com/download
- Install and configure PHP. from: https://www.php.net/manual/en/install.php
- Install xampp. from: https://www.apachefriends.org/download.html
- Install Composer which is a dependancy management tool for PHP, inlcude it in the classpath to the project this is used to send OTP code to email. from: https://getcomposer.org 
- After Installing xampp turn on the servers, **MySQL Database** / **ProFTPD** / **Apache Web Server**
- Search for phpmyadmin in your browser or simply search for http://localhost/phpmyadmin/ 
  - create a database called **FacultyOfScience**
  - and import the database which could be found in the project in **Database** folder.
- In your project, open a terminal window in vscode and enter the command **composer require phpmailer/phpmailer** , this is used to send otp verification code in order to change account password.
- In your project, open a terminal window in vscode and enter the command **composer require phpoffice/phpspreadsheet** , this is used for importing and processing excel files. composer command should be recognized after you have installed it in step 4.
- After you are done with previous steps, open the browser and search for **http://localhost/academic-registration/index.php** , it must launch the landing page of the project, from which we can go to Login or SignUp page.

#Usage
- After launching the project **http://localhost/academic-registration/index.php** , a user can go to Login or SignUp page.
- SignUp page: Mainly admins import students account from the admin page which will be discusses in later steps. However, a student already registered at the Lebanese University - Faculty of Science, can enter his credentials including the ID given to him upon physical registration at the University and request to signup, later on and admin can accept or reject his request based on the credentials enetered. If a student with the same id or email already exist in database the request will not be fulfilled.
- Login page: This page is used by Students or Admins in order to access the site. Students with a valid email and password (account already exist in database) will be directed to user-page. Also, Admins with a valid email and password (account already exist in database) will be directed to admin-page.
- Forgot Password Page: In case a student forgot his account password he could request to change it.
  - First he must enter his email which is used to access the site.
  - If his email is valid, an OTP code will be sent to this email and he will be redirected to a page to verify the OTP sent.
  - If he enters the correct OTP code, he will be redirected to a page to change his password.
- User Page: After a successfull login by a student, he will be redirected to the user-page which he will be able to: 
  - Register in courses based on certain criteria provided by the university.
  - View his grades in courses that he is enrolled in when they are published.
  - Manage his profile **upload a photo** , **change email**, **change password** .
  - **changing the email requires verifiying that it belongs to him through an OTP verification code** .
- Admin Page: After a successfull login by an Admin, he will be redirected to the admin-page which he will be able to: 
  - Accept/Reject student request to access the site (to have accounts) from Step 2 in SignUp page.
  - Admin can instead Import an excel file which contains students account the file must contain:
    - Student Id, First Name, Last Name, Email, Password, Major = (1 for Computer Science), Year = (2 accounts are provided to students starting from year 2), Enrollment Date (student enrollment date in the University).
  - Admin can assign grades to students:
    - Admin can choose a particular course to assign grades for student enrolled in it.
    - Either he can assign grades for each student separately
    - Or he can import an excel file of grades for this particular course, the file must contain:
      - Student Id, First Name, Last Name, Session 1 (grades for session 1, empty in case no grade), Session 2 (grades for session 2, empty in case no grade), Enrollment Date (date of student enrollment in this course)
      - This excel file is related to a specific course so no need to specify course code in the file. So each course must have an excel file of students grades.
    - Admin can manage student registration to enroll in courses.
      - Either he can accept or reject or manage the registration request.
      - Managing the registration request allows an admin to remove/add a course requested to be enrolled in by student.
      - At the end of the year, an admin must delete all registration requests in order to allow the student to register in courses the next year.
  - Admin can add new admins.

#Important Data
- In order to access the site **For Testing** here is a list of accounts that already exist in database:
  - **Students Accounts** :
    - StudentId: 677833 email: obaidaammar99@gmail.com  password: OA99
    - StudentId: 3212 email: amd@gmail.com  password: 1232
    - StudentId: 109987 email: fsami@gmail.com password: Sami@1
    - StudentId: 109982 email: mohd2001af@gmail.com  password: 12344
    - StudentId: 78675 email: moh@gmail.com  password: 123
    - StudentId: 109656 email: ahmad@gmail.com  password: 12345
    - StudentId: 108856 email: testMail@gmail.com  password: 1234321
  - **Admin Accounts** :
    - email: admin1_ad@gmail.com  password: admin@ad1

#Contributions:
- This project was developed by:
  - Obaida Ammar
  - Osama Zammar
  - Mohammad Abou Alfoul

#Contact Information
- **Obaida Ammar**
  - LinkedIn: https://www.linkedin.com/in/obaida-ammar
  - Instagram: https://www.instagram.com/obaida_ammar
  - Facebook: https://www.facebook.com/obaida.ammar

  
