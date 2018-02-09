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

		<script src="assets/js/DTfunctions.js"></script>
		<style>
			.hidden {display: none;}
		</style>
    </head>

    <body><div align="center">
        <h3>DT Grid Layout</h3>
        <br />
		<div id="form-div">
			<form id="layoutForm">
				<textarea id="oldGridBody" name="oldBody" class="bodyText" placeholder="Paste the text you want to modify into this box"></textarea>
				<br />
				<input type="button" name="submit" id="submit" value="View" onclick="pullForm()">
			</form></div>         
       
		<!--
		<div id="preview-div" class="hidden"><object id="preview-obj" type="text/html"></object></div>
        -->
		<div id="preview-div" class="hidden" ></div>
		<br />
		
		<div id="output-div" class="hidden"><textarea id="output-grid" class="output-grid"></textarea></div>

        <a href="index.php" class="nav">Home</a> <a href="DTGridLayout.php" class="nav" onclick="clearSaveData()">Restart</a>
    </div></body>
</html>
