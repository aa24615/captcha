<?php

namespace Zyan\Captcha;

use Intervention\Image\ImageManagerStatic;

/**
 * Class Image.
 *
 * @package Zyan\Captcha
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Image
{

    /**
     * @var array
     */

    protected $config = [
        'width' => 108,
        'height' => 38,
        'background' => '#eee',
        'font_size' => 20,
        'session' => true
    ];

    /**
     * @var \Intervention\Image\Image
     */
    protected $img = null;

    /**
     * @var int
     */
    protected $code = 0;


    /**
     * Captcha constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * setConfig.
     *
     * @param array $config
     *
     * @return void
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function setConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * make.
     *
     * @return self
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function make()
    {
        $width = $this->config['width'];
        $height = $this->config['height'];
        $background = $this->config['background'];
        $font_size = $this->config['font_size'];

        $img = ImageManagerStatic::canvas($width, $height, $background);

        $h = rand(0, 2);
        $c = rand(1, 9);
        $a = rand(1, 9);
        $b = ['+','-','×'][$h];
        $d = "=";
        $e = "?";
        $z = 0;
        switch ($h) {
            case 0:
                $z = $a + $c;
                break;
            case 1:
                $z = $a - $c;
                if ($a < $c) {
                    $b = '×';
                    $z = $a * $c;
                }
                break;
            case 2:
                $z = $a * $c;
                break;
            default:
                $z = 0;
                break;
        }

        $y = $height / 2 + ($font_size / 2.5);
        $x = $width / 5 - ($font_size / 5);

        $img->text($a, $x * 1, $y, function ($font) use ($font_size) {
            $font->file(__DIR__.'/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($b, $x * 2, $y, function ($font) use ($font_size) {
            $font->file(__DIR__.'/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($c, $x * 3, $y, function ($font) use ($font_size) {
            $font->file(__DIR__.'/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($d, $x * 4, $y, function ($font) use ($font_size) {
            $font->file(__DIR__.'/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($e, $x * 5, $y, function ($font) use ($font_size) {
            $font->file(__DIR__.'/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#f00');
            $font->angle(0);
        });



        $this->img = $img;
        $this->code = $z;


        $this->session();

        return $this;
    }

    /**
     * sessoin.
     *
     * @return void
     *
     * @author 读心印 <aa24615@qq.com>
     */

    private function session()
    {
        if ($this->config['session']) {
            $_SESSION['zyan_captcha_code'] = $this->code;
        }
    }


    /**
     * save.
     *
     * @param string $filename
     *
     * @return \Intervention\Image\Image
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function save(string $filename)
    {
        return $this->img->save($filename);
    }

    /**
     * getCode.
     *
     * @return int
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getCode()
    {
        return $this->code;
    }

    /**
     * verify.
     *
     * @param int $code
     *
     * @return boolean
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function verify(int $code)
    {

        if(!isset( $_SESSION['zyan_captcha_code'])){
            return false;
        }
        $zyan_captcha_code = $_SESSION['zyan_captcha_code'];

        if ($zyan_captcha_code == $code) {
            $_SESSION['zyan_captcha_code'] = null;
            return true;
        } else {
            return false;
        }
    }
}
