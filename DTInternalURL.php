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
        <h3>DT Internal URL Cleaner</h3>
        <br />
        <?php
        // put your code here
        if (isset($_POST['submit'])){
            $originalText = $_POST['oldBody'];
			$lastChar = strlen($originalText);
			$searchStr = '<a class="" href="https://www.digitaltrends.com';
			$endStr = '</a>';
			$offset = 0;
			$test = '';

			$aTagStart = true;
			// while ($aTagStart){
				$aTagStart = strpos($originalText,$searchStr, $offset);
				$urlStart = strpos($originalText, "href=", $aTagStart) + 6;

				$urlLen = strpos($originalText, '/">', $aTagStart) - $urlStart;
				$aTagLen = strpos($originalText, $endStr, $aTagStart) + 4 - $aTagStart;
				
				$url = subStr($originalText, $urlStart, $urlLen + 1);
				$aTag = subStr($originalText, $aTagStart, $aTagLen);	

				$linkTextStart = strpos($originalText, '>', $aTagStart) + 1;
				$linkTextLen = strpos($originalText, '<' ,$linkTextStart) - $linkTextStart;
				$linkText = subStr($originalText, $linkTextStart, $linkTextLen);
				
				$offset = $aTagStart + $aTagLen;
				
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url
				,	CURLOPT_HEADER => 0
				,	CURLOPT_RETURNTRANSFER => 1
				,	CURLOPT_ENCODING => 'gzip'
				));
				$html = curl_exec($ch);

				$doc = new DomDocument();
				$doc->validateOnParse = true;
				$doc->Load($html);
				
				
				$bodyTag = $doc->getElementById('t-comments');
	
				echo $bodyTag;
				// foreach ($bodyTag as $tag){
					// echo $tag->nodeValue, PHP_EOL;
				// }
				
				// $postIDStart = strpos($html, "data-post-id=") + 14;
				// $postIDLen = strpos($html, ' ', $postIDStart + 1) - ($postIDStart + 1);
				
				// $postID = subStr($html, $postIDStart, $postIDLen);
				
				// $test = "$test\n$url|$offset|$postIDStart|$postIDLen|$postID";
				$offset = $aTagStart + $aTagLen;

			// }
			// echo "<textarea class=\"output\">$test</textarea>";


        }
        else {
            echo '<form action="DTInternalURL.php" method="post">
            <label for="oldBody">Insert body of HTML text:</label><textarea name="oldBody" class="bodyText"></textarea><br />
            <input type="submit" name="submit" id="submit">
        </form>';
        }
        ?>
        
        <p><a href="index.php" class="nav">Home</a> <a href="DTInternalURL.php" class="nav">Restart</a></p>
    </body>
</html>
