#! /bin/bash

#docker-compose down
docker compose down

docker stop aw_db aw_adminer aw_php-apache2
docker rm aw_db aw_adminer aw_php-apache2
docker rmi docker-compose-demo_web

docker rmi php:8.4-apache mysql adminer

docker rmi docker-compose-web

#docker image prune
