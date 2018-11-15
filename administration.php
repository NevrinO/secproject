<?php include 'login/login.html';?>
<?php if(!isset($_SESSION['user'])){
	header('Location: index.php');
	die();
	}else{
		if($_SESSION['admin'] != 1){
			header('Location: login/logout.php');
			die();
		}
		
	}?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Page</title> <!-- Change this before deployment -->
	
    <link href="css/bootstrap-table.css" rel="stylesheet">
	
	

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
                <h1>Administration Page</h1>
                <p></p>
				<div class="card">
				  <div class="card-header card-info">
					Users/Listings/Ratings
				  </div>
				  <div class="card-block">
					<table id="table"></table>
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
	<script src="js/bootstrap-table.js"></script>
	
	<?php 

		require 'db.php';
		$db = new db();

		$data = [];
		$result = $db->query("select * from accounts");
		if ($result->num_rows > 0) {
			array_push($data,[]);
			$tmpCount = 0;
			while($row = $result->fetch_assoc()) {
				$data[$tmpCount]['user'] = $row['user'];
				$data[$tmpCount]['reset'] = $row['user'];
				$data[$tmpCount]['delete'] = $row['user'];
				//debug_to_console( $data[$tmpCount] );
				$result2 = $db->query('select * from listings where user_name="'.$row['user'].'"');
				$data[$tmpCount]['num_list'] = $result2->num_rows;
				//debug_to_console( $result2->num_rows );
				if ($result2->num_rows > 0) {
					$data[$tmpCount]['nested'] = [];
					$tmpCount2 = 0;
					while($row2 = $result2->fetch_assoc()) {
						$data[$tmpCount]['nested'][$tmpCount2]['name'] = $row2['name'];
						$data[$tmpCount]['nested'][$tmpCount2]['type'] = $row2['type'];
						$data[$tmpCount]['nested'][$tmpCount2]['street'] = $row2['street'];
						$data[$tmpCount]['nested'][$tmpCount2]['city'] = $row2['city'];
						$data[$tmpCount]['nested'][$tmpCount2]['state'] = $row2['state'];
						$data[$tmpCount]['nested'][$tmpCount2]['zip'] = $row2['zip'];
						$data[$tmpCount]['nested'][$tmpCount2]['delete'] = $row2['listing_id'];
						//debug_to_console( $data[$tmpCount]['nested'][$tmpCount2] );
						$tmpCount2 ++;
					}
				}
				$tmpCount ++;
			}
		} else {
			echo "DB empty";
		}
		
		function debug_to_console( $data ) {
			$output = $data;
			if ( is_array( $output ) )
				$output = implode( ',', $output);

			echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
		}
		
	?>

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
	<script>

		var data = <?php echo json_encode($data);?>;
	
		var $table = $('#table');
		$(function() {

		  $table.bootstrapTable({
			columns: [{
			  field: 'user',
			  title: 'User Name'
			}, {
			  field: 'num_list',
			  title: '# of Listings'
			}, {
			  field: 'reset',
			  title: 'Reset Password'
			}, {
			  field: 'delete',
			  title: 'Delete'
			}],
			data: data,
			detailView: true,
			onExpandRow: function(index, row, $detail) {
			  //console.log(row)
			  $detail.html('<table></table>').find('table').bootstrapTable({
				columns: [{
				  field: 'name',
				  title: 'Name'
				}, {
				  field: 'type',
				  title: 'Type'
				}, {
				  field: 'street',
				  title: 'Street'
				}, {
				  field: 'city',
				  title: 'City'
				}, {
				  field: 'state',
				  title: 'State'
				}, {
				  field: 'zip',
				  title: 'Zipcode'
				}, {
				  field: 'delete',
				  title: 'Delete'
				}],
				data: row.nested,
				// Simple contextual, assumes all entries have further nesting
				// Just shows example of how you might differentiate some rows, though also remember row class and similar possible flags
				detailView: row.nested[0]['other'] !== undefined,
				onExpandRow: function(indexb, rowb, $detailb) {
				  $detailb.html('<table></table>').find('table').bootstrapTable({
					columns: [{
					  field: 'user',
					  title: 'User Name'
					}, {
					  field: 'rating',
					  title: 'Rating'
					}, {
					  field: 'comment',
					  title: 'Comment'
					}, {
					  field: 'delete',
					  title: 'Delete'
					}],
					data: rowb.other
				  });
				}
			  });
				$('#table tr.detail-view > td table tr > td:nth-child(7)').each(function(){
					var temp = $(this).html();
					if (!$(temp).hasClass('btn-danger')){ 
						$(this).html('<a class="btn btn-danger" onclick="return btndelete_onclick(&quot;'+temp+'&quot;)" aria-label="Delete" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i></a>')
					}
				});
			}
		  });
		});

	</script>
	
	<script>
		$( document ).ready(function() {
			$('table tr > td:nth-child(4)').each(function(){
				var temp = $(this).html();
				$(this).html('<a class="btn btn-success" onclick="return btnreset_password_onclick(&quot;'+temp+'&quot;)" aria-label="Reset" >Reset Password <i class="fa fa-pencil" aria-hidden="true"></i></a>')
			});
			$('table tr > td:nth-child(5)').each(function(){
				var temp = $(this).html();
				$(this).html('<a class="btn btn-danger" onclick="return btndelete_account_onclick(&quot;'+temp+'&quot;)" aria-label="Delete" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i></a>')
			});
		});
	</script>
	<script>
		function btndelete_account_onclick(user){
			if(confirm("Do you wish to delete this user?")){
				post("listing_control.php",{user:user, op:"delete_user"});
			}
		}
		
		function btndelete_onclick(id){
			if(confirm("Do you wish to delete this listing?")){
				post("listing_control.php",{id:id, op:"delete_listing", returnpage:"administration.php"});
			}
		}
		
		function btnreset_password_onclick(user){
			var confirm = prompt("Confirm Admin Password","");
			if(confirm == null || confirm == ""){
				console.log('Password Change Canceled');
			}else{
				var pass = prompt("Enter New Password for: "+user,"");
				if(pass == null || pass == ""){
					console.log('Password Change Canceled');
				}else{
					post("login/login.php",{user:user, pass:pass, admin_pass:confirm, op:"admin_pass"});
				}
			}
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
		//$('table tr > td:nth-child(5)').attr('style', 'background-color:#CCF;');
	</script>
</body>

</html>
