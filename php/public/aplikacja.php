<?php
	class Aplikacja{
		private $sciezka;
		private $get;
		private $post;
		private $model;
		private $controler;
		public function __construct(){            //tworzymy konstruktor tylko jeden dla klasy w php
			$get = $_GET;       //zmienne które dostajesz w pasku url, zawsze widoczne w url, do pobierania
			$post = $_POST;     //zmienne które dostajesz w formularzach, nie są widoczne w adresie url, 
			$server = $_SERVER;   //zawiera zmienne które zostały zadeklarowane przez przeglądarkę oraz twój webserwer (u nas nginx)
			$sciezka = $server["REQUEST_URI"];      //klucz tablicy - to co mamy w adrsie url po domenie (php sobie tak wymyslił a nginx mu dał)
											  //wszystko co klasa bedzie robic podajemy w konstruktorze żeby nie było zmiennych globalnych
			if (strpos($sciezka, "?") !== false){
				$sciezka = substr( $sciezka , 0 ,  strpos($sciezka, "?") );
			}
			
			$this->sciezka = $sciezka;                                       //zmienna kluczowa this odnosi sie do obiektu, dostepna tylko wtedy kiedy stworzysz obiekt
			$this->get = $get;                                                 //tworzymy parametry obiektu
			$this->post = $post;
			$this->model = new Model();
			$this->controler = new Controler($this->model);
		}
		public function start(){                   //kazda funkcja musi miec unikalne imie
			switch($this->sciezka){
				case "/":
				return $this->controler->stronaDomowa();    //jest return wiec nie trzeba break
				case "/kalendarz":
				return $this->controler->kalendarz();
			}
		}
	}
	//konstruktor używamy non stop a destruktor prawie wcale