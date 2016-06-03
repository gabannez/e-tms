<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Sign On</div>
			<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
		</div>
		
		<div style="padding-top:30px;" class="panel-body">
			
			<div class="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
			
			<?php echo validation_errors(); ?>
			
			<?php echo form_open('login'); ?>	
			<div class="form-horizontal">
				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="username" type="text" class="form-control" name="username" value="" placeholder="username">
				</div>
				
				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="password" value="" placeholder="password">
				</div>
				
				<!-- Remember Me
				<div class="input-group">
					<div class="checkbox">
						<label>
							<input id="remember" type="checkbox" name="remember_me"> Remember me
						</label>
					</div>
				</div>
				!-->
				
				<div style="margin-top:10px" class="form-group">
					<div class="col-sm-12 controls">
						 <center><button type="submit" onClick="location.href='index.php/login'" class="btn btn-success">Login </button></center>
					</div>
				</div>
				
				<div style="margin-top:10px" class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #888; padding-top:15px; font-size:85%">
								Don't have an account!
							<a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
								Sign Up Here
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php form_close(); ?>
		</div>
	</div>
</div>

<!-- Signup box -->
<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Sign Up</div>
			<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
		</div>
		<div class="panel-body">
			<form id="signupform" class="form-horizontal" role="form">
				<div id="signupalert" stype="display:none" class="alert alert-danger">
					<p>Error:</p>
					<span></span>
				</div>
				
				<div class="form-group">
				</div>
			</form>
		</div>
	</div>
</div>
