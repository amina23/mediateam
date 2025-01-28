# MediaTeam


## Getting Started

1. Run `docker compose build --no-cache` to build fresh images
2. Run `docker compose up --pull always -d --wait` to start the project
3. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
4. RUN `bin/console doctrine:migrations:migrate --no-interaction` to create database
5. RUN `bin/console doctrine:fixtures:load` to add data fixture
6. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Api for authentication and get the token
* Api for add user
* Api for add item
* Api for update item
* Api for add sub-item
* Api for update sub-item
* Api for delete item
* Api for delete sub-item


## Technical Stack

- **Symfony**: 7.2
- **PHP**: 8.3
- **Architecture**: MVC
- **Database**: MySQL

