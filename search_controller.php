<?php 
	session_start();
	require 'db.php';
	$db = new db();
	$return_page = "search.php";

	$name = $db->mysql_entities_fix_string($_GET['name']);
	$state = $db->mysql_entities_fix_string($_GET['state']);
	$venue = (isset($_GET['venue']))?$db->mysql_entities_fix_string($_GET['venue']):'';
	$artist = (isset($_GET['artist']))?$db->mysql_entities_fix_string($_GET['artist']):'';
	$query = ' SELECT * FROM listings WHERE (name LIKE "%'.$name.'%" OR city LIKE "%'.$name.'%") ';
	if($state != ''){
		$query = $query.'AND state = "'.$state.'" ';
	}
	
	if($venue === 'venue' xor $artist === 'artist'){
		
		$query = $query.'AND type = "'.$venue.$artist.'" ';
	}
	$result = $db->query($query);


	if ($result->num_rows >= 0) {
		$_SESSION['search-data'] = [];
		while($row = $result->fetch_assoc()) {
			$result2 = $db->get_thumbnail($row['listing_id']);
			if($result2->num_rows > 0){
				$row['thumbnail-data'] = $result2->fetch_assoc();
			}
			array_push($_SESSION['search-data'],$row);
		}
		header("location: ".$return_page);
	}
	else
		echo $db->error();









?>