<?php

// Load the username from somewhere
if (
$username = $_POST["username"]
) {
	//do nothing 
} else {
	$username = "notch";
}
//user's skin
$userSkin = "<img src='https://mcapi.ca/skin/3d/$username' />";

//allow the user to change the skin
$skinChange = "<a href='https://minecraft.net/profile/skin/remote?url=http://skins.minecraft.net/MinecraftSkins/$username.png' target='_blank' </a>";

//url to users 3D head (avatar)
$usersAvatar = "https://minotar.net/cube/$username/100.png";

//user's Avatar as favivon
$usersFavicon = "<link rel='shortcut icon' href='$usersAvatar' type='image/png' />";

// Get the userinfo
$content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username));

// Decode it
$json = json_decode($content);

// Save the uuid
$uuid = $json->id;

// Get the history (using $json->uuid)
$content = file_get_contents('https://api.mojang.com/user/profiles/' . urlencode($uuid) . '/names');

// Decode it
$json = json_decode($content);

$names = array(); // Create a new array

foreach ($json as $name) {
    $names[] = $name->name; // Add each "name" value to our array "names"
}

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
	background-image: url(grad.jpg);
	background-position: bottom;
	background-repeat: no-repeat;
	background-size: 100% 500px;
	min-width: 1320px;
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
}
.center {
	margin-left: auto;
	margin-right: auto;
}
.footer {
        text-align: center;
}
</style>
</head>
<body>

<!--debug -->

<?php ?>
<div id="content">

<div class="col-md-12">
	<img class="logo" src="logo.png">
</div>

<div class="col-md-12">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $username;?>'s UUID</h3>
  </div>
  <div class="panel-body">
    <?php echo $uuid;?>
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
   	<?php echo $userSkin;?>
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
	<span>Find me on <a href="http://www.planetminecraft.com/member/tacolover22/" target="_blank">PMC</a></span>
</div>
</div>
</body>
</html>	
