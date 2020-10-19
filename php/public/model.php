<?php //do logiki
	class Model{
	
		public function dajTabliceKalendarza(){
			// zmienne kalendarza
			$t = date('t'); // liczba dni w miesiącu
			$j = date('j'); // dzień miesiąca
			$f = date('F'); // nazwa miesiąca
			$m = date('m'); // obecny miesiąc
			$y = date('Y'); // rok YYYY
			$pierwszy = date('w', mktime(0, 0, 0, $m, 1, $y)); // nazwa pierwszego dnia w miesiącu
			$line = 7; // ile w linii
			$tablica = [];
			$licznik = 1;
			for($i = 1; $i <= $line; $i++)
			{
				if ($i < $pierwszy)
				{
					$tablica[] = ["wartosc" => null];                                      //dodać kolor do niedzieli i innych dni
				}else
				{
					$tablica[] = ["wartosc" => $licznik];			
					$licznik++;					
				}
			}
			for( ; $licznik <= $t; $licznik++)
			{
				$tablica[] = ["wartosc" => $licznik];							
			}
			$tablica = array_chunk( $tablica , $line );
			$ostatni = end($tablica);       //przesuń wskażnik tablicy na ostatni elemet tablicy 
			for($i = count($ostatni); $i < $line; $i++)
			{
				$ostatni[] = ["wartosc" => null];
			}
			$tablica[key($tablica)] = $ostatni;      //key bierze obecny klucz - na który obecnie wskazuje wskaznik tablicy
			reset($tablica);     //resetujemy pointer  arraya
			return $tablica;
		}
	}