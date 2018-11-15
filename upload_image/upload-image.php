<?php
session_start();

if ( isset($_FILES["file"]["type"]) )
{
  $max_size = 1000 * 1024; // 1000 KB
  $destination_directory = "upload/".$_SESSION['listing_id']."/";
  $validextensions = array("jpeg", "jpg", "png");

  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);

  // We need to check for image format and size again, because client-side code can be altered
  if ( (($_FILES["file"]["type"] == "image/png") ||
        ($_FILES["file"]["type"] == "image/jpg") ||
        ($_FILES["file"]["type"] == "image/jpeg")
       ) && in_array($file_extension, $validextensions))
  {
    if ( $_FILES["file"]["size"] < ($max_size) )
    {
      if ( $_FILES["file"]["error"] > 0 )
      {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Error: <strong>" . $_FILES["file"]["error"] . "</strong></div>";
      }
      else
      {
		if (!file_exists("upload/".$_SESSION['listing_id']."/") ){
			 mkdir("upload/" . $_SESSION['listing_id'], 0777);
		}
        if ( file_exists($destination_directory . $_FILES["file"]["name"]) )
        {
          echo "<div class=\"alert alert-danger\" role=\"alert\">Error: File <strong>" . $_FILES["file"]["name"] . "</strong> already exists.</div>";
        }
        else
        {
          $sourcePath = $_FILES["file"]["tmp_name"];
          $targetPath = $destination_directory . $_FILES["file"]["name"];
          move_uploaded_file($sourcePath, $targetPath);

          /*echo "<div class=\"alert alert-success\" role=\"alert\">";
          echo "<p>Image uploaded successful</p>";
          echo "<p>File Name: <a href=\"". $targetPath . "\"><strong>" . $targetPath . "</strong></a></p>";
          echo "<p>Type: <strong>" . $_FILES["file"]["type"] . "</strong></p>";
          echo "<p>Size: <strong>" . round($_FILES["file"]["size"]/1024, 2) . " kB</strong></p>";
          echo "<p>Temp file: <strong>" . $_FILES["file"]["tmp_name"] . "</strong></p>";
          echo "</div>";*/
		  require_once '../db.php';
		  $db = new db();
		  if($result = $db->insert_image($_SESSION['listing_id'],$_FILES["file"]["name"])){
			$_SESSION['listing_id'] = null;
			echo '<script>window.location.href = "../account.php";</script>';
			//header("location: ../account.php");
			die();
		  }
		  else{
			echo "some db error";
		  }
        }
      }
    }
    else
    {
      echo "<div class=\"alert alert-danger\" role=\"alert\">The size of image you are attempting to upload is " . round($_FILES["file"]["size"]/1024, 2) . " KB, maximum size allowed is " . round($max_size/1024, 2) . " KB</div>";
    }
  }
  else
  {
    echo "<div class=\"alert alert-danger\" role=\"alert\">Unvalid image format. Allowed formats: JPG, JPEG, PNG.</div>";
  }
}

?>
