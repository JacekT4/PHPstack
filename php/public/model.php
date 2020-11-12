<?php //do logiki
	class Model{
		 /* ZAINSPIROWAĆ SIĘ MODELEM Z CONTROLERA    -  dependency injection - WZORZEC PROJEKTOWY polegający na przekazywaniu zależnosci, zależności są podawnane a nie generowane czy tworzone przez klase */
		private $dbh;
		public function __construct($dbh){            //tworzymy konstruktor tylko jeden dla klasy w php
			$this->dbh = $dbh;                                       //zmienna kluczowa this odnosi sie do obiektu, dostepna tylko wetdy kiedy stworzysz obiekt
		}
		
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
/* WERSJA Z ZAPISYWANIEM DO BAZY JSON NA DYSKU
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
*/
//WERSJA Z ZAPISEM DO BAZY MYSQL
			try{
				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');   
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); 
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//				var_dump (get_class_methods($dbh)); 				exit;
				$stmt = $dbh->prepare("INSERT INTO tabela_druga (Id, Autor, Tytul) VALUES ( :Id, :Autor, :Tytul)" ); 
				$stmt->bindParam(':Id', time());     //ZMIENIC NA AUTO INCREMENTACJE
				$stmt->bindParam(':Autor', $formularz["Autor"]);
				$stmt->bindParam(':Tytul', $formularz["Tytul"]);
				$stmt->execute(); 
			} catch (\Throwable $e){ 
				throw $e;
				return $e->getMessage();
			}
			return true;
		}		
	
	
	
		public function odczytZBazy3(){
/* WERSJA Z ZAPISYWANIEM DO BAZY JSON NA DYSKU
				if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
				}
				if(!empty($e)){
					return $e;                     //zwracamy wszytko z bazy
				}else{
					return [ ];      //zwracamy pusta tablica
				}
*/
//WERSJA Z ZAPISEM DO BAZY MYSQL
			try{
				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass'); 
//				var_dump (get_class_methods($dbh));    //exit;					//użyteczna metoda
				$result = [];
				
				foreach($dbh->query('select * from tabela_druga', \PDO::FETCH_ASSOC) as $row) {
					$result[] = $row;
				}
			} catch (\Throwable $e){ 
				throw $e;
				throw new \Exception('Nie udało się połączyć z bazą!'); 
			}
			return $result;
		}
		
		
		
		public function usunZBazy($formularz){
			if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weź z bazy
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
/*WERSJA Z USUWANIEM Z BAZY JSON NA DYSKU
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
*/
//WERSJA Z USUWANIEM Z BAZY MYSQL
			try{
				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//				var_dump (get_class_methods($dbh));			//exit;				//użyteczna metoda 

				$dbh->exec("DELETE FROM tabela_druga WHERE ID=" . $formularz["usuwacz"] );
			} catch (\Throwable $e){ 
				return $e->getMessage();
			}
			return true;			
		}

		
		
		
		public function odczytBazaMysql($parametry){
			try{
				$result = [];
//UŻYĆ preper statmen i dodać parametry() jako argument funkcji i na podstawie parametru użyj orderby				
/*				foreach($this->dbh->query('select * from tabela_pierwsza', \PDO::FETCH_ASSOC) as $row) {     // ukosnik \ musi byc przed klasą gdybysmy byli w name spac
					$result[] = $row;
				}
*/
				if(isset($parametry["sortuj"]) && $parametry["sortuj"] == "Imie"){
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Imie" ); 
				} elseif(isset($parametry["sortuj"]) && $parametry["sortuj"] == "Miasto"){ 
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Miasto" ); 
				} else{
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza");					
				}
				
				if ($stmt->execute()) {
				  while ($row = $stmt->fetch()) {
					$result[] = $row;
				  }
				}
			} catch (\Throwable $e){     //    \Throwable -  obiekt który służy do łapania wszystkiego co nie spełnia bloku try, czyli wszystko co się zesra , \łapie nawet jak by było name space
//				var_dump($e->getMessage());
				return [];      //zwróci pustą tablicę, a throw wyżyuca i zawsze musi byc obiekt który jest exeptionem
			}
			return $result;
		}
		
		
		
		public function zapiszBazaMysql($formularz){
/*			var_dump("INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) VALUES ('" . 
							$formularz["Imie"] . "','" . $formularz["Nazwisko"] . "'," . $formularz["Wiek"] . ",'" . $formularz["Kod_Pocztowy"] . "','" . $formularz["Miasto"] . "')");
			exit;*/                      //pomocnicze
			try{
				//	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
/*				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');       //ma byc bez spacji
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);       //ta linijka JESZCE DOJDZIEMY DO CZEGO JEST
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);     //dzieki temu nie przymyka oczu na błędy tylko zawsze krzyczy że coś się  dzieje (rzuca EXEPTION)
*/
//				var_dump (get_class_methods($dbh));    //użyteczna metoda 
//				exit;
/*				$stmt = $dbh->prepare("INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) VALUES ( :Imie, :Nazwisko, :Wiek, :Kod_Pocztowy, :Miasto)" ); */
				$stmt = $this->dbh->prepare("INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) VALUES ( :Imie, :Nazwisko, :Wiek, :Kod_Pocztowy, :Miasto)" ); 
				$stmt->bindParam(':Imie', $formularz["Imie"]);
				$stmt->bindParam(':Nazwisko', $formularz["Nazwisko"]);
				$stmt->bindParam(':Wiek', $formularz["Wiek"]);
				$stmt->bindParam(':Kod_Pocztowy', $formularz["Kod_Pocztowy"]);
				$stmt->bindParam(':Miasto', $formularz["Miasto"]);
				$stmt->execute();   //poprostu wykona
		
//tą linijkę niżej zakomentowalismy ponieważ zmieniliśmy sposób zapisu tych danych żeby bronić się przed atakami za pomocą prepare jak powyżej
//					$formularz["Imie"] . "','" . $formularz["Nazwisko"] . "'," . $formularz["Wiek"] . ",'" . $formularz["Kod_Pocztowy"] . "','" . $formularz["Miasto"] . "')");
							
							//tutaj są ' ' w których jest złapane wieksze wyrażenie a pmiedzy jeszcze " ", a . łączą stringi w php, musimy tak zapisać żeby działało wyrażenie SQL
							//exec - powoduje że wykona to co mu powiesz
			} catch (\Throwable $e){     //    \Throwable -  obiekt który służy do łapania wszystkiego co nie spełnia bloku try, czyli wszystko co się zesra , \łapie nawet jak by było name space tak jak wykorzystuje się w C++, ale my w naszym małym projekcie nie stosujemy tego na ten moment choć będziemy
/*				throw $e;
				throw new \Exception('Nie udało się połączyć z bazą!');      //wyrzuć nowy exception - to co w nawiasie - ŻEBY nie pokazać użytkownika i hasła komuś nie powołanemu		*/
//				return $e->getMessage();
				return "NIE udało się zapisać do bazy";
			}
			return true;
		}		
		
		
		public function usunBazaMysql($formularz){
			try{
				//	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
/*				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');       //ma byc bez spacji
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);       //ta linijka JESZCE DOJDZIEMY DO CZEGO JEST
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);     //dzieki temu nie przymyka okczu na błędy tylko zawsze krzyczy że coś się  dzieje (rzuca EXEPTION)
*/
//				var_dump (get_class_methods($dbh));    //użyteczna metoda 
//				exit;
//				$dbh->exec("DELETE FROM tabela_pierwsza WHERE ID=" . $formularz["usuwacz"] );
				$stmt = $this->dbh->prepare("DELETE FROM tabela_pierwsza WHERE ID= :Id" );   //placeholder to z : - tak jakby zamiennik, wezmiemy i pozniej zamienimy przez bindParam ale tylko w momencie wykonania
				$stmt->bindParam(':Id', $formularz["usuwacz"]);
				$stmt->execute();    //i to musimy dodać zeby wogole to zrobił
							//tutaj są ' ' w których jest złapane wieksze wyrażenie a pmiedzy jeszcze " ", a . łączą stringi w php, musimy tak zapisać żeby działało wyrażenie SQL
							//exec - powoduje że wykona to co mu powiesz
			} catch (\Throwable $e){     //    \Throwable -  obiekt który służy do łapania wszystkiego co nie spełnia bloku try, czyli wszystko co się zesra , \łapie nawet jak by było name space tak jak wykorzystuje się w C++, ale my w naszym małym projekcie nie stosujemy tego na ten moment choć będziemy
/*				throw $e;
				throw new \Exception('Nie udało się połączyć z bazą!');      //wyrzuć nowy exception - to co w nawiasie - ŻEBY nie pokazać użytkownika i hasła komuś nie powołanemu		*/
				//zmieniliśmy sposób wyświetlania i dlatego juz bez tego throw, poprostu wyżucamy za pomocą funkci getMessage() jakieś błędy
				//return $e->getMessage();
				return "Nie udało się usunąc";
			}
			return true;			
		}
		
	}
	
	