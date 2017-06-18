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

        $rgb = Color::fromRGB(200, 123, 123)->toRGB();
        $this->assertEquals([200, 123, 123], $rgb);

        $rgb = Color::fromRGB(0, 255, 43)->toRGB();
        $this->assertEquals([0, 255, 43], $rgb);

        $rgb = Color::fromRGB(85, 255, 0)->toRGB();
        $this->assertEquals([85, 255, 0], $rgb);

        $rgbString = Color::fromRGB(123, 123, 123)->toRGBString();
        $this->assertEquals('rgb(123, 123, 123)', $rgbString);
    }

    public function testColorConversionToHex()
    {
        $hex = Color::fromHEX('#1E90FF')->toHEX();
        $this->assertEquals('#1E90FF', $hex);

        $hex = Color::fromHEX('#C44')->toHEX();
        $this->assertEquals('#CC4444', $hex);

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

        $hsv = Color::fromHSV(250, 80, 40)->toHSV();
        $this->assertEquals([250, 80, 40], $hsv);

        $hsv = Color::fromHSV(310, 80, 40)->toHSV();
        $this->assertEquals([310, 80, 40], $hsv);

        $hsv = Color::fromHSV(0, 0, 0)->toHSV();
        $this->assertEquals([0, 0, 0], $hsv);

        $hsv = Color::fromHSV(26, 68, 68)->toHSV();
        $this->assertEquals([26, 68, 68], $hsv);

        $hsvString = Color::fromHSV(200, 80, 40)->toHSVString();
        $this->assertEquals('hsv(200, 80, 40)', $hsvString);
    }

    public function testColorAlterationDarken()
    {
        $darkColor = Color::fromHEX('#1E90FF')->darken(10)->toHEX();
        $this->assertEquals('#0182FF', $darkColor);

        $this->expectException(InvalidArgumentException::class);
        $darkColor = Color::fromHEX('#1E90FF')->darken(110)->toHEX();
    }

    public function testColorAlterationLighten()
    {
        $lightColor = Color::fromHEX('#1E90FF')->lighten(10)->toHEX();
        $this->assertEquals('#359BFF', $lightColor);

        $this->expectException(InvalidArgumentException::class);
        $lightColor = Color::fromHEX('#1E90FF')->lighten(110)->toHEX();
    }

    public function testColorAlterationSaturate()
    {
        $exitingColor = Color::fromHEX('#1E90FF')->saturate(10)->toHEX();
        $this->assertEquals('#1E90FF', $exitingColor);

        $this->expectException(InvalidArgumentException::class);
        $exitingColor = Color::fromHEX('#1E90FF')->saturate(110)->toHEX();
    }

    public function testColorAlterationDesaturate()
    {
        $dullColor = Color::fromHEX('#1E90FF')->desaturate(10)->toHEX();
        $this->assertEquals('#2990F4', $dullColor);

        $this->expectException(InvalidArgumentException::class);
        $dullColor = Color::fromHEX('#1E90FF')->desaturate(110)->toHEX();
    }
}
