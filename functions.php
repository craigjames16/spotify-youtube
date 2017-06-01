<?php 
class Functions {
    private $tracks;

    function curl($url,$data=0,$auth=0) {
    //open connection
    $ch = curl_init();

    //url-ify the data for the POST
    if ($data) {
        foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&'); 
        
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);   
    }

    //set the url, number of POST vars, POST data
    if ($auth) {
        $authorization = "Authorization: Bearer " . $_SESSION['token'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));    
    }
    
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
    }

    function get_spotify_token() {
        $data = array(
        'client_id' => urlencode(CLIENT_ID),
        'grant_type' => 'authorization_code',
        'code' => urlencode($_GET['code']),
        'client_secret' => urlencode(CLIENT_SECRET),
        'redirect_uri' => urlencode(REDIRECT_URI)
        );

        $response = json_decode($this->curl('https://accounts.spotify.com/api/token',$data,0), true);

        $_SESSION['token'] = $response['access_token'];
    }

    function get_spotify_user() {
        $response = json_decode($this->curl('https://api.spotify.com/v1/me',0,1), true);
        $_SESSION['spotify_userid'] = $response['id'];
        $_SESSION['spotify_username'] = $response['display_name'];
    }

    function get_spotify_user_playlist() {
        $this->get_spotify_token();

        $this->get_spotify_user();
        
        return json_decode($this->curl('https://api.spotify.com/v1/me/playlists',0,1),true);
    }

    function get_spotify_playlist_tracks($playlist_id) {
        $this->tracks = json_decode($this->curl('https://api.spotify.com/v1/users/'.$_SESSION['spotify_userid'].'/playlists/'.$playlist_id.'/tracks',0,1), true);
        $this->get_youtube_videos();
    }

    function get_youtube_videos() {
        foreach ($this->tracks['items'] as $track) {
            $term = urlencode($track['track']['name'] . " - ".$track['track']['artists']['name']);

            $videos = json_decode($this->curl('https://www.googleapis.com/youtube/v3/search?part=snippet&q='.$term.'&maxResults=1&type=video&key='.YOUTUBE_KEY,0,0), true);
            
            $video['youtube_id'] = $videos['items']['0']['id']['videoId'];

            $video_ids[] = $video;
        }
        echo json_encode($video_ids); 
    }
}
