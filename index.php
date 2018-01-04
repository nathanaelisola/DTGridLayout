<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
    </head>
    <body>
        <h3>DT Grid Layout</h3>
        <form action="index.php" method="post">
            Descriptive headline: <input type="text" name="headline"><br />
            Product name: <input type="text" name="product"><br />
            Photo URL: <input type="text" name="URL"><br />
            Description: <input type="text" name="desc"><br />
            Affiliate name: <input type="text" name="affname"><br />
            Affiliate link: <input type="text" name="afflink"><br />
            <input type="submit" name="submit">
        </form>
        <?php
        // put your code here
        if (isset($_POST['submit'])){
            $hl = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_STRING);
            $pr = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING);
            $url = filter_input(INPUT_POST, 'URL', FILTER_SANITIZE_STRING);
//            $desc = $_POST['desc'];
                $desc = str_replace('\r','<br />', $_POST['desc']);
//            $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
//                $desc = str_replace(' ', '&nbsp;', $desc);
//                $desc = nl2br($desc);
            
            $affn = filter_input(INPUT_POST, 'affname', FILTER_SANITIZE_STRING);
            $affl = filter_input(INPUT_POST, 'afflink', FILTER_SANITIZE_STRING);
                        
            if ($hl == ""){
                $generatedCode = <<<GENERATEDCODE
<div>
<h2><strong>$pr</strong></h2>
<img class="aligncenter size-large" src="$url" alt="" width="720" height="480" />
\n$desc
\n<p style="text-align: center;"><strong>Buy it now at:</strong></p>
<p style="text-align: center;">[affiliate-link affiliate_name="$affn" affiliate_URL="$affl" class="m-aff-button']$affn\[/affiliate-link]</p>
\n</div>
GENERATEDCODE;
            }
            else {
                $generatedCode = <<<GENERATEDCODE
<div>
<h2 style="text-align: center;"><strong>$hl</strong>
$pr</h2>
<img class="aligncenter size-large" src="$url" alt="" width="720" height="480" />
                        
$desc

<p style="text-align: center;"><strong>Buy it now at:</strong></p>
<p style="text-align: center;">[affilaite-link affiliate_name="$affn" affiliate_url="$affl" class="m-aff-button"]$affn\[/affiliate-link]</p>

</div>
GENERATEDCODE;
            }
                echo "<textarea rows=\"18\" cols=\"130\">$generatedCode</textarea><br />";
                
        }        
        ?>
        
        <a href="index.php">Restart</a>
    </body>
</html>
