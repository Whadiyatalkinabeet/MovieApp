 <?php
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=6d64a72486b47e66eaf157cafc5a0860&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1";
    $fcon = fopen($url, "r");
    if ($fcon) {
        while (!feof($fcon)) $data_json .= fgets($fcon, 4096);
        fclose($fcon);
        if($data_json!='') {
            $data_array = json_decode($data_json, true);
            echo $data_array['object']['results'][0]['title'];
        } else echo "no data";
    }
    else{
        echo "yes";
    }
?> 