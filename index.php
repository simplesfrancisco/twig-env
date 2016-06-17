<?php
	// Autoload of composer only for Twig.
	require_once 'vendor/autoload.php';

	// Start and config TWIG
	$loader = new Twig_Loader_Filesystem(__DIR__.'/views'); // Set views folder
	$twig = new Twig_Environment($loader, array('cache' => false)); // Disable cache
  $twigHome = "index"; // Set homepage

  // Load simple "system"
  require(__DIR__.'/vendor/_routes.php'); // Routes
	require(__DIR__.'/vendor/_config.php'); // Main config
	require(__DIR__.'/vendor/_modules.php'); // Modules loader
	require(__DIR__.'/vendor/_functions.php'); // Functions start

  // Get and config routes (vendor/routes.php)
	$appRoute = $_SERVER['REQUEST_URI'];
	$appRoute = str_replace("/", "", $appRoute);
	
	// Get geral data, and data based on router
	$appDataTemp = '_data_'.$appRoute.'.php';
	if(file_exists($appDataTemp)){
		$appDataA = include('_data_'.$appRoute.'.php');
		$appDataB = include(__DIR__.'/_data.php');
		$appData = array_merge($appDataA, $appDataB);
	} else {
		$appData = include(__DIR__.'/_data.php');
	}

	// Render a view based on route
	if($appRoute == ""){
		echo $twig->render($twigHome.'.twig', $appData);
	} else {
		try {
			echo $twig->render($appRoute.'.twig', $appData); 
		} catch (Exception $e) {
			echo $twig->render($twigHome.'.twig', $appData);
		}
	}