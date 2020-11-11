<?php
	class Controler{
		private $model;
		public function __construct($model){            //tworzymy konstruktor tylko jeden dla klasy w php
			$this->model = $model;                                       //zmienna kluczowa this odnosi sie do obiektu, dostepna tylko wetdy kiedy stworzysz obiekt
		}
		
		public function stronaDomowa(){
			echo "Strona domowa";
		}
		
		public function kalendarz(){
			$kalendarz = $this->model->dajTabliceKalendarza();
			$tytul = "Twoj ulubiony kalendarz";
			$naglowek = "Kalendarz";
			include("widok.php");
		}
		
		public function dzialanie($parametry){           //!empty - jezeli nie jest pusty
			if(isset($parametry["dodaj"]) && is_numeric($parametry["dodaj"])){
				echo "wynik: " . $this->model->dodaj($parametry["dodaj"]);
			} elseif(isset($parametry["odejmij"])){   //w php nie ma spacji
				echo "wynik: " .  $this->model->odejmij($parametry["odejmij"]);
			} elseif(isset($parametry["pomnoz"])){                                                        //isset funkcja która sprawdza czy dana zmienna istnieje niezależnie, czy jest zmienną czy kluczem tablicy
				echo "wynik: " .  $this->model->pomnoz($parametry["pomnoz"]);
			} elseif(!empty($parametry["podziel"])){
				echo "wynik: " .  $this->model->podziel($parametry["podziel"]);
			} else{
				echo "Zła komenda podana";
			}
		}
		
		public function obecnywynik(){
			echo "obecny wynik: " . $this->model->pobierzZBazy();
		}


		public function emaile($formularz){
			
			if(!empty($formularz)){
//				var_dump($formularz);     //ZAD dodać imię, nazwiko i email jako blok do bazy danych

				$efektZapisania = $this->model->zapiszDoBazy2($formularz);

			} 
			$lista = $this->model->odczytZBazy2();
			
				//ZAD zrobic zmienna lista ktora bedzie zawierala email, imie i nazwisko i wyrenderowac na podstawie tej zmiennej
			include("widoklisty.php");
		}
		
		
		public function ksiazki($formularz){
		
			if(!empty($formularz)){
				if(!empty($formularz["autor"]) && !empty($formularz["tytul"])){
					$efektZapisania2 = $this->model->zapiszDoBazy3($formularz);
				}elseif(!empty($formularz["usuwacz"])){      //elseif ŁĄCZNIE w php
//					$usuwacz = $this->model->usunZBazy($formularz);
					$usuwacz = $this->model->usunZBazy2($formularz);
				}
			}	 
			$lista2 = $this->model->odczytZBazy3();
				
			include("widok3.php");
		}
		
		
		
		public function baza($parametry, $formularz){    //bo do get i do post
			$wynik_zapisu = true;
			$wynik_usuwania = true;
/*			$formularz = [
			    "Imie"=> "Pawel",
				"Nazwisko"=>"Nowak",
				"Wiek"=>"28",
				"Kod_Pocztowy"=>"20-456",
				"Miasto"=>"Lublin"];							*/
/*			var_dump($parametry);
			exit;
*/
			if(!empty($formularz)){
				if(!empty($formularz["Imie"]) && !empty($formularz["Nazwisko"]) && !empty($formularz["Wiek"]) && !empty($formularz["Kod_Pocztowy"]) && !empty($formularz["Miasto"])){
					$wynik_zapisu = $this->model->zapiszBazaMysql($formularz);
				}elseif(!empty($formularz["usuwacz"])){ 
					$wynik_usuwania = $this->model->usunBazaMysql($formularz);
				}
			}
			$wyniki = $this->model->odczytBazaMysql();
/*			$wyniki2 = $this->model->odczytBazaDanych($parametry);    //DODAŁEM*/
			
/*			echo "<pre>";
			var_dump ($wyniki);
			exit;									*/
			
			include("widok4.php");		
		}
	
	}
	//konstruktor używamy non stop a destruktor prawie wcale
	
	
