<?php
$uploadedpath=$_GET['path'];

if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
        // Base path
        $base_path = "/var/www/firmware_repo/".$uploadedpath;

        $target_path = $base_path.basename( $_FILES['file']['name']);

        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                echo "The file ".  basename( $_FILES['file']['name']). " has been uploaded";
        } else{
                echo "There was an error uploading the file in $target_path, please try  again!";
        }
}
?>
