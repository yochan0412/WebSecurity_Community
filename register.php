<title>Community_Register</title>
<h1>Register Your Account</h1>

<form method="POST" action="result.php">
    <h4>Account and Password only allow bottom lines, dollor signs, numbers, and alphabets in English</h4>
    <h4>And You must input at least one character and not over 25</h4>
    <input id="register_account" placeholder="Account" required="" autofocus="" type="text" name="register_account" oninput="if(value.length>25)value=value.slice(0,25)"><br><br>
    <input id="register_password" placeholder="Password" required="" type="password" name="register_password" oninput="if(value.length>25)value=value.slice(0,25)"><br><br>
    <input id="register_password_again" placeholder="Password_Again" required="" type="password" name="register_password_again" oninput="if(value.length>25)value=value.slice(0,25)"><br><br>
    <button  type="submit">Register</button>
</form>

