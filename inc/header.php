<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-4 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">

    <a class="navbar-brand me-4 fw-bold fs-4" href="main.php">
      <img src="images/bus_logo.png" height="60" width="60" alt="Logo">
      EASYBUS
    </a>

    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item">
          <a class="nav-link me-3 fs-5 fw-semibold" href="main.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-3 fs-5 fw-semibold" href="#contactUs">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-3 fs-5 fw-semibold" href="html/help.html">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-3 fs-5 fw-semibold" href="#links">Links</a>
        </li>
      </ul>

      <!-- Right-aligned login/register buttons -->
      <div class="d-flex align-items-center">
        <button type="button" class="btn btn-outline-dark shadow-none me-2" data-bs-toggle="modal" data-bs-target="#AdminloginModal">
          Admin Login
        </button>
        <button type="button" class="btn btn-outline-dark shadow-none me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
        </button>
        <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
          Register
        </button>
      </div>
    </div>

  </div>
</nav>


    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="login.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i> User login</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="pass" type="password" class="form-control shadow-none">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" class="btn btn-dark shadow-none">
                                Login
                            </button>
                            <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password</a>
                        </div>
                    </div>
                   
                </form>
            
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="register-form" action="register.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-file-person-fill"></i>> User Registration</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base"
                        >Note: Your details must match with your ID (Aadhaar Card, Passport, Driving Licence, etc.) that will be required during registration.</span>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input name="fname" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input name="lname" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input  name="phno" type="number" class="form-control shadow-none" required>
                                </div>
                            
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Password</label>
                                    <input name="pass" type="password" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input name="cpass" type="password" class="form-control shadow-none" required>
                                </div>
                                </div>
                            </div>
                            <div class="text-center my-1">
                                <a href="./html/home.html"></a><button type="submit" class="btn btn-dark shadow-none">
                                Sign in
                            </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>
    <div class="modal fade" id="AdminloginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="html/Admin.html" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i>Admin Login</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="pass" type="password" class="form-control shadow-none">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" class="btn btn-dark shadow-none">
                                Login
                            </button>
                            <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password</a>
                        </div>
                    </div>
                   
                </form>
            
            </div>
        </div>
    </div>
    </div>