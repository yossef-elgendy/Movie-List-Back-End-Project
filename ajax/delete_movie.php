<?php
require_once ('../dbConfig.php');
if(isset($_POST['id']))
{
    $stmt = $conn->prepare('DELETE FROM movie WHERE movieID='.$_POST['id']);
    $stmt->execute();
    if($stmt->rowCount()>0)
    {
        echo 'wellDone';
    }
}
$conn=null;