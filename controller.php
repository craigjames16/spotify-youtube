<?php
session_start(); 
require_once('config.php');
require_once('functions.php');

$functions = new Functions();

if (isset($_GET['code'])) {
    $playlist = $functions->get_spotify_user_playlist();
}

if (isset($_GET['playlistid'])) {
    return $functions->get_spotify_playlist_tracks($_GET['playlistid']);
}

