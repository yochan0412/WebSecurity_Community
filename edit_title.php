<?php
    session_start();
    if($_SESSION['id'] ===1)
    {
        if( !isset($_POST['title']) || $_POST['title']=="" )
        {
            header("Location: admin_menu.php");
        }

        $title = $_POST['title'];

        require_once('config.php');
        mysqli_query($link,"SET NAMES utf8");
        $sql = "UPDATE comments SET `comment_title` = '$title' WHERE `comment_id`= 0 ";
        $result=mysqli_query($link,$sql);
        mysqli_close($link);

        try 
        {
            if($result)
            {
                echo "<script>{alert('Revise title sucessfully.');location.href='homepage.php'}</script>";
            }
            else
            {
                echo "<script>{alert('Failed to revise title.');location.href='admin_menu.php'}</script>";
            }
        }
        catch (Exception $e) 
        {
            echo 'Caught exception: ', $e->getMessage(), '<br>';
            echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
        }
    }
    elseif($_SESSION['id'] > 1)
    {
        header("Location: homepage.php");
    }
    else
    {
        header("Location: index.php");
    }
    
?>
