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
        <link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
        
    </head>

    <body>
		<div align="center">
        <h3>DT Infogram Generator</h3>
        <br />
        <?php
        // check for existing form submission
        if (isset($_POST['submit'])){
			
            $originalText = $_POST['infogram'];
            
			// this if prevents user from entering text too small. any smaller than 6 chars generates an error
			// as is, user can enter gibberish and still get output, which is fine
            if (strlen($originalText) > 6){
                $idStart = strpos($originalText,"id=") + 4;
                $idLen = strpos($originalText,"\"",$idStart) - $idStart;
                $id = substr($originalText, $idStart, $idLen);

                $titleStart = strpos($originalText,"title=") + 7;
                $titleLen = strpos($originalText,"\"",$titleStart) - $titleStart;
                $title = substr($originalText, $titleStart, $titleLen);


				// creates output
                 $generatedCode = <<<CODE
[embed-module shortcode="infogram-responsive" id="$id" title="$title"]
CODE;
            
            
                echo "<textarea class=\"output\">$generatedCode</textarea>";                
            }
			
			// for input too short.
            else {
                echo "<p>That input is not long enough.</p><br />";
            }

                
        }
        else {
            echo '<form action="DTInfogram.php" method="post">
            <label for="infogram">Insert infogram text:</label><textarea name="infogram"></textarea><br />
            <input type="submit" name="submit" id="submit" onclick=getFormData()>
        </form>';
        }
        ?>
        
        <p><a href="index.php" class="nav">Home</a> <a href="DTInfogram.php" class="nav">Restart</a></p>
		</div>
    </body>
</html>
