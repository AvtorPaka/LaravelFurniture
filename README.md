# Laravel Furniture

**Furniture shop with session based authentication**

## Deployment guidance

### 0. Prerequisites

**Docker and docker-compose installed on the system.**

### 1. Download sources

```sh
git clone git@github.com:AvtorPaka/LaravelFurniture.git
```

### 2. Deploy

```shell
cd LaravelFurniture/laravelapp && touch .env && cp .env.template .env 
```

```shell
cd ../docker-compose/ && touch .env && cp .env.template .env &&
docker compose -f docker-compose.yml up -d 
```

```shell
docker-compose exec workspace php artisan migrate &&
docker-compose exec workspace php artisan db:seed
```

### General user with admin claims

**Login Credentials :**
- **Email**: admn@gmail.com
- **Password**: 12345