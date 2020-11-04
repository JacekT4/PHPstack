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
			$tablica = array_chunk( $tablica , $line );                  //sieka tablice na elementy w zalezności od drugiego parametru
			$ostatni = end($tablica);       //przesuń wskażnik tablicy na ostatni elemet tablicy 
			for($i = count($ostatni); $i < $line; $i++)
			{
				$ostatni[] = ["wartosc" => null];
			}
			$tablica[key($tablica)] = $ostatni;      //key bierze obecny klucz - na który obecnie wskazuje wskaznik tablicy
			reset($tablica);     //resetujemy pointer  arraya
	//		echo "<pre>";     //var_dump jest bardziej czytelny dzieki temu echo
	//		var_dump($tablica);   //funkcja do zrzucania zmiennej  //czesto uzywa sie do sprawdzenia
			foreach ($tablica as $i => $wiersz){
				if ($tablica[$i][$line - 1]["wartosc"] !== null){	
					$tablica[$i][$line - 1]["color"] = "red";
				}
			}
	//		var_dump($tablica);
			return $tablica;
		}
		
		
		
		public function dodaj($liczba){
			$f = $liczba + $this->pobierzZBazy();         //nowy wynik          
			$this->zapiszDoBazy($f);     //zapisze do bazy kazdy wynik
			return $f;     //zwróci wynik do controler
		}
		public function odejmij($liczba){
			$f = $this->pobierzZBazy() - $liczba;         //nowy wynik          
			$this->zapiszDoBazy($f);     //zapisze do bazy kazdy wynik
			return $f;     //zwróci wynik do controler
		}
		public function pomnoz($liczba){
			$f = $liczba * $this->pobierzZBazy();         //nowy wynik          
			$this->zapiszDoBazy($f);     //zapisze do bazy kazdy wynik
			return $f;     //zwróci wynik do controler
		}
		public function podziel($liczba){
			$f = $this->pobierzZBazy() / $liczba;         //nowy wynik          
			$this->zapiszDoBazy($f);     //zapisze do bazy kazdy wynik
			return $f;     //zwróci wynik do controler
		}
		
/*		
		public function lista( $imie, $nazwisko, $email ){
			$f = $this->pobierzZBazy2() + $imie + $nazwisko + $email;
			$this->zapiszDoBazy2($f);
			return $f;
		}
*/	
		
		public function pobierzZBazy(){                    //ZAD pierwszy parametr ma mówic co chcesz pobrac z bazy i na podstawie tego parametru ma zwracać, zmienic plik na baza.json i która bedzie miała kolejny klucz oprocz wartosc np tablice tablice i kazdy elemnt bedzie mial naz imi i emial
			if(file_exists("wynik.json")){                     //sami wybralismy format json bo jest bardzo popularny 
				$e = file_get_contents("wynik.json");
				$e = json_decode($e, true);
				if(!empty($e["wartosc"])){
					return $e["wartosc"];
				}
			}
			return 0;
		}
		
/*		
		public function pobierzZBazy2(){                    //ZAD pierwszy parametr ma mówic co chcesz pobrac z bazy i na podstawie tego parametru ma zwracać, zmienic plik na baza.json i która bedzie miała kolejny klucz oprocz wartosc np tablice, tablice i kazdy elemnt bedzie mial naz imi i emial
			if(file_exists("baza.json")){                     //sami wybralismy format json bo jest bardzo popularny 
				$e = file_get_contents("baza.json");
				$e = json_decode($e, true);
				if(!empty($e["wartosc"])){
					return $e["wartosc"];
				}
			}
			return 0;
		}		
*/		
		
		private function zapiszDoBazy($liczba){    //ZAD dodac parametr ($co) i drugi ($co, $wartosc) i liczbe nadpisuje a liste dodaje mozna dodac trzeci parametr ($akcja) czyli co zrobic, zamien, dodaj, usun
			file_put_contents("wynik.json", json_encode(["wartosc" => $liczba]));      //zapisuje do pliku zwrocony przez json_encode string
		}
		
		
	
		public function zapiszDoBazy2($formularz){    //ZAD dodac parametr ($co) i drugi ($co, $wartosc) i liczbe nadpisuje a liste dodaje mozna dodac trzeci parametr ($akcja) czyli co zrobic, zamien, dodaj, usun
			if(file_exists("baza.json")){
				$lista = $this->odczytZBazy2();      //na obiekcie wiec this
				$lista[] = ["imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]]; 
				file_put_contents("baza.json", json_encode($lista));     //DO zapisania do bazy
     //zapisuje do pliku zwrocony przez json_encode string
			}else{
				file_put_contents("baza.json", json_encode(
					[["imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]]]       // [] to wystarcza zeby była już tablica, można by to zapisać array(array("imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]))
				));			
			}
			return true;
		}		
	
		public function odczytZBazy2(){
				if(file_exists("baza.json")){ 
					$e = file_get_contents("baza.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
				}
				if(!empty($e)){
					return $e;                     //zwracamy wszytko z bazy
				}else{
					return [ ];      //zwracamy pusta tablica
				}
		}


		public function zapiszDoBazy3($formularz){    //ZAD dodac parametr ($co) i drugi ($co, $wartosc) i liczbe nadpisuje a liste dodaje mozna dodac trzeci parametr ($akcja) czyli co zrobic, zamien, dodaj, usun
			if(file_exists("baza2.json")){
				$lista2 = $this->odczytZBazy3();      //na obiekcie wiec this
				$lista2[] = ["id" => time(), "autor" => $formularz["autor"], "tytul" => $formularz["tytul"]]; 
				file_put_contents("baza2.json", json_encode($lista2));     //DO zapisania do bazy
     //zapisuje do pliku zwrocony przez json_encode string
			}else{
				file_put_contents("baza2.json", json_encode(
					[["id" => time(), "autor" => $formularz["autor"], "tytul" => $formularz["tytul"]]]       // [] to wystarcza zeby była już tablica, można by to zapisać array(array("imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]))
				));			
			}
			return true;
		}		
	
		public function odczytZBazy3(){
				if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
				}
				if(!empty($e)){
					return $e;                     //zwracamy wszytko z bazy
				}else{
					return [ ];      //zwracamy pusta tablica
				}
		}
		
		public function usunZBazy($formularz){
			if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
//					echo "<pre>"; var_dump($e);
					foreach($e as $i => $wiersz)
					{
						if($wiersz["id"] == $formularz["usuwacz"]){     //== lub === porównanie a = przypisanie
//								var_dump($wiersz); var_dump($e[$i]);      exit;        //to samo
							unset($e[$i]);     //ale tutaj nie może być $wiersz bo była potrzebna tylko do porównania
						}
					}
//					var_dump($e);
//					exit;
					file_put_contents("baza2.json", json_encode($e));        //zapisujemy do bazy rozkodowaną tablicę
			}
		}
		
		public function usunZBazy2($formularz){
			if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
//					echo "<pre>"; var_dump($e);
					$nowaTablica = [];
					foreach($e as $i)
					{
						if($i["id"] != $formularz["usuwacz"]){
							$nowaTablica[] = $i;
						}
					}
//					var_dump($e);
//					exit;
					file_put_contents("baza2.json", json_encode($nowaTablica));        //zapisujemy do bazy rozkodowaną tablicę
			}
		}
		
	}
	