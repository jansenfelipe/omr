# Optical Mark Recognition with PHP

[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/omr/v/stable.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/omr/downloads.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Latest Unstable Version](https://poser.pugx.org/jansenfelipe/omr/v/unstable.svg)](https://packagist.org/packages/jansenfelipe/omr)
[![MIT license](https://poser.pugx.org/jansenfelipe/omr/license.svg)](http://opensource.org/licenses/MIT)
[![Build Status](https://travis-ci.org/jansenfelipe/omr.svg?branch=master)](https://travis-ci.org/jansenfelipe/omr)

This is an open source library written in PHP for recognition markings on questionnaires scans

See: [https://en.wikipedia.org/wiki/Optical_mark_recognition](https://en.wikipedia.org/wiki/Optical_mark_recognition)

<img src="https://github.com/jansenfelipe/omr/blob/develop/example/screenshots/exec_command.png?raw=true" />

# How to use

Add library:

```sh
$ composer require jansenfelipe/omr
```

Instantiate the <a href="#scanners">Scanner</a> class responsible for reading the image and enter its path

```php
/*
 * Setup scanner
 */
$scanner = new ImagickScanner();
$scanner->setImagePath($imagePath);
```

You will need to scan a blank form and create the <a href="#target-mapping-file">Target Mapping File</a> to be able to use the library.

After creating the `map.json` file, enter its path:

```php
/*
 * Setup map
 */
$map = MapJson::create($mapJsonPath);
```

Now you can scan and get the result

```php
$result = $scanner->scan($map);
```

# Scanners

This library currently has only one scanner class using `Imagemagick 6`. It has been tested using the following configurations:

* PHP 7.3
* imagemagick6
* Extension imagick-3.4.4 

See https://github.com/jansenfelipe/omr/blob/master/src/Scanners/ImagickScanner.php

# Target Mapping File

It is a .json file that describes, in addition to the image information, the coordinates of the places (targets) that the script must do the pixel analysis. This file follows the following pattern:

```json
{
    "width": 600,
    "height": 800,
    "targets": [
      {
        "x1": 50,
        "y1": 43,
        "x2": 65,
        "y2": 57,
        "id": "Foo",
        "type": "rectangle",
        "tolerance": 60
      }
    ] 
}
```

# Example

In the `example` directory there is an image of a completed questionnaire `response.png`. There is also a `map.json` file that gives the coordinates of the image areas that will be analyzed the pixels.

To help with setting up the environment, there is a Dockerfile in the project based on the official PHP 7.3 image that adds composer, imagemagick and the imagick extension to PHP.

That way you can install the dependencies and run the command to process the image without headaches :)

1) Clone this repo:

```ssh
$ git clone https://github.com/jansenfelipe/omr.git
$ cd omr/
```

2) Install dependencies:

```ssh
$ docker-compose run php composer install
```

2) Process example image:

```ssh
$ docker-compose run php bin/omr scan example/response.png example/map.json
```

# License

The MIT License (MIT)
