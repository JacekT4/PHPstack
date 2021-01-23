# PHPstack

Zainstaluj docker
```
https://www.docker.com/get-started - dla windowsa
https://docs.docker.com/engine/install/ubuntu/ - dla ubuntu
```

Zainstaluj
```
https://docs.docker.com/compose/install/ - windows i linux
```

Wejdz do glownego katalogu projektu (tam gdzie plik docker-compose.yml) i uruchom docker compose
```
docker compose up
```
wejdz do kontenera bazy danych i wykonaj sql z pliku `./mysql/start.sql`
```
docker ps - zeby znalezc id_kontenera_mysql
docker exec -it id_kontenera_mysql mysql -uroot -pmypass
```

Wyswietl strone w przegladarce
```
localhost:80
```

KONIEC
