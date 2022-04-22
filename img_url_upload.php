<?php
    session_start();
    if($_SESSION['id'] > 0)
    {
        if( !isset($_POST['url_file']) || $_POST['url_file'] === "" )
        {
            echo "<script>{alert('Upload image failed! ');location.href='index.php'}</script>";
            return;
        }   

        require_once('config.php');
        mysqli_query($link,"SET NAMES utf8");
        $id = (int)$_SESSION['id'];
        $upload_img_url = $_POST['url_file'];
        $img_url = 'profile_img/' . $id .'_.png' ;

        grab_image($upload_img_url,$img_url);

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
        echo "<script>{alert('You don't login! ');location.href='index.php'}</script>";
    }


    function grab_image($url,$saveto)
    {
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($saveto))
        {
            unlink($saveto);
        }
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
?>


