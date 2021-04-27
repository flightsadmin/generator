# Generator
**Generator** are several command line interface tools for CodeIgniter 4 that allows you to quickly create a repetitive code in record time. The exit code is so clean that it allows modification without problems...

## Functionalities / Roadmap

 - [x] Create  Complete CRUD of a database table
 - [x] Create a Controller file
 - [x] Create a Model file
 - [x] Create a Migration file
 - [x] Create a Command file.
 - [ ] Create Panel Admin

## Installation
 1-  You can install this library using [Composer](https://getcomposer.com) with below command.
 
  ```bash 
  composer require flightsadmin/generator
  ```
 2- Or Add the following to the `require-dev` section of your project's *composer.json* file
 
  ```"flightsadmin/generator" :"dev-master"```
 
 2-```composer update```

## Start using it  
Everything is ready to start generating repetitive code with Generator  

### Commands

 Commands       |      Functionality      |  Parameters |
|------------------|:-------------:|:------:|
| ```php spark create:crud``` |  Create CRUD from table   | Table,Model name , Controller name  |
| ```php spark create:controller``` |    Create a  Controller file   |   Controller name |
| ```php spark create:model```| Create a  Model file|    Table , Model Name |
| ```php spark create:command```| Create a  Command file| Command Name, Group , Description |
| ```php spark create:migration```| Create a  Migration file| Migration Name |

**In all operations you need the Namespace parameter, if you leave it blank it is assumed that you are using `App`**

