<?php
include "./vendor/autoload.php";


$pathToScan = '/media/sauvank/Film/movies/Action/';
$pathImg = './img/';
$pathVideo = './video/';
//splitVideo('test.mkv','00:00:05','00:00:10','output-movie.mkv');

$allFiles = scanFolder($pathToScan,'avi|mp4|mkv');

foreach($allFiles as $key => $value){

    $fullPathVideo = $value['dirname'].'/'.$value['basename'];
    $timeToShoot = '400';
    $pathOutputImg = $pathImg.$value['filename'].'.png';
//    getImageFromVideo($fullPathVideo,$timeToShoot,$pathOutputImg);


    $timeBegin = '00:30:00';
    $timeStop = '00:00:10';
    $pathOutput = $pathVideo.$value['filename'].'.mp4';
    splitVideo($fullPathVideo, $timeBegin, $timeStop, $pathOutput);

}






function splitVideo($fullPathVideo, $timeBegin, $timeStop, $pathOutput){
    var_dump($fullPathVideo);
//    exec('ffmpeg -i '.$titleVideo.' -c copy -ss '.$timeBegin.' -t '.$timeStop.' '.$nameOutput.' -nostats -loglevel 0  --assume-yes');
//    exec('ffmpeg -i '.$fullPathVideo.' -ss '.$timeBegin.' -t '.$timeStop.' -f mp4 -vcodec libx264 -preset fast -profile:v main -acodec aac '.$nameOutput.' -hide_banner');
    exec("ffmpeg -i  '$fullPathVideo'  -ss 00:15:00 -t 00:00:10 -vcodec copy -acodec copy '$pathOutput'");
}

function getImageFromVideo($pathVideo,$timeToShoot, $outPicure){
    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($pathVideo);
    $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($timeToShoot));
    $frame->save($outPicure);
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
