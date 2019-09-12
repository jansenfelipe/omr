# Optical Mark Recognition from PHP

[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/omr/v/stable.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/omr/downloads.svg)](https://packagist.org/packages/jansenfelipe/omr) 
[![Latest Unstable Version](https://poser.pugx.org/jansenfelipe/omr/v/unstable.svg)](https://packagist.org/packages/jansenfelipe/omr)
[![MIT license](https://poser.pugx.org/jansenfelipe/omr/license.svg)](http://opensource.org/licenses/MIT)

This is an open source library written in PHP for recognition markings on questionnaires scans

See: [https://en.wikipedia.org/wiki/Optical_mark_recognition](https://en.wikipedia.org/wiki/Optical_mark_recognition)

<img src="https://github.com/jansenfelipe/omr/blob/develop/example/screenshots/exec-command.png?raw=true" />

# How to use

1) Add library:

```sh
$ composer require jansenfelipe/omr
```

2) Setup your `Map` and `Scanner` with the json file path containing the target coordinates and the image path _(See `/example` directory)_

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

3) Getting result

```php
$result = $scanner->scan($map);
```

#### Scanners

This library needs PHP ImageMagick extension to make images of reading

[http://php.net/manual/en/imagick.setup.php](http://php.net/manual/en/imagick.setup.php)

# License

The MIT License (MIT)
