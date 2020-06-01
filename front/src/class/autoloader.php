<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

spl_autoload_register(array('autoloader', 'autoload'));

/**
 * Class autoloader. 
 */
class ConfigAutoLoader {
	
	/** Maps classnames to files containing the class. */
	private static $classes = array(
	
		'Database' => 'src/class/database.php',
		'Category' => 'src/class/category.php',
		'Client' => 'src/class/client.php',
		'Forfait' => 'src/class/forfait.php',
		'Genre' => 'src/class/genre.php',
		'Location' => 'src/class/location.php',
		'Movie' => 'src/class/movie.php',
		'MovieStock' => 'src/class/moviestock.php',
		'RoleApp' => 'src/class/roleApp.php',
		'UserApp' => 'src/class/UserApp.php',
		'AbonneService' => 'src/services/abonneService.php',
		'MovieService' => 'src/services/movieService.php',
		'UserService' => 'src/services/userService.php',
	);
	
	/**
	 * Loads a class.
	 * @param string $className The name of the class to load.
	 */
	public static function autoload($className) {
		if(isset(self::$classes[$className])) {
			if (!include(__DIR_PARENT__. self::$classes[$className]))
                        {
                                die('Error.'. __DIR_PARENT__ . self::$classes[$className]);
                        }
		}
	}
}