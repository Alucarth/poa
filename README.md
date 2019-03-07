# Poa 

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

### Tecnologia  
[![N|Solid](https://laravel.com/assets/img/components/logo-laravel.svg)](https://laravel.com)
[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)
<a href="https://vuejs.org" target="_blank" rel="noopener noreferrer"><img width="80" src="https://vuejs.org/images/logo.png" alt="Vue logo"></a>
### Instalacion

configure la base de datos en el archivo .env

```sh
$ cp .env.example .env  
```
ejecutar los comandos en el siguiente orden

```sh
$ composer install    
$ php artisan key:generate   
$ php artisan storage:link  
$ php artisan migrate --seed
$ npm install 
```
para colocar el proyecto en produccion
```sh
$ npm run prod
```
para colocar el proyecto en modo desarrollo 
```sh
$ npm run dev
```
###### Opcionalmente puede utilizar yarn
