<?php
    session_start();
    if( !isset($_POST['account']) || !isset($_POST['password']) || $_POST['account']=="" || $_POST['password']=="" )
    {
        header("Location: index.php");
    }
    else
    {
        $account = $_POST['account'];
        $password =$_POST['password'];
        $regex_str= "/[a-zA-Z0-9_$]/";

        if(strlen($account) != preg_match_all($regex_str,$account) || strlen($password) != preg_match_all($regex_str,$password))
        {
            echo "<script>{alert('Account or Password includes illegal character.');location.href='index.php'}</script>";
        }
        
        elseif( (strlen($account)>25) || (strlen($account)<1) || (strlen($password)>25) || (strlen($password)<1))
        {
            echo "<script>{alert('Account or Password\'s size is wrong.');location.href='index.php'}</script>";
        }
        
        else
        {
            $password=encrypt_password($password);
            require_once('config.php');
            $sql = "SELECT * FROM `users` WHERE `account` = '$account' and `password` = '$password';";

            $result=mysqli_query($link,$sql);
            mysqli_close($link);

            try 
            {
                $row = mysqli_fetch_array($result);   
                if((int)$row[0] > 0)
                {
                    $_SESSION['id']= (int)$row[0];
                    echo "<script>{alert('Welcome! user: $row[1]');location.href='homepage.php'}</script>";
                }
                else
                {
                    echo "<script>{alert('Account or Password is wrong.');location.href='index.php'}</script>";
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
