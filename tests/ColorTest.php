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

        $hslString = Color::fromHEX('#1E90FF')->toHSLString();
        $this->assertEquals('hsl(210, 100, 56)', $hslString);

        $this->expectException(InvalidArgumentException::class);
        Color::fromHEX('#12');
    }
}
