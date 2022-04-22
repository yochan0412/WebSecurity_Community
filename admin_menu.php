<?php
    session_start();
    if($_SESSION['id'] === 1) {
?>
    <html>
        <h4>Edit homepage title</h4>
        <button style="margin: 2px;" onClick="window.location.href='homepage.php';" >HomePage</button>
        <br><br>
        <form id="edit_form" method="POST" action="edit_title.php" >

            <input id="title" placeholder="Title_name" required="" autofocus="" type="text" name="title"><br><br>
            
            <button type="button" onClick="clickfunc()">Edit</button>
        </form>

        <script>
            function clickfunc()
            {
                var result = confirm ('Do you want to revise title?');
                if(!result)
                {
                    header("Location: admin_menu.php");
                }
                else
                {
                    document.getElementById('edit_form').submit();
                }
            }
    </script>
    </html>
<?php
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



