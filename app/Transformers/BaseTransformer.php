<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use GuzzleHttp\Exception\TransferException;

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
