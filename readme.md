<p align="center">
<a href="https://liquidpineapple.net"><img src="http://liquidpineapple.o.auroraobjects.eu/img/color.jpg" /></a>
</p>

<p align="center">
<a href="https://travis-ci.org/liquidpineapple/color"><img src="https://travis-ci.org/liquidpineapple/color.svg" alt="Build Status"></a>
<a href="https://styleci.io/repos/94641763"><img src="https://styleci.io/repos/94641763/shield?branch=master" alt="StyleCI"></a>
<a href="https://codeclimate.com/github/liquidpineapple/color/coverage"><img src="https://codeclimate.com/github/liquidpineapple/color/badges/coverage.svg" /></a>
</p>
<p align="center">
<a href="https://waffle.io/liquidpineapple/color?utm_source=badge"><img src="https://badge.waffle.io/liquidpineapple/color.png?label=ready&title=Ready" alt="Stories in Ready" /></a>
<a href="https://waffle.io/liquidpineapple/color?utm_source=badge"><img src="https://badge.waffle.io/liquidpineapple/color.png?label=In%20Progress&title=In%20Progress" alt="Stories in Progress" /></a>
<a href="https://waffle.io/liquidpineapple/color?utm_source=badge"><img src="https://badge.waffle.io/liquidpineapple/color.png?label=done&title=Done" alt="Stories in Done" /></a>
</p>
<p align="center">
A micro PHP package to convert and alter colors! 🔥
</p>

Contents of this document:

* [Installation](#installation)
* [Documentation](#documentation)
* [Contributing](#contributing)

# Installation

You can install this package through composer. To install the latest version in to your project use the following command:

```bash
composer require liquidpineapple/color
```

This package requires PHP 7.0 or higher.

# Documentation

Table of contents:

1. [**Conversion**](#1-conversion)

    b) [Output](#1a-output)

    a) [Types](#1b-types)


2. [**Alteration**](#2-alteration)

    a) [Lightness](#2a-lightness)

    b) [Saturation](#2b-saturation)


## 1. Conversion

You can use this package to convert colors to different notations. An example might be converting HEX to RGB:

```php
<?php

use Liquidpineapple\Color;

$rgbColor = Color::fromHEX('#1E90FF')->toRGB();
// [30, 144, 255]
```

### 1a. Output

In some cases you might want an output like `rgb(30, 144, 255)`. This can be done using the following method:

```php
<?php

use Liquidpineapple\Color;

$rgbColor = Color::fromHEX('#1E90FF')->toRGBString();
// rgb(30, 144, 255)
```

### 1b. Types

You can convert from the following types:

* **HEX:** `fromHEX($hex)`
* **RGB:** `fromHEX($red, $green, $blue)`
* **HSL:** `fromHSL($hue, $saturation, $lightness)`
* **HSV:** `fromHSV($hue, $saturation, $value)`

To the following types

* **HEX:** `toHEX()` & `toHEXString()` _(alias of `toHEX()`)_
* **RGB:** `toRGB()` & `toRGBString()`
* **HSL:** `toHSL()` & `toHSLString()`
* **HSV:** `toHSV()` & `toHSVString()`

## 2. Alteration

Sometimes just conversion isn't enough, in some cases you might want to darken or saturate a color. Luckily, this is a breeze with this package.

### 2a. Lightness

You can alter the lightness of the color using the following methods:

* `lighten($amount)`
* `darken($amount)`

The amount in both message is a percentage. An example:

```php
<?php

use Liquidpineapple\Color;

$primaryColor = '#1E90FF';

$secondaryColor = Color::fromHEX('#1E90FF')->darken(10)->toHEX();
// #2A8FF4

```

### 2b. Saturation

Just as with lightness you can alter the saturation of a given color. This can be done using the following methods:

* `saturate($amount)`
* `desaturate($amount)`

The amount in both message is a percentage. An example:

```php
<?php

use Liquidpineapple\Color;

$dullColor = '#C44';

$exitingColor = Color::fromHEX('#C44')->saturate(10)->toHEX();
// #D33C3C

```

# Contributing

Did we miss something, or do you have cool ideas? Feel free to contribute!

How to contribute:

1. Fork this repository.
2. Write code (with comments).
3. Write tests (100% coverage).
4. Create a pull-request.
5. Profit!
