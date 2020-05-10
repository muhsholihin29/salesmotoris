<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/register.css') }}">
	<!-- <link rel="stylesheet" href="{{ asset('assets/table_horz_scroll/vendor/bootstrap/css/bootstrap.min.css') }}"> -->
</head>
<!-- page content -->
<body>
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="title_left">
				<h3>Pendaftaran Sales</h3>

			</div>
		</div>
		<section class="ftco-section">
			<div class="container-reg">
				<h2>Form Pendaftaran</h2>
				<form action="<?php echo url('/');?>/sales/register" method="POST">			
					{{csrf_field()}}
					<div class="input-group input-group-icon">				
						<input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
						<div class="input-icon">
							<i class="fa fa-user"></i>
						</div>
					</div>
					<div class="input-group input-group-icon">				
						<input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
						<div class="input-icon">
							<i class="fas fa-user-circle"></i>
						</div>
						<span id="error_username"></span>
					</div>
					<div class="input-group input-group-icon">				
						<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
						<div class="input-icon">
							<i class="far fa-envelope"></i>
						</div>
						<span id="error_email"></span>
					</div>
					<div class="input-group input-group-icon">
						<input type="password" class="form-control" name="password" placeholder="Password" required>
						<div class="input-icon">
							<i class="fas fa-key"></i>
						</div>
					</div>
					<input type="submit" class="btn btn-success" value="Kirim" id="submit" disabled="">	
				</form>

			</div>
		</section>
	</div>
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var formUsername = false;
		var formEmail = false;
		$(document).ready(function(){
			$('#username').blur(function(){
				$('#submit').attr('disabled','disabled');
				$('#error_username').html('<label >Checking...</label>');
				var username = $('#username').val();
				if (username != '') { 	
					$.ajax({
						url: "{{ url('/sales/register/cek-username') }}",   
						method:"POST", 
						data:{username:username}, 
						dataType:"text", 
						success:function(result) {    
							console.log(result);
							if (result == 'false') {
								$('#error_username').html('<label class="text-danger">Username telah terdaftar</label>');
								$('#username').addClass('has-error');
								// $('#submit').attr('disabled','disabled');
								formUsername = false;
								// console.log(false);
								// console.log('false');
							}else{
								$('#error_username').html('');
								$('#username').removeClass('has-error');
								// $('#submit').attr('disabled',false);
								formUsername = true;
								console.log(username);
								console.log('true');
							}

							if(formUsername && formEmail){
								$('#submit').attr('disabled',false);
							}
						} 
					});
				}
			});

			$('#email').blur(function(){
				$('#submit').attr('disabled','disabled');
				$('#error_email').html('<label">Checking...</label>');
				var email = $('#email').val(); 	
				// var ab = $('#tgl_lahir').val();		
				$.ajax({
					url: "{{ url('/sales/register/cek-email') }}",   
					method:"POST", 
					data:{email:email}, 
					dataType:"text", 
					success:function(result) {    
						if (result == 'false') {
							$('#error_email').html('<label class="text-danger">Email telah terdaftar</label>');
							$('#email').addClass('has-error');
							$('#submit').attr('disabled','disabled');
							formEmail = false;
						}else{
							$('#error_email').html('');
							$('#email').removeClass('has-error');
							formEmail = true;
						}

						if(formUsername && formEmail){
							$('#submit').attr('disabled',false);
						}
					} 
				});
			});

			
		});

		@if (Session::has('add'))  
		setTimeout(function() {
			pnotify('Sukses', 'Sales berhasil didaftarkan','success');
		}, 2000);
		@endif
		@if (Session::has('error'))  
		setTimeout(function() {
			pnotify('Sukses', 'Sales gagal didaftarkan','error');
		}, 2000);
		@endif

		function pnotify(title, text, type) {
			new PNotify({
				title: title,
				text: text,
				type: type,
				styling: 'bootstrap3'
			});
		}
	</script>
</body>
