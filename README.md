# Url Shortener
A simple local url shortener made with PHP and PostgresSQL.

## Why?
Just out of boredom and to learn a bit more about PHP.

## Pre-requisites
- Docker
- IDE / Text editor

## Installation
1. Clone the repository
2. Navigate to the project folder
3. Create a docker network with the following command:
```
docker network create --driver=bridge --subnet=172.27.0.0/16 url-shortener-network
```
4. Create a `.env` file with the following content:
```
POSTGRES_HOST=172.27.0.2
POSTGRES_USER=postgres
POSTGRES_PASSWORD=postgres
POSTGRES_DB=postgres
```
5. Run `docker compose up build`
6. Run `docker exec -it php bash`
7. Run `composer install`

## Usage
1. Open your browser and navigate to `localhost:8080`
2. Enter the url you want to shorten
3. Click on the shorten button
4. Copy the shortened url
5. Paste the shortened url in your browser to be redirected to the original url
6. Done!
