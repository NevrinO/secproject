<?php include 'login/login.html';?>
<?php if(!isset($_SESSION['user'])){
	header('Location: index.php');
	die();
	}else{
		$_SESSION['listing_id'] = null;
		if($_SESSION['admin'] === 1){
			header('Location: administration.php');
			die();
		}
		
	}?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="This is the account page">
    <meta name="author" content="Group 2">

    <title>Account Page</title>


	<script language="javascript" type="text/javascript">
		function btnadd_onclick() 
		{
			window.location.href = "add_listing.php";
		}
		function btndelete_onclick(list_id)
		{
			if(confirm("Do you wish to delete this listing?")){
				post("listing_control.php",{id:list_id, op:"delete_listing", returnpage:"account.php"});
			}
		}
		function btnview_onclick(list_id)
		{
			post("listing_control.php",{id:list_id, op:"view_listing"});
		}
		function btnupload_onclick(list_id)
		{
			post("listing_control.php",{listing_id:list_id, op:"upload_image"});
		}
		function btnedit_onclick(list_id)
		{
			post("listing_control.php",{id:list_id, op:"get_listing"});
		}
		function post(path, params, method) {
			method = method || "post"; // Set method to post by default if not specified.

			// The rest of this code assumes you are not using a library.
			// It can be made less wordy if you use one.
			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", path);

			for(var key in params) {
				if(params.hasOwnProperty(key)) {
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", key);
					hiddenField.setAttribute("value", params[key]);

					form.appendChild(hiddenField);
				}
			}

			document.body.appendChild(form);
			form.submit();
		}
	</script>
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
                <h1>Account page for <span class="text-capitalize"><?php echo $_SESSION['user']; ?></span></h1>
                <p>Ipsom melaria hippakampa narlock barn phemosis dedntire fedellium buger snatch</p>
				<input class="btn btn-primary" id="btnadd" type="button" value="Add Listing" 
					onclick="return btnadd_onclick()" />
				<br>
				<br>
				
				<?php if(isset($_SESSION['user'])){
					require 'db.php';
					$db = new db();
					$result = $db->query('select listing_id, name, type, street, city, state, zip from listings where user_name="'.$_SESSION['user'].'"');
					if ($result->num_rows > 0) {
						$counter = 0;
						while($row = $result->fetch_assoc()){
							//debug_to_console( $row );
							$result2 = $db->get_thumbnail($row['listing_id']);
							if($result2->num_rows > 0){
								$row['thumbnail-data'] = $result2->fetch_assoc();
								//debug_to_console( $row['thumbnail-data'] );
							}
							if($counter == 0)
								echo '<div class="card-deck">';
							echo'
								<div class="col-sm-4">
									<div class="card">
										<div class="card-block">
											<img class="card-img-top" src="'.(isset($row['thumbnail-data'])?'/upload_image/upload/'.$row['listing_id'].'/'.$row['thumbnail-data']['img_name']:"img/no-thumbnail.jpg").'" style="width:100%; height:250px;" alt="Card image cap">
											<h3 class="card-title">'.$row['name'].'</h3>
											<h6 class="text-capitalize">'.$row['type'].'</h6>
											<p class="card-text">'.$row['street'].' '.$row['city'].' '.$row['state'].' '.$row['zip'].'</p>
											<div class="card-footer">
												<div class="btn-group btn-block">
													<a class="btn btn-danger" style="width:25%" onclick="return btndelete_onclick('.$row["listing_id"].')" aria-label="Delete" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													<a class="btn btn-info" style="width:25%" onclick="return btnview_onclick('.$row["listing_id"].')" aria-label="View" ><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
													<a class="btn btn-warning" style="width:25%" onclick="return btnupload_onclick('.$row["listing_id"].')" aria-label="Upload" ><i class="fa fa-upload" aria-hidden="true"></i></a>
													<a class="btn btn-success" style="width:25%" onclick="return btnedit_onclick('.$row["listing_id"].')" aria-label="Settings"><i class="fa fa-cog" aria-hidden="true"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>';
							if($counter == 2)
								echo '</div><br>';
							$counter++;
							//echo $counter;
							if($counter == 3)
								$counter = 0;
							//print_r($row);
						}
						echo "</div>";
					} else {
						echo "Please Create A Listing <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
					}
				}
				function debug_to_console( $data ) {
					$output = $data;
					if ( is_array( $output ) )
						$output = implode( ',', $output);

					echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
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