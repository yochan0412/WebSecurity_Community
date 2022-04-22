<?php
    session_start();
    if($_SESSION['id'] > 0) 
    {
?>
<html>
    <head>
        <style>
            .comment_table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            .comment_table tr, .comment_table th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            }

            .comment_table tr:nth-child(even) {
            background-color: #dddddd;
            }
}
        </style>
    </head>
    <H1>Welcome to comment</H1>
    <div style="border: 1px; border-style: solid; width: 40%; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
        <h2>Change Profile Image</h2>
        <button style="" onClick="
            document.getElementById('url_file_div').style.display='initial';
            document.getElementById('img_file_div').style.display='none';
        " >Profile_URL </button>
        <button style="" onClick="
            document.getElementById('url_file_div').style.display='none';
            document.getElementById('img_file_div').style.display='initial';
        " >Profile_Local </button>
        <div id="img_file_div" style="display: none;">
            <form enctype="multipart/form-data" action="img_upload.php" method="POST">
                <input type="file" name="img_file" />
                <button type="submit" style="width: 60px; height: 50px;">Submit</button>
            </form>
        </div>
        <div id="url_file_div" style="">
            <form action="img_url_upload.php" method="POST">
                <input type="text" name="url_file" required />            
                <button type="submit" style="width: 60px; height: 50px;">Submit</button>
            </form>
        </div>
    </div>
    <button style="position: absolute; top: 17px; left: 350px;" onClick="location.href='logout.php';">Logout</button>
<?php
    if($_SESSION['id'] === 1)
    {
        echo '<button style="position: absolute; top: 17px; left: 430px;" onClick="location.href=\'admin_menu.php\';">Admin_Menu</button>';
    }
?>
    <div style="margin-top:5px; border: 1px; border-style: solid; width: 40%; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
        <h2>RESPECT, FRIENDLY, PEACE</h2>
        <form enctype="multipart/form-data" action="post_comment.php" method="POST">
            <table>
                <tr>
                    <td>
                        <textarea name="content" autofocus="" placeholder="Your comment..." required cols="30" rows="5"></textarea>
                    </td>
                    <td>
                        <button type="submit" style="margin-left:20px; width: 60px; height: 50px;">Submit</button>
                    </td>
                </tr>
            </table>
            <br><br>
            <input type="file" name="my_file" />
        </form> 
    </div>
<?php
        require_once('config.php');
        $data_sql = "SELECT `comment_id`,`user_id`,`content`,`file_url`,`account`,`profileimage` FROM comments INNER JOIN users ON comments.user_id = users.id ORDER BY `comment_id` DESC";
        mysqli_query($link,"SET NAMES utf8");
        $data_result=mysqli_query($link,$data_sql);
        $title_sql = "SELECT `comment_title` FROM `comments` WHERE `comment_id`= 0 ";
        $title_result=mysqli_query($link,$title_sql);
        $title = mysqli_fetch_array($title_result);
        echo "<title>$title[0]</title>";
?>
    <div style="margin-top:5px; border: 1px; border-style: solid; width: 97%; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
        <table class="comment_table" style="min-width: 800px; margin-top:100px;">
        <thead>
        <td style="width: 15%;">Profile_Img</td>
        <td style="width: 60%;">Comment</td>
        <td style="width: 10%;">File</td>
        <td style="width: 10%;">User</td>
        <td style="width: 15%;">Op</td>
        </thead>
        <tbody>
            <script>
                function subComment(id)
                {
                    window.location = "/detail_comment.php?comment_id="+id;
                }
                function deleteComment(id)
                {
                    window.location = "/delete_comment.php?comment_id="+id;
                }
            </script>
<?php
        for($i=0;$i<mysqli_num_rows($data_result);$i++)
        {
            $data = mysqli_fetch_row($data_result);
            echo "<tr>";
            echo "<td> <img src=\"".$data[5]."\" width=\"100\" height=\"100\"></td>";
            echo "<td onclick=\"subComment(".$data[0].");\">".bb_parse($data[2])."</td>";
            echo "<td>";
            if($data[3]!=null)
            {
                echo '<a target="_blank" href="'.$data[3].'">'.substr($data[3], 13).'</a>';
            }
            echo "</td>";
            
            echo "<td>".$data[4]."</td>";

            echo "<td>";
            if($_SESSION['id'] === (int)$data[1])
            {
                echo "<button onclick=\"deleteComment(".$data[0].");\">X</button>"; 
            } 
            echo "</td>";
            echo "</tr>";
        }
?>
        </tbody>
        </table>
    </div>
<?php
    }
    else
    {
        header("Location: index.php");
    }

    function bb_parse($string) { 
        $tags = 'b|i|u|color|img'; 
        while (preg_match_all('/\[('.$tags.')=?(.*?)\](.+?)\[\/\1\]/s', $string, $matches)) foreach ($matches[0] as $key => $match) { 
            list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]); 
			
            switch ($tag) { 
                case 'b': $replacement = "<b>$innertext</b>"; break; 
                case 'i': $replacement = "<i>$innertext</i>"; break; 
                case 'u': $replacement = "<u>$innertext</u>"; break; 
                case 'color': $replacement = "<span style=\"color: $param;\">$innertext</span>"; break; 
                case 'img':
					$width = $height = '';
					if($param) list($width, $height) = preg_split('`[Xx]`', $param); 
					$replacement = "<img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/>'; 
				break;
            } 
            $string = str_replace($match, $replacement, $string); 
        } 
        return $string; 
    }

?>
</html>