<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	{{ Html::favicon(url('/') . '/ICON.png' ) }}
	<title>{{ config('app.name') }}</title>

	<title>WorkNetwork-EMI</title>

	<link rel="stylesheet" href="assets2/css/bootstrap.css">
	<link rel="stylesheet" href="assets2/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="assets2/css/neon.css">

	<script src="assets2/js/jquery-1.11.3.min.js"></script>

	<!--[if lt IE 9]><script src="assets2/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body>

<div class="wrap">

	<!-- Logo and Navigation -->
<div class="site-header-container container">

	<div class="row">

		<div class="col s12 m8  offset-m2">

			<header class="site-header">

				<section class="site-logo">

					<a href="index.html">
						<img src="assets2/images/logo@2x.png" width="120" />
					</a>

				</section>

				<nav class="site-nav">

					<ul class="main-menu hidden-xs" id="main-menu">
						<li class="active">
							<a href="login/">
								<span>Ingreso</span>
							</a>
						</li>
						{{--  <li>
							<a href="#">
								<span>Buscar Trabajo</span>
							</a>

							<ul>
								<li>
									<a href="#">
										<span>About Us</span>
									</a>
								</li>
								<li class="active">
									<a href="#">
										<span>Active Menu Item</span>
									</a>
								</li>
								<li>
									<a href="#">
										<span>Gallery</span>
									</a>

									<ul>
										<li>
											<a href="#">
												<span>Sub 1</span>
											</a>
										</li>
										<li>
											<a href="#">
												<span>Sub 2</span>
											</a>

											<ul>
												<li>
													<a href="contact.html">
														<span>Sub of sub 1</span>
													</a>
												</li>
												<li>
													<a href="#">
														<span>Sub of sub 2</span>
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="#">
												<span>Sub 3</span>
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="blog-post.html">
										<span>Blog Post</span>
									</a>
								</li>
								<li>
									<a href="portfolio-single.html">
										<span>Portfolio Item</span>
									</a>
								</li>
							</ul>
						</li>  --}}
						<li>
							<a href="#">
								<span>Buscar Personal</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span>Publicar empleo</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span>Contactos</span>
							</a>
						</li>
						<li class="search">
							<a href="#">
								<i class="entypo-search"></i>
							</a>

							<form method="get" class="search-form" action="" enctype="application/x-www-form-urlencoded">
								<input type="text" class="form-control" name="q" placeholder="Buscar..." />
							</form>
						</li>
					</ul>


					<div class="visible-xs">

						<a href="#" class="menu-trigger">
							<i class="entypo-menu"></i>
						</a>

					</div>
				</nav>
                <section class="site-logo">

                    <a href="index.html">
                        <img src="assets2/images/logo@2x.png" width="120" />
                    </a>

                </section>
				
			</header>
			
		</div>
		
	</div>
	
</div>	

<!-- Main Slider -->
<section class="slider-container" style="background-image: url(assets2/images/slide-img-1-bg.png);">

<div class="container">

    @yield('content')

    
<!-- Footer Widgets -->
<section class="footer-widgets">

<div class="container">
    
    <div class="row">
        
        <div class="col-sm-6">
            
            <a href="#">
                <img src="assets2/images/logo@2x.png" width="100" />
            </a>
            
            <p>
                Vivamus imperdiet felis consectetur onec eget orci adipiscing nunc. <br />
                Pellentesque fermentum, ante ac interdum ullamcorper.
            </p>
            
        </div>
        
        <div class="col-sm-3">
            
            <h5>DIRECCION</h5>
            
            <p>
                LA PAZ <br />
                EMI Irpavi <br />
			</p>    
			<p>
                EMI Central<br />
                Av. Arce No. 12642 <br />
			</p>
			<p>
                SANTA CRUZ<br />
                Tercer Anillo Radial 13 <br />
			</p>
			<p>
                COCHABAMBA<br />
				Av. 23 de Marzo, Zona Muyurina <br />
				Av. Lanza entre Oruro y La Paz
			</p>
            
        </div>
        
        <div class="col-sm-3">
            
            <h5>Contactos</h5>
            
            <p>
				Telf: 2775536 - 2799505<br />
				Fax: 2773774 <br />
                
			</p>
			<p>
				Telf. 2432266 - 2431641 - 2435285<br />
                lapaz@adm.emi.edu.bo
			</p>
			<p>
				Telf: 3527431 - 3579545 <br />
                Fax: 3579545<br />
				santacruz@adm.emi.edu.bo
			</p>
			<p>
				Telf: 4531133 - 4530361 <br />
				Fax: 4530361<br />
				Telf: 4521844<br />
				cochabamba@adm.emi.edu.bo
			</p>
		
        </div>
        
    </div>
    
</div>

</section>

<!-- Site Footer -->
<footer class="site-footer">

	<div class="container">
	
		<div class="row">
			
			<div class="col-sm-6">
				Copyright &copy; Neon - All Rights Reserved. 
			</div>
			
			<div class="col-sm-6">
				
				<ul class="social-networks text-right">
					<li>
						<a href="#">
							<i class="entypo-instagram"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="entypo-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="entypo-facebook"></i>
						</a>
					</li>
				</ul>
				
			</div>
			
		</div>
		
	</div>
	
</footer>	
</div>


	<!-- Bottom scripts (common) -->
	<script src="assets2/js/gsap/TweenMax.min.js"></script>
	<script src="assets2/js/bootstrap.js"></script>
	<script src="assets2/js/joinable.js"></script>
	<script src="assets2/js/resizeable.js"></script>
	<script src="assets2/js/neon-slider.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets2/js/neon-custom.js"></script>

</body>
</html>