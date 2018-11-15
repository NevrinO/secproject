<?php include 'login/login.html';?>
<?php if(!isset($_SESSION['user'])){
	header('Location: index.php');
	die();
	}?>
<!DOCTYPE html>	
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add A Listing</title>


</head>

<body>

    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <?php include 'sidebar.html';?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
			<a href="#menu-toggle" id="menu-toggle"><i class="fa fa-reorder fa-2x" aria-hidden="true"></i></span></a><br>
            <div class="container-fluid">
                <h1>Add A Listing</h1>
				<div>
					<form action="listing_control.php" method="post">
						<div class="form-group">
							<input type="hidden" name="op" value="new_listing">
							<label for="name">Name of venue/artist: </label>
							<input type="text" class="form-control" name="name" placeholder="Enter Name" required>
						</div>
						<div class="form-group">
							<label for="name">type/genre of venue/artist: </label>
							<div class="input-group">
								<select class="form-control" name="type" size="1" required>
								<option value="">Type...</option>
								<option value="venue">Venue</option>
								<option value="artist">Artist</option>
								</select>
								<!--<select class="form-control" name="prime" size="1" required></select>
								<select class="form-control" name="secondary" size="1" required></select>-->
							</div>
						</div>
						<div class="form-group">
							<label for="name">Street Address: </label>
							<input type="text" class="form-control" name="street" placeholder="street address">
						</div>
						<div class="form-group">
							<label for="city">City: </label>
							<input type="text" class="form-control" name="city" placeholder="Enter City/Town" required>
						</div>
						<div class="form-group">
							<label for="state">State: </label>
							<select class="form-control" name="state" size="1" required>
								<option selected value="">State...</option>
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
						</div>
						<div class="form-group">
							<label for="name">Zip code: </label>
							<input type="text" class="form-control" name="zip" placeholder="Enter 5 or 9 digits" maxlength="10" required>
						</div>
						<div class="form-group">
							<label for="name">Price: </label>
							<input type="text" class="form-control" name="price" placeholder="price per event">
						</div>
						<div class="form-group">
							<label for="name">Description: </label>
							<textarea type="textarea" class="form-control" name="description" placeholder="Describe venue/artist" rows="7" cols="40"></textarea>
						</div>
						<div class="form-group">
							<div class="input-group">
								<button type="submit" class="btn btn-primary"><strong> Add Listing </strong> <i class="fa fa-pencil-square fa-lg"></i></button>
							</div>
						</div>
						<small class="form-text text-muted">TEMP placeholder</small>
					</form>
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
	if($(window).width() < 640){
		$("#wrapper").toggleClass("toggled");
	};
    </script>

</body>

</html>
