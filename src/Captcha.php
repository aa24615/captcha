<?php


/*
 * This file is part of the zyan/captcha.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\Captcha;

/**
 * Class Captcha.
 *
 * @package Zyan\WebLink
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Captcha
{
    /**
     * make.
     *
     * @return Image
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public static function make(array $config = [])
    {
        $img = new Image($config);
        return $img->make();
    }
}
