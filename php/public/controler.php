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
	}
	//konstruktor używamy non stop a destruktor prawie wcale