

	<script type="text/javascript">
				// EVENTOS PARA INICIAR Y LOGIN:
				$('#frm_login input[name=login_user], #frm_login input[name=login_password]').keyup(function(event){
					if (event.keyCode == '13') {
							event.preventDefault();
							eglobalinvoice.login();
					}
				});
	</script>

	<section class="ftco-section">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-6 text-center mb-2">
							<h2 class="heading-section" style="margin:0;"></h2>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-12 col-lg-10">
							<div class="wrap d-md-flex">
								<div class="img" style="background-image: url(img/bg-1.png);">
								</div>
								<div class="login-wrap p-4 p-md-5">
									<div class="d-flex">
										<div class="w-100 text-center">
											<h3 class="mb-4"><img src="img/img-login/img-login-logo-top.png" alt="Logo" style="height:70px !important;"></h3>
										</div>
											<!--
										<div class="w-100">
											<p class="social-media d-flex justify-content-end">
												<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
												<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
											</p>
										</div>
										-->
									</div>
									<form action="#" class="signin-form" id="frm_login">
										<div class="form-group mb-3">
											<label class="label" for="name">Username</label>
											<input type="text" name="login_user" id="login_user" class="form-control" placeholder="Username" required>
										</div>
										<div class="form-group mb-3">
											<label class="label" for="password">Password</label>
											<input type="password" name="login_password" id="login_password" class="form-control" placeholder="Password" required>
										</div>
										<div class="form-group">
											<button type="button" class="form-control btn btn-primary rounded submit px-3" onclick="eglobalmve.login();">Iniciar</button>
										</div>
										<div class="form-group d-md-flex">
												<!--
											<div class="w-50 text-left">
												<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
												<input type="checkbox" checked>
												<span class="checkmark"></span>
												</label>
												-->
											</div>
											<div class="mt-5 w-50 text-md-right">
												<a href="#">¿Recuperar contraseña?</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
	 </section>