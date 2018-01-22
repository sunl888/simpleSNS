<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 21:04
 */

namespace App\Transformers;

use GuzzleHttp\Exception\TransferException;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * transformer params validation.
     *
     * @param $params
     * @param $validParams
     */
    protected function verificationParams($params, $validParams)
    {
        $usedParams = array_keys(iterator_to_array($params));
        if ($invalidParams = array_diff($usedParams, $validParams)) {
            throw new TransferException(sprintf(
                'Invalid param(s): "%s". Valid param(s): "%s"',
                implode(',', $usedParams),
                implode(',', $validParams)
            ));
        }
    }
}