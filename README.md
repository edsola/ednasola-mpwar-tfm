![TicketsApp](https://github.com/edsola/ednasola-mpwar-tfm/blob/main/app/symfony/public/assets/tickets-app.png)


# TicketsApp
*(Si es fa servir Windows es recomana utilitzar una consola com git bash)*
## Iniciar projecte

#### Iniciar contenidors
`make start`

#### Entrar al contenidor i al directori
```
docker exec -it service-php-pfm bash
cd app/symfony
```

#### Instal·lar Composer
`composer install`


#### Migracions
`php bin/console doctrine:migrations:migrate`


#### URL Login
http://localhost:1000/login


#### Dades d'accés administrador
Email: admin@admin.com

Pass: admin12345



## Tests

### Tests unitaris
(dins el contenidor i al directori app/symfony)
`./vendor/bin/phpunit`

### Tests End to End
(fora del contenidor i al directori app/symfony)
`npm run cypress:open`

A la finestra de Cypress triar **E2E Testing**
