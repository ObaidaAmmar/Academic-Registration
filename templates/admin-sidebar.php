<div class="slidebar sticky-top openSide" id="slide_nav">
    <div class="header-box px-4 py-4 d-flex
                    justify-content-between">
        <h1 class="fs-4"><span class="bg-white text-dark rounded
                            shadow px-2 me-2">LU</span><span class="text-white">Admin</span></h1>
        <button class="btn close-btn px-1 py-0
                        text-white"><i class="fa-solid fa-stream"></i></button>
    </div>
    <ul class="list-unstyled px-3">
        <li class="mb-3 dashbord"><a href="admin-page.php" class="text-decoration-none px-3 py-2 d-block active"><i
                    class="fa-solid fa-home fa-lg"></i> <span class="mx-2">Dashbord</span></a></li>
        <li class="mb-3 request-users"><a href="admin-page-request-users.php" class="text-decoration-none
                            px-3 py-2 d-block"> <i class="fa-solid fa-users fa-lg"></i></i>
                <span class="mx-2">Users</span></a></li>
        <li class="nav-item dropdown mb-3 w-100 students"><a href="#" class="nav-link dropdown-toggle text-decoration-none
                                    px-3 py-2 d-block" data-bs-toggle="collapse" data-bs-target="#students-collapse"
                aria-expanded="false"> <i class="fa fa-solid fa-user-graduate fa-lg"></i>
                <span class="mx-2">Students</span></a>
            <div class="collapse bg-transparent border-0" id="students-collapse">
                <a href="admin-page-student-request-rejester.php?status=0" class="dropdown-item request_register">Request Register</a>
                <a href="admin-page-student-request-rejester.php?status=1" class="dropdown-item rejected_register">Rejected</a>
                <a href="admin-page-student-request-rejester.php?status=2" class="dropdown-item accepted_register">Accepted</a>
            </div>
        </li>
        <li class="nav-item dropdown mb-3 w-100 users"><a href="show_users.php" class="nav-link dropdown-toggle text-decoration-none
                                    px-3 py-2 d-block" data-bs-toggle="collapse" data-bs-target="#user-collapse"
                aria-expanded="false"> <i class="fa-solid fa-user fa-lg"></i>
                <span class="mx-2">Users</span></a>
            <div class="collapse bg-transparent border-0" id="user-collapse">
                <a href="show_users.php" class="dropdown-item all_users">All Users</a>
                <a href="#" class="dropdown-item all_user_types">Users Types</a>
            </div>
        </li>
    </ul>
</div>