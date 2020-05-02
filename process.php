<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (isset($_POST["filename"]))
{
    $curpath = getcwd();
    $file_name = $curpath ."/src/" . $_POST["filename"];
    $cut_from = $_POST["curfrom"];
    $cut_from = $cut_from - 5;
    $duration = "10";
    if($cut_from < 0) 
    {
    	$cut_from = "0.0";
    	$duration = "5";
    }
    $osname = getServerOs();
    $targetid = $_POST["targetid"];
    $target = $curpath . "/video/" . $targetid. "_" .$cut_from. ".mp4";
    $pos = strpos($osname,"Windows");
    if($pos >= 0)
    {
    	$command = "ffmpeg -y -i " . $file_name . " -ss " . $cut_from . " -t " . $duration . " $target";
      echo $command;
    } else
    {
    	$command = "/usr/local/bin/ffmpeg -y -i " . $file_name . " -ss " . $cut_from . " -t " . $duration . " $target";
    }
    exec($command);
    //sleep(0.5);
    echo $targetid. "_" .$cut_from. ".mp4";
}

function getServerOs()
{
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    	return 'Windows';
	} else {
    	return 'Linux';
	}
}


function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

?>