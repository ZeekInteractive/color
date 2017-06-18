<?php
declare(strict_types=1);

use Liquidpineapple\Color;
use PHPUnit\Framework\TestCase;

/**
 * @covers Color
 */
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

    public function testColorConversionFromRGB()
    {
        $hsl = Color::fromRGB(30, 144, 255)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromRGB(-10, 300, 100);
    }

    public function testColorConversionFromHSL()
    {
        $hsl = Color::fromHSL(210, 100, 56)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHSL(-10, 300, 100);
    }

    public function testColorConversionFromHSV()
    {
        $hsl = Color::fromHSV(210, 88, 100.0)->toHSL();
        $this->assertEquals([210, 100, 56], $hsl);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHSV(-10, 300, 100);
    }

}
