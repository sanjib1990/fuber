<?php

namespace App\Transformers;

/**
 * Class CustomersTransformer
 *
 * @package App\Transformers
 */
class CustomersTransformer extends Transformer
{
    /**
     * Transform the data.
     *
     * @param $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return [
            'id'        => data_get($data, 'id'),
            'name'      => data_get($data, 'name'),
            'mobile'    => data_get($data, 'mobile'),
            'email'     => data_get($data, 'email'),
            'lat'       => data_get($data, 'base_lat'),
            'lng'       => data_get($data, 'base_lng'),
        ];
    }
}
