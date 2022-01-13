<style type="text/css">
    .login-form {
        width: 385px;
        margin: 0px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .login-btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .input-group-addon .fa {
        font-size: 18px;
    }

    .login-btn {
        font-size: 15px;
        font-weight: bold;
    }

    .social-btn .btn {
        border: none;
        margin: 10px 3px 0;
        opacity: 1;
    }

    .social-btn .btn:hover {
        opacity: 0.9;
    }

    .social-btn .btn-primary {
        background: #507cc0;
    }

    .social-btn .btn-info {
        background: #64ccf1;
    }

    .social-btn .btn-danger {
        background: #df4930;
    }

    .or-seperator {
        margin-top: 20px;
        text-align: center;
        border-top: 1px solid #ccc;
    }

    .or-seperator i {
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -11px;
        z-index: 1;
    }
</style>

<div class="container">
    <div class="login-form">
        <form action="" method="post" id="registerForm">
            <h2 class="text-center">Sign up</h2>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="username" class="form-control" id="rusername" name="username" placeholder="Username"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="remail" name="email" placeholder="Email" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" id="rpassword" name="password" placeholder="Create Password" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" id="rcpassword" name="repassword" placeholder="Repeat Password" required="required">
                </div>
            </div>
            <!-- form-group end.// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary login-btn btn-block">Sign up</button>
            </div>
            <div class="or-seperator"><i>or</i></div>
            <p class="text-center">Sign up with your social media account</p>
            <div class="text-center social-btn">
                <a href="#" class="btn btn-primary" id="facebook"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                <a href="#" class="btn btn-danger" id="google"><i class="fa fa-google"></i>&nbsp; Google</a>
            </div>
        </form>
        <p class="text-center text-muted small">Already have an account? <a href="signin.php">Sign in here!</a></p>
    </div>
</div>