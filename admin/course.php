<?php
    include $_SERVER['DOCUMENT_ROOT'].'/dbmid/model/chklogin/index.php';
    if($admin_id==0){
        header("Location: /dbmid/login");
        exit();
    }
    $admin_account=$account;
?>



<?php
    
    $dateDict["一"]=0;
    $dateDict["二"]=1;
    $dateDict["三"]=2;
    $dateDict["四"]=3;
    $dateDict["五"]=4;

    $student_id=$_GET["student_id"];

	// Database connection details
	$host = "localhost";
	$username = "hj";
	$password = "test1234";
	$dbname = "dbmid";

	// Connect to database
	$conn = mysqli_connect($host, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	
	// Build SQL query based on filters
	$sql = "
        SELECT ss.`section_student_id`,ss.`is_withdrawable`,ss.`is_valid`,`section`.* ,`course`.* 
        FROM `section_student` AS ss 
        LEFT JOIN `section` ON ss.`section_id`=`section`.`section_id` 
        LEFT JOIN `course` ON `section`.`course_id`=`course`.`course_id`
        WHERE ss.`is_valid`=1 AND ss.`student_id` = ".$student_id.";        
	";

	// Execute query and get results
	$result = mysqli_query($conn, $sql);



    $section_student_id=[];
    $section_id=[];
    $is_withdrawable=[];
    $is_valid=[];

    $class_id=[];
    $course_id=[];
    $quota=[];
    $quota_max=[];
    $year=[];
    $semester=[];
    $note =[];

    $course_name=[];
    $credit=[];
    $isRequired=[];

	while($row = mysqli_fetch_array($result)){

        array_push($section_student_id, $row['section_student_id']);
        array_push($section_id, $row['section_id']);
        array_push($is_withdrawable, $row['is_withdrawable']);
        array_push($is_valid, $row['is_valid']);

        array_push($class_id, $row['class_id']);
        array_push($course_id, $row['course_id']);
        array_push($quota, $row['quota']);
        array_push($quota_max, $row['quota_max']);
        array_push($year, $row['year']);
        array_push($semester, $row['semester']);
        array_push($note, $row['note']);

        array_push($course_name, $row['course_name']);
        array_push($credit, $row['credit']);
        array_push($isRequired, $row['isRequired']);
        		        
		
	}
    // for($i=0;$i<count($section_student_id);$i++){
    //     echo $section_student_id[$i].",";
    //     echo $section_id[$i].",";
    //     echo $is_withdrawable[$i].",";
    //     echo $is_valid[$i].",";
    //     echo "<br><br>";
    // }

    // echo "------<br>";

	

    for($i=0;$i<13;$i++){
        for($j=0;$j<5;$j++){
            $table[$i][$j]["section_student_id"]=0;
            $table[$i][$j]["section_id"]=0;
            $table[$i][$j]["is_withdrawable"]=0;
            $table[$i][$j]["is_valid"]=0;

            $table[$i][$j]["class_id"]=0;
            $table[$i][$j]["course_id"]=0;
            $table[$i][$j]["quota"]=0;
            $table[$i][$j]["quota_max"]=0;
            $table[$i][$j]["year"]=0;
            $table[$i][$j]["semester"]=0;
            $table[$i][$j]["note"]=0;

            $table[$i][$j]["course_name"]=0;
            $table[$i][$j]["credit"]=0;
            $table[$i][$j]["isRequired"]=0;

            $table[$i][$j]["section_detail_id"]=0;
            $table[$i][$j]["section_id"]=0;
            $table[$i][$j]["teacher_id"]=0;
            $table[$i][$j]["week"]=0;
            $table[$i][$j]["time_start"]=0;
            $table[$i][$j]["time_end"]=0;
            $table[$i][$j]["location"]=0;
        }
    }

    // for($i=0;$i<13;$i++){
    //     for($j=0;$j<5;$j++){            
    //         echo $table[$i][$j]["section_student_id"]." ";
    //     }
    //     echo "<br>";
    // }

    for($i=0;$i<count($section_student_id);$i++){
        // echo $section_student_id[$i].",";
        // echo $section_id[$i].",";
        // echo $is_withdrawable[$i].",";
        // echo $is_valid[$i].",";
        // echo "<br><br>";

        // echo $class_id[$i].",";
        // echo $course_id[$i].",";
        // echo $quota[$i].",";
        // echo $quota_max[$i].",";
        // echo $year[$i].",";
        // echo $semester[$i].",";
        // echo $note[$i].",";
        // echo "<br><br>";

        // echo $course_name[$i].",";
        // echo $credit[$i].",";
        // echo $isRequired[$i].",";
        // echo "<br><br>";
        
        // echo "<br>---------------------------------------<br>";

        $sql = "
            SELECT * 
            FROM `section_detail` 
            WHERE `section_id` = ".$section_id[$i].";
        ";

        // Execute query and get results
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){

            $tmp_section_detail_id=$row['section_detail_id'];
            $tmp_section_id=$row['section_id'];
            $tmp_teacher_id=$row['teacher_id'];
            $tmp_week=$row['week'];
            $tmp_time_start=$row['time_start'];
            $tmp_time_end=$row['time_end'];
            $tmp_location=$row['location'];


// echo $tmp_section_detail_id.",";
// echo $tmp_section_id.",";
// echo $tmp_teacher_id.",";
// echo $tmp_week.",";
// echo $tmp_time_start.",";
// echo $tmp_time_end.",";
// echo $tmp_location.",";
// echo "<br>";


            for($j=$tmp_time_start-1;$j<$tmp_time_end;$j++){
                
                $table[$j][$dateDict[$tmp_week]]["section_student_id"]=$section_student_id[$i];
                $table[$j][$dateDict[$tmp_week]]["section_id"]=$section_id[$i];
                $table[$j][$dateDict[$tmp_week]]["is_withdrawable"]=$is_withdrawable[$i];
                $table[$j][$dateDict[$tmp_week]]["is_valid"]=$is_valid[$i];

                $table[$j][$dateDict[$tmp_week]]["class_id"]=$class_id[$i];
                $table[$j][$dateDict[$tmp_week]]["course_id"]=$course_id[$i];
                $table[$j][$dateDict[$tmp_week]]["quota"]=$quota[$i];
                $table[$j][$dateDict[$tmp_week]]["quota_max"]=$quota_max[$i];
                $table[$j][$dateDict[$tmp_week]]["year"]=$year[$i];
                $table[$j][$dateDict[$tmp_week]]["semester"]=$semester[$i];
                $table[$j][$dateDict[$tmp_week]]["note"]=$note[$i];

                $table[$j][$dateDict[$tmp_week]]["course_name"]=$course_name[$i];
                $table[$j][$dateDict[$tmp_week]]["credit"]=$credit[$i];
                $table[$j][$dateDict[$tmp_week]]["isRequired"]=$isRequired[$i];                

                $table[$j][$dateDict[$tmp_week]]["section_detail_id"]=$tmp_section_detail_id;
                $table[$j][$dateDict[$tmp_week]]["section_id"]=$tmp_section_id;
                $table[$j][$dateDict[$tmp_week]]["teacher_id"]=$tmp_teacher_id;
                $table[$j][$dateDict[$tmp_week]]["week"]=$tmp_week;
                $table[$j][$dateDict[$tmp_week]]["time_start"]=$tmp_time_start;
                $table[$j][$dateDict[$tmp_week]]["time_end"]=$tmp_time_end;
                $table[$j][$dateDict[$tmp_week]]["location"]=$tmp_location;
            }   
            
        }

    }

