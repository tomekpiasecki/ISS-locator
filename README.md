# ISS (International Space Station) locator

Simple site that displays current location of the ISS

## Requirements and Installation

- requires PHP 7.0 or higher.

#### Installation

- clone repository from github
- run `composer install` (more on composer [Composer](http://getcomposer.org))
- go to app/etc and copy `config.ini.dist` to `config.ini`
- enter your google maps api key (more on how to [get one](https://developers.google.com/maps/documentation/geocoding/get-api-key)) in `config.ini` and save the file
- run `php -S localhost:8000 -t pub/` inside main project directory

The web application is running at http://localhost:8000. 
