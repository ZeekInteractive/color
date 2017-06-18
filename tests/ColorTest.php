<?php

declare(strict_types=1);

use Liquidpineapple\Color;
use PHPUnit\Framework\TestCase;

final class ColorTest extends TestCase
{
    public function testColorConversionFromHexadecimal()
    {
        $hsl = Color::fromHEX('#1E90FF')->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $hslString = Color::fromHEX('1E90FF')->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHEX('#12');
    }

    public function testColorConversionFromRgb()
    {
        $hsl = Color::fromRGB(30, 144, 255)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromRGB(-10, 300, 100);
    }

    public function testColorConversionFromHsl()
    {
        $hsl = Color::fromHSL(210, 100, 56)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHSL(-10, 300, 100);
    }

    public function testColorConversionFromHsv()
    {
        $hsl = Color::fromHSV(210, 88, 100.0)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHSV(-10, 300, 100);
    }

    public function testColorConversionToRgb()
    {
        $rgb = Color::fromRGB(123, 123, 123)->toRGB();
        $this->assertEquals([123, 123, 123], $rgb);

        $rgbString = Color::fromRGB(123, 123, 123)->toRGBString();
        $this->assertEquals('rgb(123, 123, 123)', $rgbString);
    }

    public function testColorConversionToHex()
    {
        $hex = Color::fromHEX('#1E90FF')->toHEX();
        $this->assertEquals('#1E90FF', $hex);

        $hexString = Color::fromHEX('#1E90FF')->toHEXString();
        $this->assertEquals('#1E90FF', $hexString);
    }

    public function testColorConversionToHsl()
    {
        $hsl = Color::fromHSL(200, 80, 40)->toHSL();
        $this->assertEquals([200, 80, 40], $hsl);

        $hslString = Color::fromHSL(200, 80, 40)->toHSLString();
        $this->assertEquals('hsl(200, 80, 40)', $hslString);
    }

    public function testColorConversionToHsv()
    {
        $hsv = Color::fromHSV(200, 80, 40)->toHSV();
        $this->assertEquals([200, 80, 40], $hsv);

        $hsvString = Color::fromHSV(200, 80, 40)->toHSVString();
        $this->assertEquals('hsv(200, 80, 40)', $hsvString);
    }

    public function testColorAlterationDarken()
    {
        $darkColor = Color::fromHEX('#1E90FF')->darken(10)->toHEX();
        $this->assertEquals('#0182FF', $darkColor);
    }

    public function testColorAlterationLighten()
    {
        $lightColor = Color::fromHEX('#1E90FF')->lighten(10)->toHEX();
        $this->assertEquals('#359BFF', $lightColor);
    }

    public function testColorAlterationSaturate()
    {
        $exitingColor = Color::fromHEX('#1E90FF')->saturate(10)->toHEX();
        $this->assertEquals('#1E90FF', $exitingColor);
    }

    public function testColorAlterationDesaturate()
    {
        $dullColor = Color::fromHEX('#1E90FF')->desaturate(10)->toHEX();
        $this->assertEquals('#2990F4', $dullColor);
    }
}
