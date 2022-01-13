<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 50px auto;
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
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {
        font-size: 15px;
        font-weight: bold;
    }
</style>
<div class="login-form">
    <form action="" method="post" id="registerForm">
        <h2 class="text-center">Enter your Email</h2>
				<div class="form-group">
						<input type="text" name="femail" id="femail" class="form-control validate[required,custom[email]]" placeholder="Email" required="required">
				</div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Recover</button>
        </div>
    </form>
</div>
