<?php


$pathToScan = '/media/sauvank/Film/movies/Action/';
//$pathToScan = './video/';
$pathImg = './img/';
$pathVideo = './videos_mp4/';
//splitVideo('test.mkv','00:00:05','00:00:10','output-movie.mkv');

$allFiles = scanFolder($pathToScan,'avi|mp4|mkv');

foreach($allFiles as $key => $value){

    $timeBegin = '00:15:00';
    $timeStop  = '00:00:15';

    $fullPathVideo   = $value['dirname'].'/'.$value['basename'];
    $pathOutputImg   = $pathImg.$value['filename'].'.png';
    $pathOutputVideo = $pathVideo.$value['filename'].'.mp4';

    getImageFromVideo($fullPathVideo,$timeBegin,$pathOutputImg);
    splitVideo($fullPathVideo, $timeBegin, $timeStop, $pathOutputVideo);

}

function splitVideo($fullPathVideo, $timeBegin, $timeStop, $pathOutput){
    $cmd = "ffmpeg -i  '$fullPathVideo' -f mp4 -vcodec libx264 -preset fast -profile:v main -acodec aac -strict -2 -ss $timeBegin -t $timeStop '$pathOutput'  -nostats -loglevel 0 -hide_banner";
    exec($cmd);
}

function getImageFromVideo($pathVideo,$timeToShoot, $outPicture){
   $cmd = "ffmpeg -i '$pathVideo' -ss '$timeToShoot'  -vframes 1 -q:v 2 '$outPicture'";
   exec($cmd);
}

function scanFolder($path,$extention){

    $scan = [];
    $di = new RecursiveDirectoryIterator($path);
    foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
        if(!preg_match('/.*.('.$extention.')$/',$filename) ) {
            continue;
        }

        $info = pathinfo($filename);
        $scan[] = $info;
    }
    return $scan;
}
?>
