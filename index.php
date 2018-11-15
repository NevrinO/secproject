<?php include 'login/login.html';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Index for an unnamed site</title>

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
                <h1>Site Name Here</h1>
				<form action="search_controller.php" method="get">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" name='name'><span><button type="submit" class="btn btn-primary"><i class="fa fa-search fa-2x"></i></button></span>
						</div>
					</div>
					
				</form><br>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a porttitor magna, et sollicitudin ex. Sed blandit vestibulum mi, sed fringilla turpis tempus eu. Fusce tristique vel risus at vulputate. Sed efficitur neque non maximus hendrerit. Nullam lobortis volutpat vehicula. Aliquam erat volutpat. </p>
                <p>Nunc vitae nulla sem. Phasellus volutpat orci malesuada, maximus diam sit amet, pharetra massa. Aenean augue nunc, tempus sed suscipit et, congue et mi. Quisque viverra nunc sem, vel dictum ante lacinia ut. In sed varius metus. Cras elementum, leo ac tincidunt venenatis, odio velit eleifend tellus, a gravida purus nisl quis nulla. Etiam consectetur rutrum erat. Maecenas rutrum mi vitae mi congue facilisis. Sed sed dapibus dolor. Nullam condimentum, nunc sed lacinia elementum, massa nulla sagittis nisl, non placerat erat lorem ut justo. Aenean ullamcorper eleifend neque quis commodo. Vestibulum ac tempus nisl. Maecenas fermentum cursus massa vitae aliquam. </p>
                <br>
				<?php 

					require 'db.php';
					$db = new db();

					$result = $db->query("select * from accounts");
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo "User Name: " . $row["user"]. "<br>";
						}
					} else {
						echo "No Users In Database";
					}
				?>
				<br><br><br><br><br>
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
