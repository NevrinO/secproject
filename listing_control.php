<?php
	session_start();
	require 'db.php';
	$db = new db();
	$account_page = "account.php";
	//each page that accesses this code must do so through a POST submit. it must also contain a hidden input called 'op'
	if(isset($_POST['op'])){
		if($_POST['op']==='new_listing')
			new_listing($account_page, $db);
		if($_POST['op']==='delete_listing'){
			delete_listing($db);
			header("location: ".$_POST['returnpage']);
		}
		if($_POST['op']==='delete_img')
			delete_img($account_page, $db);
		if($_POST['op']==='get_listing')
			get_listing("edit_listing.php", $db, $_POST['id']);
		if($_POST['op']==='view_listing')
			get_listing("listing_view.php", $db, $_POST['id']);
		if($_POST['op']==='edit_listing')
			edit_listing($account_page, $db);
		if($_POST['op']==='delete_user'){
			if(delete_user($db)){
				header("location: administration.php?msg=" . urlencode(base64_encode("This User has successfully been removed!")));
			}else{
				header("location: administration.php?msg=" . urlencode(base64_encode("There was an error in removing this user!")));
			}
		}
		if($_POST['op']==='upload_image'){
			$_SESSION['listing_id'] = $_POST['listing_id'];
			header("location: /upload_image/index.html");
		}
	}
	else{
		fail("No Operation Selected");
	}
	
	function delete_user($db){
		$success = false;
		if(isset($_SESSION['user'])){
			echo $_SESSION['user']."<br>";
			echo $db->verify_admin($_SESSION['user']) ? 'true <br>' : 'false <br>';
			if ($db->verify_admin($_SESSION['user'])){
				$result = $db->select_user_listings($_POST["user"]);
				if($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()){
						$result_img = $db->select_listings_images($row["listing_id"]);
						if($result_img->num_rows > 0) {
							while ($row_img = $result_img->fetch_assoc()){
								if(!$db->delete_image($row_img['img_id'],$row["listing_id"], $row_img['img_name']))
									echo $db->error();
							}
						}
						if(!$db->delete_listing($row['listing_id'],$_POST["user"]))
							echo $db->error();
					}
				}
				if($db->delete_user($_POST["user"]))
					$success = true;
			}else{
				fail('Incorrect permissions');
			}
		}
		else{
			fail('No User Logged In');
		}
		return $success;
	}
	
	function new_listing($return_page, $db){
		if(isset($_SESSION['user'])){
			if($db->insert_listing($_SESSION['user'],$_POST))
				header("location: ".$return_page);
			else
				echo $db->error();
		}
		else{
			fail('No User Logged In');
		}
	}
	
	function delete_listing($db){
		if(isset($_SESSION['user'])){
			$result = $db->select_listing($_POST["id"]);
			if($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()){
					$user = $row['user_name'];
				}
			}
			if($user === $_SESSION['user'] or $_SESSION['admin']==1){
				$result = $db->select_listings_images($_POST["id"]);
				if($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()){
						if(!$db->delete_image($row['img_id'],$_POST["id"], $row['img_name']))
							echo $db->error();
					}
				}
				if($db->delete_listing($_POST["id"],$user))
					return;
				else
					echo $db->error();
			}else{
				fail('Incorrect permissions');
			}
			
		}
		else{
			fail('No User Logged In');
		}
	}
	
	function delete_img($return_page, $db){
		if(isset($_SESSION['user'])){
			$result = $db->select_listing($_POST["id"]);
			if($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()){
					$user = $row['user_name'];
				}
				if($user === $_SESSION['user'] or $_SESSION['admin']==1){
					$result = $db->select_image($_POST["img_id"], $_POST["id"]);
					if($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()){
							if($db->delete_image($row['img_id'],$_POST["id"], $row['img_name']))
								header("location: ".$return_page);
							else
								echo $db->error();
						}
					}
					else
								echo $db->error();
				}else{
					fail('Incorrect permissions');
				}
			}
			else{
				fail('Error retrieving user - Potentially not the owning user');
			}
		}
		else{
			fail('No User Logged In');
		}
	}
	
	function get_listing($return_page, $db, $id){
		$result = $db->select_listing($id);
		if ($result->num_rows > 0) {
			unset($_SESSION['query-data']);
			while($row = $result->fetch_assoc()) {
				$_SESSION['query-data'] = $row;
			}
			$result2 = $db->select_listings_images($id);
			if ($result2->num_rows > 0) {
				$_SESSION['query-images'] = [];
				$tempcount = 0;
				while($row2 = $result2->fetch_assoc()) {
					$_SESSION['query-images'][$tempcount]=$row2;
					$tempcount++;
				}
			}else{
			unset($_SESSION['query-images']);
			}
			header("location: ".$return_page);
		}
		else
			echo $db->error();
	}
	function edit_listing($return_page, $db){
		if(isset($_SESSION['user'])){
			if($db->update_listing($_POST['id'],$_SESSION['user'],$_POST))
				header("location: ".$return_page);
			else
				echo $db->error();
		}
		else{
			fail('No User Logged In');
		}
	}
	
	function fail($pub, $pvt = '')
	{
		global $debug;
		$msg = $pub;
		if ($debug && $pvt !== '')
			$msg .= ": $pvt";
	/* The $pvt debugging messages may contain characters that would need to be
	 * quoted if we were producing HTML output, like we would be in a real app,
	 * but we're using text/plain here.  Also, $debug is meant to be disabled on
	 * a "production install" to avoid leaking server setup details. */
		exit("An error occurred ($msg).\n");
	}
?>