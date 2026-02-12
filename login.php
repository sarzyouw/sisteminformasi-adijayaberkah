<!doctype html>
<html lang="en">
  <head>
    <title>Serba Furniture - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
      html, body {
        height: 100%;
        overflow: hidden;
        font-family: 'Lato', sans-serif;
      }
      .js-fullheight {
        height: 100%;
      }
      .ftco-section {
        height: 100%;
        display: flex;
        align-items: center;
        background-color: rgba(0,0,0,0.5);
      }
      .social a {
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
      }
      .social a span {
        margin-right: 10px;
      }
      .login-wrap {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      .heading-section {
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        font-weight: 700;
      }
      .form-control {
        height: 50px;
        background: #f8f9fa;
        border: none;
        border-radius: 5px;
      }
      .btn-primary {
        background-color: #8B4513;
        border: none;
        font-weight: 600;
      }
      .btn-primary:hover {
        background-color: #A0522D;
      }
      .field-icon {
        float: right;
        margin-right: 10px;
        margin-top: -30px;
        position: relative;
        z-index: 2;
        cursor: pointer;
        color: #555;
      }
      .checkbox-wrap {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
      }
      .checkbox-wrap input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
      }
      .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #f8f9fa;
        border-radius: 3px;
      }
      .checkbox-wrap input:checked ~ .checkmark {
        background-color: #8B4513;
      }
      .checkmark:after {
        content: "";
        position: absolute;
        display: none;
      }
      .checkbox-wrap input:checked ~ .checkmark:after {
        display: block;
      }
      .checkbox-wrap .checkmark:after {
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
      }
      body.img {
        background-image: url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }
      .logo {
       width: 165px;
       height: auto;
       display: block;
       margin: 20px auto 0 auto;
}

    </style>
  </head>
  <body class="img js-fullheight">
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
          <img src="images/logo1.PNG" alt="Serba Furniture Logo" class="logo">
            <h2 class="heading-section">Welcome to Adi Jaya Berkah</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-4 p-md-5">
              <h3 class="mb-4 text-center">Login</h3>
              <form action="#" class="signin-form">
                <div class="form-group mb-3">
                  <input type="text" class="form-control" placeholder="Username" required disabled>
                </div>
                <div class="form-group mb-3">
                  <input id="password-field" type="password" class="form-control" placeholder="Password" required disabled>
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group mb-3">
                  <button type="button" id="auto-login" class="form-control btn btn-primary submit px-3">Sign In</button>
                </div>
                <div class="form-group d-md-flex mb-3">
                  <div class="w-50">
                    <label class="checkbox-wrap checkbox-primary">Remember Me
                      <input type="checkbox" checked disabled>
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="w-50 text-md-end">
                    <a href="#" style="color: #8B4513">Forgot Password</a>
                  </div>
                </div>
              </form>
              <p class="text-center">Not a member? <a href="#" style="color: #8B4513">Sign up</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function(){
        // Auto login functionality
        $("#auto-login").click(function() {
          // Simulate loading/processing
          $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...');
          
          // Redirect after a short delay (simulate login process)
          setTimeout(function() {
            window.location.href = "home.php"; // Ganti dengan halaman tujuan setelah login
          }, 1000);
        });
        
        // Disable form submission
        $(".signin-form").submit(function(e) {
          e.preventDefault();
          $("#auto-login").click();
        });
        
        $(".toggle-password").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $($(this).attr("toggle"));
          if (input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
        });
      });
    </script>
  </body>
</html>