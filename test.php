<?php include 'login/login.html';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Test</title> <!-- Change this before deployment -->

    

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
                <h1>Test Page</h1>
                <p>Testing cards with this</p>
                <div class="row">
				  <div class="col-sm-3">
					<div class="card">
					  <div class="card-block">
						<h3 class="card-title">Special title treatment</h3>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					</div>
				  </div>
				  <div class="col-sm-3">
					<div class="card">
					  <div class="card-block">
						<h3 class="card-title">Special title treatment</h3>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					</div>
				  </div>
				  <div class="col-sm-3">
					<div class="card">
					  <div class="card-block">
						<h3 class="card-title">Special title treatment</h3>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					</div>
				  </div>
				  <div class="col-sm-3">
					<div class="card">
					  <div class="card-block">
						<h3 class="card-title">Special title treatment</h3>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					</div>
				  </div>
				</div>                
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
    </script>

</body>

</html>
