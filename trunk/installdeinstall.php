<?php
function EvonaInitializeStep2(){
	$configdir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig';
	if(!is_dir($configdir)){
		mkdir($configdir, 0775);
	}
	$backgroundlocation = $configdir.DIRECTORY_SEPARATOR.'backgrounds.txt';
	$csslocation = $configdir.DIRECTORY_SEPARATOR.'evonabackground.css';
	if(!file_exists($csslocation)){
		$csshandle = fopen($csslocation,'a');
		fwrite($csshandle, '
		  img.evonabackground, div.evonabackground{
			z-index:-999;
			position:fixed;
			top:0;
			width:100%;
			min-height:100%;
			margin-left:0;
			margin-right:0;
			right:0;
			left:0;
		}');
		fclose($csshandle);
	}
	if(!file_exists($backgroundlocation)){
		$image_location = plugins_url('backgrounds'.DIRECTORY_SEPARATOR, __FILE__);
		$backgroundhandle = fopen($backgroundlocation,'a');
		fwrite($backgroundhandle, "<img src=\"".$image_location."dirty_wall.png\" class=\"evonabackground\" alt=\"background\" />\n<div class=\"evonabackground\" style=\"background:url('".$image_location."stuff.png') repeat;\"></div>\n");
		fclose($backgroundhandle);
	}
}
function EvonaUninstallStep2(){
	$configdir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig';
	$backgroundfile = $configdir.DIRECTORY_SEPARATOR.'backgrounds.txt';
	$cssfile = $configdir.DIRECTORY_SEPARATOR.'evonabackground.css';
	unlink($backgroundfile);
	unlink($cssfile);
	$scanned_directory = array_diff(scandir($configdir), array('..', '.'));
	if(empty($scanned_directory)){
		rmdir($configdir);
	}
}


?>