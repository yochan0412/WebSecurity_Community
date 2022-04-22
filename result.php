<?php
    if( !isset($_POST['register_account']) || !isset($_POST['register_password']) || !isset($_POST['register_password_again']) || $_POST['register_account']=="" || $_POST['register_password']=="" || $_POST['register_password_again']=="")
    {
        header("Location: index.php");
    }
    else
    {
        $register_account = $_POST['register_account'];
        $register_password =$_POST['register_password'];
        $register_password_again =$_POST['register_password_again'];
        $regex_str= "/[a-zA-Z0-9_$]/";

        if(strlen($register_account) != preg_match_all($regex_str,$register_account) || strlen($register_password) != preg_match_all($regex_str,$register_password) || strlen($register_password_again) != preg_match_all($regex_str,$register_password_again))
        {
            echo "<script>{alert('Account or Password includes illegal character.');location.href='register.php'}</script>";
        }
    
        elseif($register_password != $register_password_again)
        {
            echo "<script>{alert('Password doesn\'t match.');location.href='register.php'}</script>";
        }
    
        elseif( (strlen($register_account)>25) || (strlen($register_account)<1) || (strlen($register_password)>25) || (strlen($register_password)<1) || (strlen($register_password_again)>25) || (strlen($register_password_again)<1) )
        {
            echo "<script>{alert('Account or Password\'s size is wrong.');location.href='register.php'}</script>";
        }
        else
        {
            require_once('config.php');
            $sql = "SELECT * FROM `users` WHERE `account` = '$register_account'";
            $result=mysqli_query($link,$sql);        
            try 
            {
                $row = mysqli_fetch_array($result);   
                if($row)
                {
                    echo "<script>{alert('Account is existed.');location.href='register.php'}</script>";
                }
                else
                {
                    $register_password=encrypt_password($register_password);
                    $num=mysqli_fetch_array(mysqli_query($link,"SELECT MAX(`id`) FROM `users`"));
                    $num[0]++;
                    $insert_sql = "INSERT INTO `users` (`id`,`account`,`password`,`profileimage`) VALUES ($num[0],'$register_account','$register_password','profile_img/default.png')";
                    $insert_result=mysqli_query($link, $insert_sql);
                    mysqli_close($link);

                    if($insert_result)
                    {
                        echo "<script>{alert('Create account sucessfully!');location.href='index.php'}</script>";
                    }
                    else
                    {
                        echo "<script>{alert('Create account Unsucessfully.');location.href='register.php'}</script>";
                    }
                }
            }
            catch (Exception $e) 
            {
                echo 'Caught exception: ', $e->getMessage(), '<br>';
                echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
            }
        }

    }

    function encrypt_password($temp)
    {
        $text = "HaHa_agay";
        $result = hash('sha256',$temp.$text);
        return $result;
    }  
?>
