<?php
error_reporting(E_ALL & ~E_NOTICE);
// Load the username from somewhere
if (
$username = $_POST["username"]
) {
	//do nothing 
} else {
	$username = "notch";
}


//allow the user to change the skin
$skinChange = "<a href='https://minecraft.net/profile/skin/remote?url=http://skins.minecraft.net/MinecraftSkins/$username.png' target='_blank' </a>";

//url to users 3D head (avatar)
$usersAvatar = "https://mcapi.ca/avatar/2d/$username/55";

//user's Avatar as favivon
$usersFavicon = "<link rel='shortcut icon' href='$usersAvatar' type='image/png' />";

//grabbing the users information
if ($content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username))
) {
  $userSkin = "<img src='https://mcapi.ca/skin/3d/$username' />";
} else {
  $content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username) . '?at=0');
   $json = json_decode($content);

   foreach ($json as $currentName) {
    $input = $currentName->name;
   }
   
   $userSkin = "<img src='https://mcapi.ca/skin/3d/$currentName' />";
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
	background-image: url(http://minecraftnamespy.esy.es/grad.jpg);
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
<a href="https://github.com/WelshJoeyy/MinecraftNameSpy"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://minecraftnamespy.esy.es/source.png" alt="View Source on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

<!--debug -->

<?php ?>
<div id="content">

<div class="col-md-12">
	<img class="logo" src="http://minecraftnamespy.esy.es/logo.png">
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
