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
	BackgroundConfigMgrDeleteConfigfile($backgroundfile);
	BackgroundConfigMgrDeleteConfigfile($cssfile);
	$scanned_directory = array_diff(scandir($configdir), array('..', '.'));
	if(empty($scanned_directory)){
		rmdir($configdir);
	}
}
function BackgroundConfigMgrDeleteConfigfile($filename){
	$configdir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig';
	$keepfileindex = $configdir.DIRECTORY_SEPARATOR.'keepfiles.txt';
	$neverdelete = $configdir.DIRECTORY_SEPARATOR.'neverdelete.txt';
	if(is_file($configdir .DIRECTORY_SEPARATOR. basename($filename))){
		//File exists and is inside the config dir
	  if(!is_file($neverdelete)){
		  //never delete is not set
		if(is_file($keepfileindex)){
			//There is a keep file index
			$tokeep = file($keepfileindex, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
			if(!in_array($basename($filename),$tokeep)){
				//but the file to delete isn't in it
			   return unlink($filename);
			}else{
				//The file is in the keep file index, do not delete
				return false;
			}
		}else{
			//There is no keep file index, delete
			return unlink($filename);
		}
	  }else{
		  //Never delete is set, do not delete
		  return false;
	  }
	}else{
		//The file is invalid, do not delete (but can't delete anyway)
		return false;
	}
}


?>