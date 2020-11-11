<?php
	class Aplikacja{
		private $sciezka;
		private $get;
		private $post;
		private $model;
		private $controler;
		public function __construct(){            //tworzymy konstruktor tylko jeden dla klasy w php
		//php zawsze stworzy te zmienne globalne w momencie wywolania przez webserwer ale złą praktyką jest dzialanie na globalnych wiec przypisujemy do lokalnych i na nich dzialamy
			$get = $_GET;       //zmienne które dostajesz w pasku url, zawsze widoczne w url, do pobierania
			$post = $_POST;     //zmienne które dostajesz w formularzach, nie są widoczne w adresie url, 
			$server = $_SERVER;   //zawiera zmienne które zostały zadeklarowane przez przeglądarkę oraz twój webserwer (u nas nginx)
			$sciezka = $server["REQUEST_URI"];      //klucz tablicy - to co mamy w adrsie url po domenie (php sobie tak wymyslił a nginx mu dał - pozwolił)
											  //wszystko co klasa bedzie robic podajemy w konstruktorze żeby nie było zmiennych globalnych
			if (strpos($sciezka, "?") !== false){
				$sciezka = substr( $sciezka , 0 ,  strpos($sciezka, "?") );     //strpos funkcja php która wskazuje ci coś w danym stringu
			}    //substr ucina od 0 do "?"
			
			$this->sciezka = $sciezka;                                       //zmienna kluczowa this odnosi sie do obiektu, dostepna tylko wtedy kiedy stworzysz obiekt
			$this->get = $get;                                                 //tworzymy parametry obiektu
			$this->post = $post;
			
			//dodać tu TEN Z ZADANIA DOMOWEGO bdh lub inną nazwa ALE CHODZI O TO ŻEBY BYŁO NAD MODELEM
			$this->model = new Model();
			$this->controler = new Controler($this->model);
		}
		
		//ROUTER taka profesjonalna nazwa funkcji poniżej
		public function start(){                   //kazda funkcja musi miec unikalne imie      
			switch($this->sciezka){
				case "/":
				return $this->controler->stronaDomowa();    //jest return wiec nie trzeba break
				case "/kalendarz":
				return $this->controler->kalendarz();
				case "/dzialanie":
				return $this->controler->dzialanie($this->get);				
				case "/obecnywynik":
				return $this->controler->obecnywynik();		
				case "/emaile":
				return $this->controler->emaile($this->post);			
				case "/ksiazki":
				return $this->controler->ksiazki($this->post);
				case "/baza":
				return $this->controler->baza($this->get, $this->post);
			}
		}
	}
	//konstruktor używamy non stop a destruktor prawie wcale