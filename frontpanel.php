<!--
//The MIT License (MIT)
//
//Copyright (c) 2014 Cyken Zeraux aka CZauX
//
//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "Software"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:
//
//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.
//
//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.
-->

<?php
require_once(dirname(__FILE__)."/simple_html_dom.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>TF2 Nametracker</title>
<meta charset="UTF-8">
<link href='http://fonts.googleapis.com/css?family=Audiowide&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>


<?php
//Set starting data which can be changed if information is present
$sgeturl = "https://www.gametracker.com/server_info/";
$serverpost = '209.246.143.162:27015';
$playername = 'colgate';
$radioshownumber = '50';

if (isset($_GET["server"])) {
  $serverpost =  $_GET["server"];
  $sgeturl .= $serverpost;
  $sgeturl .= '/top_players/';
}
if (isset($_GET["name"])) {
  $playername =  $_GET["name"];
  $sgeturl .= '?query=';
  $sgeturl .= $playername;
  $sgeturl .= '&Search=Search';
}
if (isset($_GET["shownumber"])) {
  $radioshownumber =  $_GET["shownumber"];
  $sgeturl .= '&searchipp=';
  $sgeturl .= $radioshownumber;
  $sgeturl .= '#search';
}

// Defaults the radio button to 50, will only set to 25 or 10 if exactly met.
if ($radioshownumber === "25" || $radioshownumber === "10") {
  $radio50 = NULL;
  if ($radioshownumber === "25") {
    $radio25 = 'checked="checked"';
  } else {
    $radio25 = NULL;
  }
  if ($radioshownumber === "10") {
    $radio10 = 'checked="checked"';
  } else {
    $radio10 = NULL;
  }
} else {
  $radio25 = NULL;
  $radio50 = 'checked="checked"';
  $radio10 = NULL;
}

$curl_connection = curl_init($sgeturl);
curl_setopt($curl_connection, CURLOPT_HTTPGET, 1);
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 25);
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true);
$receivedpage = curl_exec($curl_connection);
curl_close($curl_connection);

$html = new simple_html_dom();
$html->load($receivedpage);

$receivedpageinsert = '';
foreach($html->find('.table_lst_spn') as $element) {
  $receivedpageinsert .= htmlspecialchars_decode($element, ENT_HTML5);
}
$receivedpageinsert = preg_replace("/<img[^>]+\>/i", "", $receivedpageinsert); 
?>


<div class="container">
	<div id="newbody">
		<?php
		print_r($receivedpageinsert);
		?>
	</div>
	<div id="inputbody">
		<p class="audiowidefont" style="text-align:center;font-size:1.6em;font-height:1.3em;">TF2 Gametracker Nametracker</p>
		<form action="frontpanel.php" method="get" role="form">
			<div class="form-group">
				<label for="exampleInputEmail1">Server IP:PORT</label>
				<input type="text" name="server" class="form-control" id="servport" placeholder="IP:PORT" value="<?php echo ($serverpost);?>">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Name</label>
				<input type="text" name="name" class="form-control" id="servplayername" placeholder="Name" value="<?php echo ($playername);?>">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
			<li style="margin-left:20px;"></li>
			<li>Show</li>
			<li style="margin-left:3px;"><input style="" type="radio" name="shownumber" value="10" <?php echo ($radio10);?>/> 10</li>
			<li><input style="" type="radio" name="shownumber" value="25" <?php echo ($radio25);?>/> 25</li>
			<li><input style="" type="radio" name="shownumber" value="50" <?php echo ($radio50);?>/> 50</li>
			<li>Items</li>
		</form>
		<a href="http://www.gametracker.com/server_info/<?php echo ($serverpost);?>/" target="_blank"><img style="margin-left:auto;margin-right:auto;margin-top:15px;" src="http://cache.www.gametracker.com/server_info/<?php echo ($serverpost);?>/b_560_95_1.png" border="0" width="560" height="95" alt=""/></a>
	</div>
	<div id="javabody">
		<div id="javabodylist">
			<div id="javaleft"></div>
			<div id="javaright">
			</div>
		</div>
		<div id="javamathlist">
			<p class="audiowidefont">Points Overall</p>
			<p class="" id="overpointspost" style="font-size:1.8em;font-weight:bold;">0<p>
			<p class="audiowidefont">Hours Overall</p>
			<p class="" id="overhourspost" style="font-size:1.8em;font-weight:bold;">0<p>
			<p class="audiowidefont">Points/Minute</p>
			<p class="" id="overatiopost" style="font-size:1.8em;font-weight:bold;">NaN<p>
		</div>
	</div>
</div>

<script type="text/javascript" src="gamenametrack.js"></script>
</body>
</html>