<html>
  <head>

		<title>逢甲選課系統-登入</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
		<!--jQuery~-->
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
		
		<!--~jQuery-->

		<!--bootstrap~-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
		<!--~bootstrap-->

		<!--fontawesome-->
		<script src="https://kit.fontawesome.com/d53abecaf1.js">
		</script>
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all" rel="stylesheet">
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all" rel="stylesheet">
		<link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
		<!--fontawesome-->
	
		<link href="/dbmid/main.css" rel="stylesheet" type="text/css" />
		<script src="/dbmid/main.js">
		</script>
	
		<link href="main.css" rel="stylesheet" type="text/css" />
		<script src="main.js">
		</script>

		

  </head>
  <body class="bg-primary">
		<?php
			include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/preloader/index.php';
		?>

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">

				<button class="navbar-toggler hidden">
		      <span class="navbar-toggler-icon"></span>
		    </button>

				<a class="navbar-brand py-0" href="#">
					<img src="/dbmid/asset/fculogo.svg" class="img-fluid navbar-logo py-1">
				</a>
				
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
				
		    <div class="collapse navbar-collapse" id="navbarToggler">
		      <ul class="navbar-nav me-auto mb-0 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link postloader" aria-current="page" href="/">首頁</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link postloader active" href="/dbmid/login">登入</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/register">註冊</a>
		        </li>
						<li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/course">選課</a>
		        </li>
		      </ul>

		    </div>
		  </div>
		</nav>
		
	  <div class="container">
	
	
	    <div class="row d-flex align-items-center onePageHeight">

				<div class="col-md col-xl"></div>
				
	      <div class="d-none d-md-block col-md-5 col-lg-4 ">
	        <img src="/dbmid/asset/fculogo.png" class="img-fluid" >      
	      </div>
	      <div class="col-12 col-md-6 col-lg-5 font-black onePageHeightAndCenterVertically antiFlow">

					<div class="d-flex justify-content-center w-100">
						<img src="/asset/fculogo.png" class="img-fluid d-block d-md-none col-7 col-sm-6 mb-2">
					</div>
					
					<div class="bg-white rounded-30 p-3 bingShadow">

						<h1 class="p-3 mb-2">登入</h1>
		        <form action="/missionAll" method="post" class="m-0">
		          <div class="form-group mb-1">              
		            <input type="text" class="form-control border-top-0 border-right-0 border-left-0 font-white bg-grey" placeholder="學號">              
		          </div>
		          <div class="form-group mb-5">              
		            <input type="password" class="form-control border-top-0 border-right-0 border-left-0 font-white bg-grey" placeholder="密碼">
		          </div>

							<div class="d-flex justify-content-between mb-2">
								<a class="m-0" href="/register">註冊帳號</a>
								<a class="m-0" href="/forgotPassword">忘記密碼</a>
							</div>

		
		          <div class="d-grid gap-2">
								<button class="btn btn-primary rounded-30 py-2" type="submit">確認</button>
							</div>
		
		          
		        </form>   
							
					</div>
	
	        
	      </div>

				<div class="col-md col-xl"></div>
	
	    </div>
	
	
	  </div>
	
	
	

		
    
    <script src="/dbmid/preLoaderClose.js" ></script>
		<!--bootstrap~-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>