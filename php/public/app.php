<?php
	require_once('aplikacja.php');
	require_once('controler.php');
	require_once('model.php');
	
	$aplikacja = new Aplikacja();    //new słowo kluczowe do tworzenia obiektu i konstuktora | z argumentem
	$aplikacja->start();                      // -> wywołanie funkcji na obiekcie (metody)