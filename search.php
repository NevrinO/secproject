<?php include 'login/login.html';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TITLE for an unnamed site</title> <!-- Change this before deployment -->

    <script>
		function load_listing(list_id){
			post("listing_control.php",{id:list_id, op:"view_listing"});
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
                <h1>Search</h1>
				<form action="search_controller.php" method="get">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Name of Venue/Artist/City" name='name'><span><button type="submit" class="btn btn-primary"><i class="fa fa-search fa-2x"></i></button></span>
						</div>	
						<small id="searchHelp" class="form-text text-muted">TEMP placeholder</small>
					</div>
					<div class="form-check form-check-inline">
						<label for="state" class="form-check-label">State: </label>
						<select class="form-control" name="state" size="1" >
							<option selected value="">Any</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>					
						<label class="form-check-label">
							<input type="checkbox" name="venue" class="form-check-input" value="venue"  style="width:16px; height:16px;" checked>
							Venues
						</label>
						<label class="form-check-label" style="justify-content: center;">
							<input type="checkbox" name="artist" class="form-check-input" style="width:16px; height:16px;" value="artist" checked>
							Artists
						</label>
					</div>
				</form><br>
				<?php
					if(isset($_SESSION['search-data'])){
						$counter = 0;
						if(count($_SESSION['search-data']) == 0){
							echo '<h3>No Results Found</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
						}else{
							foreach( $_SESSION['search-data'] as $row){
								if($counter == 0)
									echo '<div class="card-deck">';
								echo'
									<div class="col-sm-4">
										<div class="card">
											<div class="card-block">
												<img class="card-img-top" src="'.(isset($row['thumbnail-data'])?'/upload_image/upload/'.$row['listing_id'].'/'.$row['thumbnail-data']['img_name']:"img/no-thumbnail.jpg").'" style="width:100%; height:250px;" alt="Card image cap">
												<a href="#" onClick="load_listing('.$row['listing_id'].')" style="color:black">
												<h3 class="card-title">'.$row['name'].'</h3>
												<h6 class="text-capitalize">'.$row['type'].'</h6>
												<p class="card-text">'.$row['street'].' '.$row['city'].' '.$row['state'].' '.$row['zip'].'</p>
												</a>
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
						}
					}
					else{
						echo '<script>window.location.href = "/search_controller.php?name=";</script>';
						die();
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
