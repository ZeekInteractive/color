<?php

namespace Liquidpineapple;

use InvalidArgumentException;

class Color
{
    /**
     * @var int (0-360), The H-value in HSL
     */
    private $hue;

    /**
     * @var int (0-100), The S-value in HSL
     */
    private $saturation;

    /**
     * @var int (0-100), The L-value in HSL
     */
    private $lightness;

    /**
     * Creates a Color instance.
     *
     * @param int|null $hue        (0-360) The hue of the color (format: HSL)
     * @param int|null $saturation (0-100) The saturation of the color (format: HSL)
     * @param int|null $lightness  (0-100) The lightness of the color (format: HSL)
     *
     * @return void
     */
    public function __construct($hue = 0, $saturation = 0, $lightness = 0)
    {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
    }

    /**
     * Creates a Color instance based on the given RGB-formatted color.
     *
     * @param int $red   (0-255) The red value of the given color
     * @param int $green (0-255) The green value of the given color
     * @param int $blue  (0-255) The blue value of the given color
     *
     * @return Color
     */
    public static function fromRGB($red, $green, $blue)
    {
        if ($red < 0 || $red > 255) {
            throw new InvalidArgumentException('Value $red can only be 0 to 255');
        }
        if ($green < 0 || $green > 255) {
            throw new InvalidArgumentException('Value $green can only be 0 to 255');
        }
        if ($blue < 0 || $blue > 255) {
            throw new InvalidArgumentException('Value $blue can only be 0 to 255');
        }
        $red /= 255;
        $green /= 255;
        $blue /= 255;
        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);
        $delta = $max - $min;
        $hue = 0;
        $saturation = 0;
        $lightness = ($max + $min) / 2;
        if ($delta == 0) {
            // Achromatic
            return new self($hue, $saturation * 100, $lightness * 100);
        } else {
            $saturation = $delta / (1 - abs(2 * $lightness - 1));
            $hue = ($max == $green) ? 60 * (($blue - $red) / $delta + 2) : $hue;
            $hue = ($max == $blue) ? 60 * (($red - $green) / $delta + 4) : $hue;
            if ($max == $red) {
                $x = ($blue > green) ? 360 : 0;
                $hue = 60 * fmod((($green - $blue) / $delta), 6) + $x;
            }

            return new self($hue, $saturation * 100, $lightness * 100);
        }
    }

    /**
     * Creates a Color instance based on the given Hexadecimal-formatted color.
     *
     * @param string $hex A hexadecimal color value, the # isn't required but can be given
     *
     * @return Color
     */
    public static function fromHEX($hex)
    {
        $hex = preg_replace('/[^0-9A-Fa-f]/', '', $hex);
        $rgb = [];
        if (strlen($hex) == 6) {
            $colorVal = hexdec($hex);
            $rgb['red'] = 0xFF & ($colorVal >> 0x10);
            $rgb['green'] = 0xFF & ($colorVal >> 0x8);
            $rgb['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hex) == 3) {
            $rgb['red'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $rgb['green'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $rgb['blue'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            throw new InvalidArgumentException('Given color does not adhere to hexadecimal format');
        }

        return self::fromRGB($rgb['red'], $rgb['green'], $rgb['blue']);
    }

    /**
     * Creates a Color instance based on the given HSV-formatted color.
     *
     * @param int $hue        (0-360) The hue of the color (format: HSV)
     * @param int $saturation (0-100) The saturation of the color (format: HSV)
     * @param int $value      (0-100) The value of the color (format: HSV)
     *
     * @return Color
     */
    public static function fromHSV($hue, $saturation, $value)
    {
        if ($hue < 0 || $hue > 360) {
            throw new InvalidArgumentException('Value $hue can only be 0 to 360');
        }
        if ($saturation < 0 || $saturation > 100) {
            throw new InvalidArgumentException('Value $saturation can only be 0 to 100');
        }
        if ($value < 0 || $value > 100) {
            throw new InvalidArgumentException('Value $value can only be 0 to 100');
        }
        $hue /= 360;
        $saturation /= 100;
        $value /= 100;

        $H = $hue * 6;
        $I = floor($H);
        $F = $H - $I;

        $M = $value * (1 - $saturation);
        $N = $value * (1 - $saturation * $F);
        $K = $value * (1 - $saturation * (1 - $F));

        switch ($I) {
            case 0: list($red, $green, $blue) = [$value, $K, $M]; break;
            case 1: list($red, $green, $blue) = [$N, $value, $M]; break;
            case 2: list($red, $green, $blue) = [$M, $value, $K]; break;
            case 3: list($red, $green, $blue) = [$M, $N, $value]; break;
            case 4: list($red, $green, $blue) = [$K, $M, $value]; break;
            case 5:
            case 6: list($red, $green, $blue) = [$value, $M, $N]; break;
        }

        $red *= 255;
        $green *= 255;
        $blue *= 255;

        return self::fromRGB($red, $green, $blue);
    }

    /**
     * Creates a Color instance based on the given HSL-formatted color.
     *
     * @param int $hue        (0-360) The hue of the color (format: HSL)
     * @param int $saturation (0-100) The saturation of the color (format: HSL)
     * @param int $lightness  (0-100) The lightness of the color (format: HSL)
     *
     * @return Color
     */
    public static function fromHSL($hue, $saturation, $lightness)
    {
        if ($hue < 0 || $hue > 360) {
            throw new InvalidArgumentException('Value $hue can only be 0 to 360');
        }
        if ($saturation < 0 || $saturation > 100) {
            throw new InvalidArgumentException('Value $saturation can only be 0 to 100');
        }
        if ($lightness < 0 || $lightness > 100) {
            throw new InvalidArgumentException('Value $lightness can only be 0 to 100');
        }

        return new self($hue, $saturation, $lightness);
    }

    /**
     * Alters the color by lightening it with the given percentage.
     *
     * @param int $amount (0-100) Percentage with which to lighten the color
     *
     * @return Color
     */
    public function lighten($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->lightness += (100 - $this->lightness) * $amount;

        return $this;
    }

    /**
     * Alters the color by darkening it with the given percentage.
     *
     * @param int $amount (0-100) Percentage with which to darken the color
     *
     * @return Color
     */
    public function darken($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->lightness -= $this->lightness * $amount;

        return $this;
    }

    /**
     * Alters the color by saturating it with the given percentage.
     *
     * @param int $amount (0-100) Percentage with which to saturate the color
     *
     * @return Color
     */
    public function saturate($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->saturation += (100 - $this->saturation) * $amount;

        return $this;
    }

    /**
     * Alters the color by desaturating it with the given percentage.
     *
     * @param int $amount (0-100) Percentage with which to desaturate the color
     *
     * @return Color
     */
    public function desaturate($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->saturation -= $this->saturation * $amount;

        return $this;
    }

    /**
     * Outputs the color using the HSL format.
     *
     * @return array HSL representation of the color
     */
    public function toHSL()
    {
        return [
            round($this->hue),
            round($this->saturation),
            round($this->lightness),
        ];
    }

    /**
     * Outputs the color using the HSL format.
     *
     * @return string HSL representation of the color using CSS format
     */
    public function toHSLString()
    {
        $hsl = $this->toHSL();

        return "hsl($hsl[0], $hsl[1], $hsl[2])";
    }

    /**
     * Outputs the color using the RGB format.
     *
     * @return array RGB representation of the color
     */
    public function toRGB()
    {
        $h = $this->hue;
        $s = $this->saturation / 100;
        $l = $this->lightness / 100;
        $r;
        $g;
        $b;
    	$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
    	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
    	$m = $l - ( $c / 2 );
    	if ( $h < 60 ) {
    		$r = $c;
    		$g = $x;
    		$b = 0;
    	} else if ( $h < 120 ) {
    		$r = $x;
    		$g = $c;
    		$b = 0;
    	} else if ( $h < 180 ) {
    		$r = 0;
    		$g = $c;
    		$b = $x;
    	} else if ( $h < 240 ) {
    		$r = 0;
    		$g = $x;
    		$b = $c;
    	} else if ( $h < 300 ) {
    		$r = $x;
    		$g = 0;
    		$b = $c;
    	} else {
    		$r = $c;
    		$g = 0;
    		$b = $x;
    	}
    	$r = ( $r + $m ) * 255;
    	$g = ( $g + $m ) * 255;
    	$b = ( $b + $m  ) * 255;

        return [
            round($r),
            round($g),
            round($b),
        ];
    }

    /**
     * Outputs the color using the RGB format.
     *
     * @return string RGB representation of the color using CSS format
     */
    public function toRGBString()
    {
        $rgb = $this->toRGB();

        return "rgb($rgb[0], $rgb[1], $rgb[2])";
    }

    /**
     * Outputs the color using the HEX format.
     *
     * @return array HEX representation of the color
     */
    public function toHEX()
    {
        $rgb = $this->toRGB();
        return strtoupper(sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]));
    }

    /**
     * Outputs the color using the HEX format.
     *
     * @return string HEX representation of the color using CSS format
     */
    public function toHEXString()
    {
        return $this->toHEX();
    }
}
