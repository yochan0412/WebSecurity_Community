<?php
    session_start();
    if($_SESSION['id'] > 0)
    {
        header("Location: homepage.php");
    }

?>

<title>Community_Login</title>
<h1>Hello ! Welcome !</h1>

<form method="POST" action="login.php">

    <input id="account" placeholder="Account" required autofocus="" type="text" name="account" oninput="if(value.length>25)value=value.slice(0,25)"><br><br>
    <input id="password" placeholder="Password" required type="password" name="password" oninput="if(value.length>25)value=value.slice(0,25)"><br><br>

    <button  type="submit">Login</button>
</form>

<h4>Or you don't have an account?</h4>
<button onClick="window.open('register.php')" type="submit" >Register</button> 

<h4>I forget my password</h4>
<button onClick="alert('怪我?')" type="submit" >Find my password</button> <br><br>

<?php
    require_once('config.php');
    $sql = "SELECT * FROM `users`";
    $result=mysqli_query($link,$sql);
    mysqli_close($link);
    $num = mysqli_num_rows($result);
    echo "Total users amount : $num";
?>