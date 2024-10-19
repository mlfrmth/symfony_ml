### Installation for development purpose
- RUN `cd symfony_ml` to enter to the project
- RUN `docker-compose up -d --wait` to start docker
- RUN `docker-compose exec php /bin/sh` to access app's bash
- RUN `composer install` install php depedencies
- RUN `npm install && npm run dev` build asset (it's make take few minutes)
- RUN `php bin/console doctrine:migrations:migrate` to migrate database
- GO http://localhost:9997/

### Don't forget create .env.local and fill APP_SECRET & MAILCHIMP_API_KEY

### Working with database
- RUN `php bin/console make:migration` to generate migrations from changes in entities
- RUN `php bin/console doctrine:migrations:migrate` to migrate database

### Generate assets
- RUN for development build `npm run dev`

### ADMINER
- Adminer: http://localhost:9998/
- default host: `db`
- default username: `not_root`
- default password: `pwd`

### Unit Tests
- RUN `php bin/phpunit`
