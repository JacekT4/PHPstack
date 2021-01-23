CREATE DATABASE pierwsza_baza;

USE pierwsza_baza;

CREATE TABLE tabela_pierwsza (
ID int AUTO_INCREMENT PRIMARY KEY,
Imie varchar(255),
Nazwisko varchar(255),
Wiek int,
Kod_Pocztowy varchar(255),
Miasto varchar(255)
);
INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) VALUES ('Pawel', 'Nowak', 28, '20-456', 'Lublin');

CREATE TABLE tabela_uzytkownikow (
ID int AUTO_INCREMENT PRIMARY KEY,
Email varchar(100) not null,
Haslo varchar(255) not null,
unique key (Email)
);
