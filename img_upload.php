<?php
    session_start();
    if($_SESSION['id'] > 0)
    {
        if( $_FILES['img_file']['error'] === UPLOAD_ERR_OK)
        {
            require_once('config.php');
            mysqli_query($link,"SET NAMES utf8");
            $id = (int)$_SESSION['id'];
            $before_img_url = mysqli_fetch_array(mysqli_query($link,"SELECT `profileimage` FROM `users` WHERE `id` = $id ;"));

            if (file_exists($before_img_url[0]) && $before_img_url[0] != 'profile_img/default.png')
            {
                unlink($before_img_url[0]);
            } 

            $img_url = 'profile_img/' . $id .'_' . $_FILES['img_file']['name'];
            $file = $_FILES['img_file']['tmp_name'];       
            move_uploaded_file($file, $img_url);
            $sql = "UPDATE `users` SET `profileimage` = '$img_url' WHERE (`id` = $id);";
            $stmt = mysqli_query($link,$sql);
            mysqli_close($link);

            try 
            {
                if($stmt)
                {
                    echo "<script>{alert('Edit profie image sucessfully!');location.href='homepage.php'}</script>";
                }
                else
                {
                    echo "<script>{alert('Failed to Edit profie image.');location.href='homepage.php'}</script>";
                }
            }
            catch (Exception $e) 
            {
                echo 'Caught exception: ', $e->getMessage(), '<br>';
                echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
            }
        }
        else
        {
            echo "<script>{alert('Upload image failed! ');location.href='index.php'}</script>";
            return;
        }     
    }
    else
    {
        echo "<script>{alert('You don't login! ');location.href='index.php'}</script>";
    }

?>


