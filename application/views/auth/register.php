<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col-lg">
					<div class="p-5">
						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
						</div>
						<form class="user" method="post" action="<?= base_url("auth/register"); ?>">
							<div class="form-group row">
								<div class="col-sm-6 mb-3 mb-sm-0">
									<input type="text" value="<?= set_value('name');?>" class="form-control form-control-user" id="name" name="name" placeholder="First Name">
									<?= form_error('name', '<small class="text-danger pl-3">','</small>'); ?>
								</div>
								<div class="col-sm-6">
									<input type="text" value="<?= set_value('last_name');?>"  class="form-control form-control-user" id="last_name" name="last_name" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<input type="email" value="<?= set_value('email');?>"  class="form-control form-control-user" id="email" name="email" placeholder="Email Address">
								<?= form_error('email', '<small class="text-danger pl-3">','</small>'); ?>
							</div>
							<div class="form-group row">
								<div class="col-sm-6 mb-3 mb-sm-0">
									<input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
									<?= form_error('password', '<small class="text-danger pl-3">','</small>'); ?>
								</div>
								<div class="col-sm-6">
									<input type="password" class="form-control form-control-user" id="password_rt" name="password_rt" placeholder="Repeat Password">
									<?= form_error('password_rt', '<small class="text-danger pl-3">','</small>'); ?>
								</div>
							</div>
							<button type="submit" name="submit" id="submit" class="btn btn-primary btn-user btn-block">
								Register Account
							</button>
						</form>
						<hr>
						<div class="text-center">
							<a class="small" href="forgot-password.html">Forgot Password?</a>
						</div>
						<div class="text-center">
							<a class="small" href="<?= base_url('auth')?>">Already have an account? Login!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
