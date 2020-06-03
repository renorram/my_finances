# My Finances

Simple PHP project to control my finances. **(Work in Progress)**

## Requirements

- PHP 7.4+ (PHP-FPM preferably)
- Composer
- PostgreSQL
- NGINX
- Docker (Optional)
- Docker Compose (Optional)


## Run

### Docker

Running with docker is the simpliest way, after install docker and docker compose just start up the project with the following commands:


```shell script
# clone the project
git clone git@github.com:renorram/my_finances.git

# enter the project folder
cd my_finances

# start up docker compose
docker-compose up -d
```


### Locally installed PHP-FPM and NGINX

**Docs To be Improved**

After clone the project, make sure you have PHP-FPM and NGINX installed and running. Inside `.docker/nginx` you can find a functioning host configuration for the website in the file `site.conf`, place under the configured sites of NGINX, restart it and try access the site at `http://localhost`
