<?php
//error_reporting(E_ALL & ~E_NOTICE);
// Load the username from somewhere
if (
$username = $_GET["username"]
) {
	//do nothing 
} else {
	$username = "notch";
}

$username = str_replace(' ', '', $username);

//allow the user to change the skin
$skinChange = "<a href='https://minecraft.net/profile/skin/remote?url=http://skins.minecraft.net/MinecraftSkins/$username.png' target='_blank' </a>";

//grabbing the users information
if ($content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username))
) {
  $userSkin3D = "<img src='https://mcapi.ca/skin/3d/$username' />";
  $userSkin2D = "<img src='https://mcapi.ca/skin/2d/$username' />";
} else {
  $content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username) . '?at=0');
if( $http_response_header['0'] == "HTTP/1.1 204 No Content") {
    header ('Location: http://mcspy.info/php.php?username=notch');
}
$json = json_decode($content);

   foreach ($json as $currentName) {
   $currentName = $currentName;
}
   
   $userSkin3D = "<img src='https://mcapi.ca/skin/3d/$currentName' />";
   $userSkin2D = "<img src='https://mcapi.ca/skin/2d/$currentName' />";
}



// Decode it
$json = json_decode($content);

// Check for error
if (!empty($json->error)) {
    die('An error happened: ' . $json->errorMessage);
}

// Save the uuid
$uuid = $json->id;

// Get the history (using $json->uuid)
$content = file_get_contents('https://api.mojang.com/user/profiles/' . urlencode($uuid) . '/names');

// Decode it
$json = json_decode($content);

$names = array(); // Create a new array

foreach ($json as $name) {
    $input = $name->name;

    if (!empty($name->changedToAt)) {
        // Convert to YYYY-MM-DD HH:MM:SS format
        $time = date('Y-m-d H:i:s', $name->changedToAt);

        $input .= ' (changed at ' . $time . ')';
    }

    $names[] = $input; // Add each "name" value to our array "names"

}

//url to users 2D head (avatar)
$usersAvatar = "https://mcapi.ca/avatar/2d/$input/55";

//user's Avatar as favivon
$usersFavicon = "<link rel='shortcut icon' href='$usersAvatar' type='image/png' />";
//use $uuid tp grab UUID of the user - ---- - - - use $names to get name history of the user.



?>

<html>
<head>
	<?php echo $usersFavicon;?>
	<title><?php echo $username?>'s Information</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<title>Find a player skin!</title>
<style>
body {
	background-image: url(http://mcspy.esy.es/grad.jpg);
	background-position: bottom;
	background-repeat: no-repeat;
	background-size: 100% 500px;
}
#content {
	margin-left: auto;
	margin-right: auto;
	width: 60%;
}
img.logo {
	margin-right: auto;
	margin-left: auto;
	display: block;
	padding: 30px;
  max-width: 100%;
  height: auto;
  width: auto\9;
}
.center {
	margin-left: auto;
	margin-right: auto;
}
.footer {
        text-align: center;
}
p.responsive {
  word-wrap: break-word;
}

</style>
</head>
<body>
<a href="https://github.com/WelshJoeyy/MinecraftNameSpy"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://mcspy.info/source.png" alt="View Source on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

<!--debug -->

<?php ?>
<div id="content">

<div class="col-md-12">
	<a href="index.php"><img class="logo" src="http://mcspy.info/logo_big.png"></a>
</div>

<div class="col-md-12">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $username;?>'s UUID</h3>
  </div>
  <div class="panel-body">
    <p class="responsive"><?php echo $uuid;?></p>
  </div>
</div>
</div>

<div class="col-md-8">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $username;?>'s Name History (Oldest to Most Recent)</h3>
  </div>
  <div class="panel-body">
   <?php echo implode(', <br>', $names) ;?>
  </div>
</div>
</div>

<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $username;?>'s Avatar</h3>
  </div>
  <div class="panel-body">
  	<div class="center">
    <?php echo $userSkin3D;?>
    <?php echo $userSkin2D;?>
   </div>
   <p><?php echo $skinChange;?>Change this skin to yours!</a></p>
  </div>
</div>
</div>
<div class="col-md-12">
<div class="btn-group pull-right" role="group" aria-label="">
  <a href="index.php"><button type="button" class="btn btn-default">Search another Username?</button></a>
</div>
</div>
<div class="footer">
	<span>Created by _scrunch</span> &#8226;
	<span>&copy;2015</span> &#8226;
	<span>Find me on <a href="http://www.planetminecraft.com/member/_scrunch/" target="_blank">PMC</a></span><br><span>
Feeling generous? Donate any amount and it will be much appreciated! It will help me keep the domain up!</span>

  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="Y8MWQB9FCUTFJ">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal â€“ The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60633427-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
