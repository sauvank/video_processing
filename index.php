<?php
include "./vendor/autoload.php";

splitVideo('test.mkv','00:00:05','00:00:10','output-movie.mkv');

function splitVideo($titleVideo, $timeBegin, $timeStop, $nameOutput){
    exec('ffmpeg -i '.$titleVideo.' -c copy -ss '.$timeBegin.' -t '.$timeStop.' '.$nameOutput.' -nostats -loglevel 0 --assume-ye');
}

function getImageFromVideo($titleVideo, $namePicture){
    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($titleVideo);
    $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2));
    $frame->save($namePicture);
}
?>
