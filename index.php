<?php 
include('controller.php');
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <!-- Basic Page Needs-->
  <meta charset="utf-8">
  <title>Spotify Youtube Connect</title>

  <!-- Mobile Specific Metas-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS-->
  <link rel="stylesheet" href="css/style.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!--JS-->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>

</head>
<body>
<!--Page Layout-->
<div class="page">
  <div class="content"> 
    <div class="main-connect">
      <? if(!isset($playlist) || $playlist['error']) {
          echo"<h2>Connect Spotify</h2><a href=https://accounts.spotify.com/authorize/?client_id=84aa4ce44f674897949f684ffb2fa341&response_type=code&redirect_uri=".REDIRECT_URI."&scope=user-read-private%20user-read-email&state=spotify><img src=img/Spotify_Logo.png></a>";
      } else {
        echo "<h2>Spotify Playlists</h2><p>Connected as: <b>".$_SESSION['spotify_username']."</b></p>";
        foreach ($playlist['items'] as $item) { 
          echo '<a href=javascript:void(0) onclick=getTrack("'.$item['id'].'")>'.$item['name'].'</a><br>';
        } 
      } ?>  
    </div>  
    <div class="list"></div>
    <div id="loader"></div>
  </div>
</div>
  
</body>
</html>
