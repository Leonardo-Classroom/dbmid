<html>
  <head>

		<title>逢甲選課系統</title>

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
	
		<link href="/main.css" rel="stylesheet" type="text/css" />
		<script src="/main.js">
		</script>
	
		<link href="main.css" rel="stylesheet" type="text/css" />
		<script src="main.js">
		</script>

		<link rel="stylesheet/scss" type="text/css" href="/bubble.scss" />
		<link href="/bubble.css" rel="stylesheet" type="text/css" />
		<script src="/course.js"></script>

		

  </head>
  <body class="">
    <?php
			include $_SERVER['DOCUMENT_ROOT'].'/model/preloader/index.php';
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">

				<button class="navbar-toggler hidden">
		      <span class="navbar-toggler-icon"></span>
		    </button>

				<a class="navbar-brand py-0" href="#">
					<img src="/asset/fculogo.svg" class="img-fluid navbar-logo py-1">

					<?php
						// include $_SERVER['DOCUMENT_ROOT'].'/model/fculogo/index.php';
					?>
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
		          <a class="nav-link postloader" href="/login">登入</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link postloader" href="/register">註冊</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link postloader active" href="/course">選課</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link postloader" href="/mycourse">我的課表</a>
		        </li>
		      </ul>

		    </div>
		  </div>
		</nav>

		<div class="bg-primary py-3 py-md-4 py-md-5 mb-3">
			<div class="container">
				<div class="d-flex justify-content-center w-100  ">
					<div class="col-12 col-md-10 col-lg-8 bingShadow bg-white rounded-30 px-3" for="searchBox">
						<div class="col">
							<div class="row">
								<img src="/asset/search.svg" class="img-fluid col-auto">
								<div class="col px-0">
									<input type="text" class="col-12 h-100 border-0 py-3" id="searchBox">
								</div>
								<div class="col-auto pe-0 ">
									<select class="col-auto form-control border-0 py-3 px-2">
										<option>星期</option>
										<option>Mon</option>
										<option>Tue</option>
										<option>Wed</option>
										<option>Thu</option>
										<option>Fri</option>
									</select>
								</div>
								<div class="col-auto px-0 rounded-30">
									<select class="col-auto form-control border-0 py-3 rounded-30 px-2">
										<option>節</option>
										<option>1th</option>
										<option>2th</option>
										<option>3th</option>
										<option>4th</option>
										<option>5th</option>
										<option>6th</option>
										<option>7th</option>
										<option>8th</option>
										<option>9th</option>
										<option>10th</option>
										<option>11th</option>
										<option>12th</option>
										<option>13th</option>
										
									</select>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
		
			</div>
			
		</div>
		
		<div class="container">

<!-- 			<div class="v-slider">
        <div class="hold promote-layer"></div>
      </div> -->



			<div class="col px-1">
				<div class="row">
					

					<?php
						for($i=0;$i<5;$i++){
							include $_SERVER['DOCUMENT_ROOT'].'/model/card/index.php';
							include $_SERVER['DOCUMENT_ROOT'].'/model/card/cardtest.php';
						}
						
					?>

				</div>
			</div>



<!-- 			timetable -->
			<div>
				<div class="bubble"></div>
			</div>
			
			<div class="chat_container container ">
				
			  <div class="chat col-12 pe-2">
					<div class="chatIn col-12 p-0">

							<?php
								include $_SERVER['DOCUMENT_ROOT'].'/model/timetable/index.php';
							?>

						
					</div>	
					
					
			    
			  </div>
			</div>

			<div class="timetableMask"></div>
			
			
		</div>
		
		
		
		<script src="/preLoaderClose.js" ></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>