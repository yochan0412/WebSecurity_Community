<?php
    session_start();
    if($_SESSION['id'] > 0)
    {
        if( !isset($_POST['content']) || $_POST['content']=="" )
        {
            header("Location: homepage");
            return;
        }
       
        require_once('config.php');
        mysqli_query($link,"SET NAMES utf8");
        $content = $_POST['content'];
        $id = (int)$_SESSION['id'];
        $num=mysqli_fetch_array(mysqli_query($link,"SELECT MAX(`comment_id`) FROM `comments`"));
        $num[0]++;
        $file_url = NULL;

        if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK)
        {
            if (file_exists('comment_file/' .$num[0] .'_' . $_FILES['my_file']['name']))
            {
                echo "<script>{alert('Repeat file!');location.href='homepage.php'}</script>";
            } 
            else 
            {
                $file = $_FILES['my_file']['tmp_name'];
                $file_url = 'comment_file/' .$num[0] .'_' . $_FILES['my_file']['name'];
            
                move_uploaded_file($file, $file_url);
            }
        } 

        $sql = "INSERT INTO  `comments` (`comment_id`,`user_id`,`content`,`file_url`) VALUES (?,?,?,?);";
        $stmt = mysqli_prepare($link,$sql);
        $stmt->bind_param('iiss',$num[0],$id,$content,$file_url);
        $stmt->execute();


        try 
        {
            if($stmt)
            {
                echo "<script>{alert('Add comment sucessfully!');location.href='homepage.php'}</script>";
            }
            else
            {
                echo "<script>{alert('Failed to add comment.');location.href='homepage.php'}</script>";
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
?>