?>



<html>
  <head>

		<title>逢甲選課系統- 我的課表</title>

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

		<link rel="stylesheet/scss" type="text/css" href="/bubble.scss" />
		<link href="/dbmid/bubble.css" rel="stylesheet" type="text/css" />
		<script src="/dbmid/course.js"></script>

		

  </head>
  <body class="">
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
                    <a class="nav-link postloader active" aria-current="page" href="/dbmid/admin">檢索</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/course">選課</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link postloader" href="/dbmid/mycourse">我的課表</a>
		        </li>
		      </ul>
			  <ul class="d-flex justify-content-end m-0">
			  	<li class="nav-item d-flex align-items-center">
				  <p class="m-0 font-white pe-3"><?php echo "admin_".$admin_id." ".$admin_account;?></p>
		        </li>
				<li class="nav-item">
					<form class="d-flex m-0" action="/dbmid/login/logout.php">			
						<button class="btn btn-outline-danger" type="submit">logout</button>
					</form>
		        </li>
			  
			  </ul>
		    </div>

			

		  </div>
		</nav>

		
		<div class="container py-2">



            <link href="/dbmid/table.css" rel="stylesheet" type="text/css" />
            <link href="/dbmid/mycourse/main.css" rel="stylesheet" type="text/css" />
            <div class="col-12 px-1" id="printArea">
            
            	<div class="col px-2">



                    <p class="m-0">當前學分：16/30</p>
                    
            		<div class="row bg-light-grey font-white roundRT roundLT">
            			
            			<div class="col-auto px-1 centerVertically bi-table border left-title px-0 roundLT">
            				<a class="font-white" target="_blank" href="https://newleonardoclassroom.leonardoholmes.repl.co/en-us/about-me/"><i class="fas fa-user" aria-hidden="true"></i></a>
            			</div>
            
            			<div class="col border centerVertically px-1">
            				Mon
            			</div>
            
            			<div class="col border centerVertically px-1">
            				Tue
            			</div>
            
            			<div class="col border centerVertically px-1">
            				Wed
            			</div>
            
            			<div class="col border centerVertically px-1">
            				Thr
            			</div>
            
            			<div class="col border centerVertically px-1 roundRT">
            				Fri
            			</div>
            
            		</div>

                    <?php
                        for($i=0;$i<13;$i++){
                    ?>

                    
            
                            <div class="row">
                    
                                <div 
                                    <?php
                                        if($i==12){
                                            echo 'class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0 roundLB"';
                                        }else{
                                            echo 'class="col-auto centerVertically px-1 bg-light-grey font-white border left-title px-0"';
                                        }
                                    ?>
                                >
                                    <?php
                                        echo $i+1;
                                    ?>
                                </div>

                                <?php
                                    for($j=0;$j<5;$j++){
                                ?>


                                        <div 
                                            <?php
                                                if($table[$i][$j]["section_id"]!=0){
                                                    if($table[$i][$j]["isRequired"]==1){
                                                        echo "class='col border f-height centerVertically px-1 bi-table'";
                                                    }else{
                                                        echo "class='col border f-height centerVertically px-1 xuan-table'";
                                                    }
                                                }else if($i==12&&$j==4){
                                                    echo "class='col border f-height centerVertically px-1 roundRB'";
                                                }else{
                                                    echo "class='col border f-height centerVertically px-1'";
                                                }
                                                
                                            ?>
                                        >
                                            <p class="m-0 p-0 form-ellipsis ">
                                                <?php
                                                    if($table[$i][$j]["section_id"]!=0){
                                                        echo $table[$i][$j]["course_name"];
                                                    }
                                                ?>
                                            </p>
                                        </div>

                                <?php
                                    }
                                ?>
                    
                                
                    
                            </div>
                        
                    <?php
                        }
                    ?>
            		
            		

            
            	</div>          
            	
            
            </div>        
            
            
            			
			
		</div>
		





        <!-- Modal -->
        <div class="modal fade px-0" 
			<?php 
				echo "id='"."exampleModal"."'";
			?> 
		tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content rounded-30">
              <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
        				
                <div class="row pt-0 pb-0 px-2 mb-3 pt-1">
        					<div class="col-auto text-right px-0 m-0">           
        						<div class="h-100 d-flex align-items-end flex-column">
        							<h5 class="bi px-3 py-1 m-0">必修</h5>
        						</div>
        					</div>
        					
        					<div class="col text-left pe-0 ps-1 m-0  d-flex align-items-center">
        						<h5 class="fw-bold ellipsis-1 m-0 ps-2">
        							<span >程式設計III程式設計III程式設計III</span>
        						</h5>
        					</div>			
        				</div>
        
        				
        				
        				<div class="pt-0 pb-0 px-2 mb-2 pt-1">
        		
        					       
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">代碼</h5>							
        							<h5 class="m-0 w-50">1211</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">授課教師</h5>							
        							<h5 class="m-0 w-50">何霆鋒</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">學分</h5>							
        							<h5 class="m-0 w-50">2</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">實收名額</h5>							
        							<h5 class="m-0 w-50">60</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">開放名額</h5>							
        							<h5 class="m-0 w-50">70</h5>
        						</div>
        
        
        						<div class="col h-100 d-flex justify-content-between pb-2">
        							<h5 class="fw-bold m-0 w-50">上課時間</h5>
        							<h5 class="m-0 w-50">周四 3~4節</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">上課地點</h5>
        							<h5 class="m-0 w-50">科航204</h5>
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between pb-2">
        							<h5 class="fw-bold m-0 w-50">上課時間</h5>
        							<h5 class="m-0 w-50">周五 1~4節</h5>	
        						</div>
        
        						<div class="col h-100 d-flex justify-content-between border-bottom pb-2 mb-2">
        							<h5 class="fw-bold m-0 w-50">上課地點</h5>
        							<h5 class="m-0 w-50">資電234</h5>
        						</div>
        
        						<div class="col h-100">
        							<h5 class="fw-bold m-0 pb-1">備註</h5>
        							<h5 class="m-0 w-100">2023/02/13~2023/04/13[第01~09周上課]</h5>
        						</div>

                                <div class="col w-100 d-flex justify-content-center pt-3">
        							<button class="btn btn-primary rounded-30 py-2 px-3" type="submit">退選</button>
        						</div>
        					
        				</div>
        				
              </div>
              
            </div>
          </div>
        </div>
        






      
		
		<script src="/dbmid/preLoaderClose.js" ></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
		<!--~bootstrap-->
		
  </body>
</html>


<?php
    mysqli_close($conn);
?>