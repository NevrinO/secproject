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
                <h1>Template</h1>
                <p>Add webpage inside <code>page-content-wrapper</code></p>
                <p>Nunc vitae nulla sem. Phasellus volutpat orci malesuada, maximus diam sit amet, pharetra massa. Aenean augue nunc, tempus sed suscipit et, congue et mi. Quisque viverra nunc sem, vel dictum ante lacinia ut. In sed varius metus. Cras elementum, leo ac tincidunt venenatis, odio velit eleifend tellus, a gravida purus nisl quis nulla. Etiam consectetur rutrum erat. Maecenas rutrum mi vitae mi congue facilisis. Sed sed dapibus dolor. Nullam condimentum, nunc sed lacinia elementum, massa nulla sagittis nisl, non placerat erat lorem ut justo. Aenean ullamcorper eleifend neque quis commodo. Vestibulum ac tempus nisl. Maecenas fermentum cursus massa vitae aliquam. </p>
                
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
