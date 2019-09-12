# Optical Mark Recognition from PHP

[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/omr/v/stable.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/omr/downloads.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Latest Unstable Version](https://poser.pugx.org/jansenfelipe/omr/v/unstable.svg)](https://packagist.org/packages/jansenfelipe/omr)
[![MIT license](https://poser.pugx.org/jansenfelipe/omr/license.svg)](http://opensource.org/licenses/MIT)

This is an open source library written in PHP for recognition markings on questionnaires scans

See: [https://en.wikipedia.org/wiki/Optical_mark_recognition](https://en.wikipedia.org/wiki/Optical_mark_recognition)

<img src="https://github.com/jansenfelipe/omr/blob/develop/example/screenshots/exec-command.png?raw=true" />

# How to use

Add library:

```sh
$ composer require jansenfelipe/omr
```

Setup your `Map` and `Scanner` with the json file path containing the target coordinates and the image path.

_(See `/example` directory)_

```php
/*
 * Setup scanner
 */
$scanner = new ImagickScanner();
$scanner->setImagePath($imagePath);

/*
 * Setup map
 */
$map = MapJson::create($mapJsonPath);
```

Getting result

```php
$result = $scanner->scan($map);
```

# Scanners

This library currently has only one scanner using `Imagemagick 6`. It has been tested using the following configurations:

* PHP 7.0
* Extension imagick-3.4.2 
* imagemagick6

# License

The MIT License (MIT)
