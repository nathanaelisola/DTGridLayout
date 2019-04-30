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
		<h3>DT Internal URL Cleaner</h3>
        <br />
        <?php
        // checks if data has been submitted to be processed
        if (isset($_POST['submit'])){

			// declaring variables
			$debug = 0;
			$originalText = $_POST['oldBody'];
			$lastChar = strlen($originalText);
			$searchStr = '<a class="" href="https://www.digitaltrends.com';
			$endStr = '</a>';
			$test = ''; 
			$numOfLinks = substr_count($originalText, $searchStr); // determine how many links to change
			$count = 0; // track number of loops to be run
			$offset = 0;
			$vd[$numOfLinks] = array();
			
			// will loop for only the number of DT links it finds, otherwise loop was running once extra
  			while ($count < $numOfLinks){
				$varprint = "";
				// get starting point for our strings
				$aTagStart = strpos($originalText,$searchStr, $offset);
				$urlStart = strpos($originalText, "href=", $aTagStart) + 6;

				// get lengths of our strings
				$urlLen = strpos($originalText, '/">', $aTagStart) - $urlStart;
				$aTagLen = strpos($originalText, $endStr, $aTagStart) + 4 - $aTagStart;
				
				// create our strings
				$url = subStr($originalText, $urlStart, $urlLen + 1);
				$aTag = subStr($originalText, $aTagStart, $aTagLen);	

				// <a>get this text to put into internal links later</a>
				$linkTextStart = strpos($originalText, '>', $aTagStart) + 1;
				$linkTextLen = strpos($originalText, '</a>' ,$linkTextStart) - $linkTextStart;
				$linkText = subStr($originalText, $linkTextStart, $linkTextLen);			
				
				// connect to website, setting parameters necessary to get the proper html to parse_ini_file
				// prior to the setopts below, not every DT link was giving me the html. now it seems to work  on all links
				$ch = curl_init();
				   curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
				   curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
				   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				   curl_setopt($ch, CURLOPT_VERBOSE, 1);
				   curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
				   
				// actual html gets downloaded here   
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url
				,	CURLOPT_HEADER => 0
				,	CURLOPT_RETURNTRANSFER => 1
				,	CURLOPT_ENCODING => 'gzip'
				));
				$html = curl_exec($ch);
				// search in html for the postid, make a string of it
				//$bodyclasstext = strpos($html, "<body class=");
				$bodyclasstext = strpos($html, "data-post-id=\"");
//				$postIDStart = strpos($html, "postid", $bodyclasstext);				
				$postIDStart = strpos($html, "data-post-id=\"");				
				
				
				// when postID != "" then we have a postID, good to go. ignores links that have no postID
				if ($postIDStart != ""){
				$postIDStart += 14;
				//$postIDLen = strpos($html, ' ', $postIDStart) - ($postIDStart);
				$postIDLen = strpos($html, '"', $postIDStart) - $postIDStart;
				$postID = subStr($html, $postIDStart, $postIDLen);
				
			
								
				// formatting for the internal link				
				$replacementString = <<<STRING
[internal-link post_id="$postID"]$linkText-sp-[/internal-link]
STRING;
				// the [ bracket doesn't play well having variable names right next to it, so my solution
				// was to modify the replacement string slightly and then unmodify it after the variable get put in
				$replacementString = str_replace("-sp-","",$replacementString);
				
				// modifies the text
				$originalText = str_replace($aTag, $replacementString, $originalText);
				
				}
				else{
					$offset = $aTagStart + $aTagLen;
				}
				
				if ($debug > 0){
					if ($debug == 1){
						$varprint  = "atag: start-".$aTagStart." len-".$aTagLen." aTag-".$aTag."\n";
						$varprint = $varprint . " url: start-".$urlStart." len-".$urlLen." url-".$url."\n";
						$varprint = $varprint . "link: start-".$linkTextStart." len-".$linkTextLen." link-".$linkText."\n";
						$varprint = $varprint . " pid: start-".$postIDStart." len-".$postIDLen." pid-".$postID."\n";
						$varprint = $varprint . $replacementString . "\n\n";
						$vd[$count] = $varprint;
					}
					if ($debug == 2){
						$varprint = $html . "\n\n";
					}
				}	
				$count++;
			}
	
			// outputs modified text
			
			if ($debug == 1){
				$varprint = "";
				for ($i = 0; $i < $numOfLinks; $i++){
					$varprint = $varprint . $vd[$i];
				}
			}
	
			echo "<textarea class=\"output-newBody\">$varprint$originalText</textarea>";

			// debugging, just change the textarea contents to view variables and whatnot	
//			echo "<textarea class=\"output-newBody\">$linkText|$linkTextStart |$linkTextLen</textarea>";
			 
        } 
		
		// when no form data has been entered
        else {
            echo '<form action="DTInternalURL.php" method="post">
            <label for="oldBody">Insert body of HTML text:</label><textarea name="oldBody" class="bodyText"></textarea><br />
            <input type="submit" name="submit" id="submit">
        </form>';
        }
        ?>
        
        <p><a href="index.php" class="nav">Home</a> <a href="DTInternalURL.php" class="nav">Restart</a></p>
		</div>
	</body>
</html>
