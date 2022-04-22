<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
        return;
    }
    if(!isset($_GET['comment_id']))
    {
        header("Location: homepage.php");
        return;
    }
?>
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
        <script>
                function deleteComment(id)
                {
                    window.location = "/delete_comment.php?comment_id="+id;
                }
        </script>
</head>
    <div style="margin-top:5px; border: 1px; border-style: solid; width: 97%; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
    <table class="comment_table" style="min-width: 800px; margin-top: 10px;">
    <thead>
    <td style="width: 15%;">Profile_Img</td>
    <td style="width: 60%;">Comment</td>
    <td style="width: 10%;">File</td>
    <td style="width: 10%;">User</td>
    <td style="width: 15%;">Op</td>
    </thead>
    <tbody>

<?php
    require_once('config.php');
    mysqli_query($link,"SET NAMES utf8");
    $comment_id = (int)$_GET['comment_id'];
    $sql = "SELECT `comment_id`,`user_id`,`content`,`file_url`,`account`,`profileimage`  FROM comments INNER JOIN users ON comments.user_id = users.id WHERE `comment_id` = ?";
    $stmt = mysqli_prepare($link,$sql);
    $stmt->bind_param('i',$comment_id);
    $stmt->execute();
    $stmt->bind_result($comment_id,$user_id,$content,$file_url,$account,$profileimage);

    while($stmt->fetch())
    {
        
        echo "<tr>";
        echo "<td> <img src=\"".$profileimage."\" width=\"100\" height=\"100\"></td>";
        echo "<td>".bb_parse($content)."</td>";
        echo "<td>";
        if($file_url!=null)
        {
            echo '<a href="'.$file_url.'">'.substr($file_url, 13).'</a>';
        }
        echo "</td>";
        echo "<td>".$account."</td>";

        echo "<td>";
        if($_SESSION['id'] === (int)$user_id)
        {
            echo "<button onclick=\"deleteComment(".$comment_id.");\">X</button>"; 
        } 
        echo "</td>";

        echo "</tr>";
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
    </tbody>
    </table>
</div>
