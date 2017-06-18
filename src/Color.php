<?php

namespace Liquidpineapple;

use InvalidArgumentException;

class Color
{
    private $hue;
    private $saturation;
    private $lightness;

    public function __construct($hue = 0, $saturation = 0, $lightness = 0)
    {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
    }

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

    public function lighten($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->lightness += (1 - $this->lightness) * $amount;

        return $this;
    }

    public function darken($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->lightness -= $this->lightness * $amount;

        return $this;
    }

    public function saturate($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->saturation += (1 - $this->saturation) * $amount;

        return $this;
    }

    public function desaturate($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new InvalidArgumentException('The given amount must be between 0 and 100');
        }
        $amount /= 100;
        $this->saturation -= $this->saturation * $amount;

        return $this;
    }

    public function toHSL()
    {
        return [
            round($this->hue),
            round($this->saturation),
            round($this->lightness),
        ];
    }

    public function toHSLString()
    {
        $hsl = $this->toHSL();

        return "hsl($hsl[0], $hsl[1], $hsl[2])";
    }
}
