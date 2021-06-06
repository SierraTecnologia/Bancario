<?php
/**
 * Created by PhpStorm.
 * User: sierra
 * Date: 12/22/17
 * Time: 5:45 PM
 */

namespace Bancario\Traits\Tradding;

use Bancario\Models\Tradding;

/**
 * Class Config
 *
 * @package Bancario\Traits\Tradding
 */
trait Config
{
    /**
     * @param $val
     *
     * @return bool|\Illuminate\Database\Eloquent\Model|mixed|null|string|static
     */
    public static function bowhead_config($val)
    {
        try {
            $ret = \Bancario\Models\Tradding\Config::firstorcreate(['item' => $val]); // Models\Tradding\Configs::where('item', '=', $val)->first();
            if (empty($ret->value)) {
                $ret = env($val);
                if (!empty($ret)) {
                    return $ret;
                } else {
                    return false;
                }
            } else {
                return $ret->value;
            }
        } catch (\Exception $e) {
            return false;
        }

    }
}