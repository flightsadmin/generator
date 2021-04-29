# Generator
**Generator** are several command line interface tools for CodeIgniter 4 that allows you to quickly create a repetitive code in record time. The exit code is so clean that it allows modification without problems...

During installation the generator will publish AdminLTE assets to ```public``` folder and run ```npm install```.
You need to run ```npm run dev``` once generator completes installation.

## Functionalities / Roadmap

 - [x] Create Complete CRUD of a database table
 - [x] Create Login, Register system
 - [x] Create AdminLTE Dashboard
 - [x] Create Panel Admin

## Installation
 1-  You can install this library using [Composer](https://getcomposer.com) with below command.
 
  ```bash 
  composer require flightsadmin/generator
  ```

## Start using it  
Everything is ready to start generating repetitive code with Generator  

### Commands

 Commands       |      Functionality      |  Parameters |
|------------------|:-------------:|:------:|
| ```php spark generator:instal``` |  Install Crud generator | Publishes AdminLTE files  |
| ```php spark make:crud``` |  Create CRUD from table   | Table name  |


**Default namespace used:  `App`**

