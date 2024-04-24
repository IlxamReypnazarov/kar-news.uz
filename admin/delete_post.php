<?php
require('../database.php');
if($_SERVER['REQUEST_METHOD']='GET' && $_GET['id'])
{
    $id=$_GET['id'];
    $sql = "DELETE FROM posts WHERE id=$id";
    $conn->exec($sql);
    $delete_message="Record deleted successfully";
    header('Location: view_post.php');
}
$conn = null;
?>