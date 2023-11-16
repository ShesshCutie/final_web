<?php
require("config/config.php");
require("config/db.php");

if (isset($_GET['id'])) {
  $del = $_GET['id'];
  //SQL query for deletion.
  $sql = "delete from recordapp_db.office where id=$del";
  $result = mysqli_query($conn, $sql) or die("Connection failed: " . $conn->connect_error);
  if ($result) {

           header("Location: index.php?msg=Record deleted."); 
                   echo 'Record deleted!';
            //$show = 0;
  }

 else {
        echo "Failed".mysqli_error($conn);
 }
 $conn->close();
}

?>