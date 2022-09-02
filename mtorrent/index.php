<?php
require_once 'Torrent.php';
//
$txtFile = '/var/www/html/fdp/public/torrent/t-url.txt';
//
$group = array(
 'HM' => 'ga', '3D' => 'ga',
 'BM' => 'ge',
 'PM' => 'gf', 'DM' => 'gf',
 'LM' => 'gh',
 'ANI' => 'gg',
 'SBM' => 'gk',
 'GM' => 'gc'
);

$file = fopen($txtFile,"r");
while(! feof($file))
{
   $filePath = fgets($file);
   $filePath = trim($filePath);
   if (strpos($filePath, 'var/www/html') !== false) {
   //
// /var/www/html/LM/lolly-m/7-Din-Mohabbat-In-Lolly2018/7-Din-Mohabbat-In-2018.mp4
//$filePath = '/var/www/html/LM/lolly-m/7-Din-Mohabbat-In-Lolly2018/7-Din-Mohabbat-In-2018.mp4';
   //
    $linkPart = explode('/',$filePath);
    $cnd = get_cdn($linkPart[4]);
    $filePath = '/var/www/html/mapdrive/'.$cnd.'/'.@$linkPart[4].'/'.@$linkPart[5].'/'.@$linkPart[6].'/'.@$linkPart[7].'/'.@$linkPart[8].'/'.@$linkPart[9].'/'.@$linkPart[10];
    $filePath = rtrim($filePath,'/');
//
    $seed = 'http://cdn-d-'.$group[$linkPart[4]].'.fundady.com/'.@$linkPart[4].'/'.@$linkPart[5].'/'.@$linkPart[6].'/'.@$linkPart[7].'/'.@$linkPart[8].'/'.@$linkPart[9].'/'.@$linkPart[10];
    $seed = rtrim($seed,'/');
 //
    $fileName = $linkPart[count($linkPart)-1];
   //
   ////////////////////////////////////// CREATE TORRENT ///////////////////////////////////////////////
   // // create torrent
    $torrent = new Torrent($filePath);
// 
$torrent->announce(array('http://fundady.com:6969/announce')); // set tracker(s), it also works with a 'one tracker' array...
//$torrent->announce(array(array('http://www.fundady.com:6969/announce','https://www.fundady.com:6969/announce')); // set tiered trackers
$torrent->comment('Fundady.com');
$torrent->name($fileName);
$torrent->is_private(true);
$torrent->httpseeds($seed); // Bittornado implementation

$torrent->url_list(array($seed)); // GetRight implementation

$torrent->save('/var/www/html/fdp/public/torrent/'.$fileName.'.torrent'); // save to disk
// $torrent->magnet(true); // use $torrent->magnet( false ); to get non html encoded ampersand
// print errors
if ( $errors = $torrent->errors() )
   var_dump( $errors );
// send to user
// $torrent->send();
//
}
}
fclose($file);
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
function get_cdn($group){

    $cdn = null;
        $key1 = array('GM','BM','LM','ANI','DM','ITVS','PM','ANITVS','PTVS','SPORTS'); //for CDN1 & CDN2
        $key2 = array('HM','3D','SBM','ETVS'); //for CDN3 & CDN4
        //
        if(in_array($group,$key1)){
            $cdn= 'cdn-s1';
        }else if(in_array($group,$key2)){
            $cdn = 'cdn-s3';
        }
        return $cdn;

    }

    ?>

