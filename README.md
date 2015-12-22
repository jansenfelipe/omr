# Optical Mark Recognition from PHP

This is an open source library written in PHP for recognition markings on questionnaires scans

See: [https://en.wikipedia.org/wiki/Optical_mark_recognition](https://en.wikipedia.org/wiki/Optical_mark_recognition)

# How to use

Add library:

```sh
$ composer require jansenfelipe/omr
```

#### Scanners

This library needs PHP ImageMagick extension to make images of reading

[http://php.net/manual/en/imagick.setup.php](http://php.net/manual/en/imagick.setup.php)

#### Console

Run the following command through the image and mapping:

```sh
$ php vendor/bin/omr scan <imageJPG> <mapJSON>
```

Example:

```sh
$ php vendor/bin/omr scan questionarie.jpg map.json
```

# Map JSON

The map is a JSON file with image information and the positions (targets) to be recognized.

Example:

```json
{
  "dpi": 300,
  "width": 2480,
  "height": 3508,
  "limits": {
    "topRight": {
      "x": 2345,
      "y": 140
    },
    "bottomLeft": {
      "x": 115,
      "y": 3338
    }
  },
  "targets": [
    {
      "y1": 430,
      "y2": 470,
      "x1": 770,
      "x2": 810,
      "id": "a1",
      "type": "rectangle"
    },
    {
      "y1": 430,
      "y2": 470,
      "x1": 860,
      "x2": 900,
      "id": "a2",
      "type": "rectangle"
    }
  }
}
```

# License

The MIT License (MIT)