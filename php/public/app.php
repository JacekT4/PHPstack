<?php
	require_once('aplikacja.php');
	require_once('controler.php');
	require_once('model.php');
	
	$aplikacja = new Aplikacja();
	$aplikacja->start();