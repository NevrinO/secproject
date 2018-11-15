<?php include 'login/login.html';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TITLE for an unnamed site</title> <!-- Change this before deployment -->


</head>

<body>

    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
		<?php include 'sidebar.html';?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
			<a href="#menu-toggle" id="menu-toggle"><i class="fa fa-reorder fa-2x" aria-hidden="true"></i></a><br>
            <div class="container-fluid">
                <?php 
					if(isset($_SESSION['query-data'])){
						echo '
						<div class="card text-center">
							<div class="card-block">
								<h3 class="card-title">'.$_SESSION['query-data']['name'].'</h3>
								<h6>'.$_SESSION['query-data']['type'].'</h6>
								<p class="card-text">'.$_SESSION['query-data']['street'].' '.$_SESSION['query-data']['city'].' '.$_SESSION['query-data']['state'].' '.$_SESSION['query-data']['zip'].'</p>
								<p class="card-text">'.$_SESSION['query-data']['description'].'</p>
								<h5 class="card-text">$'.$_SESSION['query-data']['price'].'</h5>';
								if(isset($_SESSION['query-images'])){
									echo '
									<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner" role="listbox" style="background-color:gray;">';
											$first = true;
											foreach( $_SESSION['query-images'] as $row){
												echo'
													<div class="carousel-item '; if($first){$first = false; echo'active';}echo'">
														<img class="d-block img-fluid mx-auto" src="/upload_image/upload/'.$row['listing_id'].'/'.$row['img_name'].'">
													</div>
												';
											}
									echo '
										</div>
										<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>
									</div>';
								}
							echo '</div>
						</div>
						';
					}
					else{
						print_r($_SESSION['query-data']);
						echo 'Error no listing selected';
					}
				?>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
		
    });
	if($(window).width() < 640){
		$("#wrapper").toggleClass("toggled");
	};
    </script>

</body>

</html>
