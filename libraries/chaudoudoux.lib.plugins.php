<?php

/**
 * Register a plugins by path
 * This will help us to override components files easily.
 * 
 * @param string $path A valid path;
 * @return boolean
 */
function chaudoudoux_register_plugins_by_path($path) {
		global $Chaudoudoux;
		
		if(chaudoudoux_site_settings('cache') == 1) {
				return false;
		}
		if(!is_dir($path)) {
				//disable error log, will cause a huge log file
				//error_log("Ossn tried to register invalid plugins by path: {$path}");
				return false;
		}
		$path      = str_replace("\\", "/", $path);
		$directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator  = new RecursiveIteratorIterator($directory);
		if($iterator) {
				foreach($iterator as $file) {
						if(pathinfo($file, PATHINFO_EXTENSION) == "php") {
								$file     = str_replace("\\", "/", $file);
								$location = str_replace(dirname(__FILE__) . '/plugins/', '', $file);
								
								$name = str_replace($path, '', $location);
								$name = substr($name, 0, -4);
								$name = explode('/', $name);
								
								$plugin_type = $name[0];
								unset($name[0]);
								
								$name = implode('/', $name);
								
								$fpath = substr($file, 0, -4);
								$fpath = str_replace(array(
										$name,
										ossn_route()->www
								), '', $fpath);
								
								$Ossn->plugins[$plugin_type][$name] = $fpath;
						}
				}
		}
		return true;
}