<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
        return;
    }
    if(!isset($_GET['comment_id']))
    {
        header("Location: homepage.php");
        return;
    }

    require_once('config.php');
    mysqli_query($link,"SET NAMES utf8");
    $comment_id = (int)$_GET['comment_id'];
    
    $sql = "SELECT `comment_id`,`file_url` FROM `comments` WHERE `comment_id` = ?";
    $stmt = mysqli_prepare($link,$sql);
    $stmt->bind_param('i',$comment_id);
    $stmt->execute();
    $stmt->bind_result($comment_id,$file_url);
    $file_status = $stmt->fetch();

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $delete_sql = "DELETE FROM `comments` WHERE `comment_id` = $comment_id";
    $delete_stmt = mysqli_query($link,$delete_sql);
    mysqli_close($link);
    try 
    {
        if($delete_stmt)
        {
            if($file_status && is_file($file_url))
            {
                unlink($file_url);
            }
            echo "<script>{alert('Delete comment sucessfully!');location.href='homepage.php'}</script>";
        }
        else
        {
            echo "<script>{alert('Failed to delete comment.');location.href='homepage.php'}</script>";
        }
    }
    catch (Exception $e) 
    {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }
?>
