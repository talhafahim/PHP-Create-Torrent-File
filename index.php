<?php
require_once 'Torrent.php';
$dLink = 'http://cdn-d-ge.fundady.com/BM/bolly-2021/Thalaivi-Bolly2021/Thalaivi-2021.mp4';


//
//////////////////////////////   DOWNLOAD LINK   //////////////////////////////
//http://cdn-ge.fundady.com/BM/bolly-2021/Thalaivi-Bolly2021/Thalaivi-2021.mp4
//////////////////////////////   DOWNLOAD DIRECTORY STRUCTURE   //////////////////////////////
 // http://cdn-ge.fundady.com/   BM/bolly-2021/Thalaivi-Bolly2021/Thalaivi-2021.mp4
// /mnt/cdn-s1/H-STORAGE-4/      BM/bolly-2021/Thalaivi-Bolly2021/Thalaivi-2021.mp4


$storage = array('BM' => 'H-STORAGE-4', 'GM' => 'H-STORAGE-2' ,'3D' => 'H-STORAGE-1' , 'PM' => 'H-STORAGE-5','HM' => 'H-STORAGE-1');
//
$breakLink = explode('fundady.com',$dLink);
$linkPart = explode('/',$breakLink[1]);
//
$cdn = get_cdn($linkPart[1]);
$H = $storage[$linkPart[1]];
//
$path = '/mnt/'.$cdn['cdn'].'/'.$H.'/'.$cdn['dir'].'/'.$linkPart[2].'/'.$linkPart[3].'/'.$linkPart[4];
$dumpPath = '/mnt/'.$cdn['cdn'].'/'.$H.'/'.$cdn['dir'].'/'.$linkPart[2].'/'.$linkPart[3].'/';
// /mnt/cdn-s1/H-STORAGE-4/bolly-m/bolly-2021/Thalaivi-Bolly2021/Thalaivi-2021.mp4

// // create torrent
$torrent = new Torrent($path);
// /mnt/cdn-s3/H-STORAGE-1/holly-m/holly-2001/The-Patriot-2001/The-Patriot-2001.mp4
$torrent->announce(array('http://beta.fundady.com:6969/announce')); // set tracker(s), it also works with a 'one tracker' array...
// $torrent->announce(array(array('http://fundady.com/tracker/announce', 'http://fundady.com/tracker/announce'), 'http://fundady.com/tracker/announce')); // set tiered trackers
$torrent->comment('Fundady.com');
$torrent->name($linkPart[4]);
$torrent->is_private(true);
$torrent->httpseeds($dLink); // Bittornado implementation

$torrent->url_list(array($dLink)); // GetRight implementation

$torrent->save('/var/www/html/'.$linkPart[4].'.torrent'); // save to disk
// $torrent->magnet(true); // use $torrent->magnet( false ); to get non html encoded ampersand
// print errors
if ( $errors = $torrent->errors() )
	var_dump( $errors );

// send to user
// $torrent->send();








function get_cdn($group){
	$data = array();
	$key1 = array('GM' => 'GM','BM' => 'bolly-m','PM' => 'lolly-m'); //for CDN1 & CDN2
	$key2 = array('HM' => 'holly-m','3D' => '3D','SBM' => 'SBM'); //for CDN3 & CDN4
	//
	if(array_key_exists($group,$key1)){
		$data['cdn'] = 'cdn-s1';
		$data['dir'] = $key1[$group];
	}else if(array_key_exists($group,$key2)){
		$data['cdn'] = 'cdn-s3';
		$data['dir'] = $key2[$group];
	}
	return $data;
}

?>