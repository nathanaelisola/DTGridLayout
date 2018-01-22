<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>

    <body>
        <h3>DT Grid Layout</h3>
        <br />
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
<p style="text-align: center;">[affiliate-link affiliate_name="$affn" affiliate_URL="$affl" class="m-aff-button']$affn-sp-[/affiliate-link]</p>
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
<p style="text-align: center;">[affilaite-link affiliate_name="$affn" affiliate_url="$affl" class="m-aff-button"]$affn-sp-[/affiliate-link]</p>

</div>
GENERATEDCODE;
            }
                $generatedCode = str_replace("-sp-","",$generatedCode);
                echo "<textarea class=\"output\">$generatedCode</textarea><br />";
                
        }
        else { 
            
            echo '
        <form id="layoutForm" action="DTGridLayout.php" method="post">
            <label for="headline">Descriptive headline:</label><textarea name="headline"></textarea><br />
            <label for="product">Product name:</label><textarea name="product"></textarea><br />
            <label for="desc">Description:</label><textarea class="desc" name="desc"></textarea><br />
            <label for="URL">Photo URL:</label><textarea name= name="URL"></textarea><br />
            <label for="affname">Affiliate name:</label><textarea name= name="affname"></textarea><br />
            <label for="afflink">Affiliate link:</label><textarea name= name="afflink"></textarea><br />
            <input type="submit" name="submit" id="submit">
        </form>            
        ';
        }
        ?>
        
        <p><a href="index.php">Home</a> <a href="DTGridLayout.php">Restart</a></p>
    </body>
</html>
