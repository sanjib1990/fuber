<?php

namespace App\Transformers;

/**
 * Class TransitsTransformer
 *
 * @package App\Transformers
 */
class TransitsTransformer extends Transformer
{
    /**
     * Resources that can be included if requested, for lazy loading.
     *
     * @var array
     */
    protected $availableIncludes    = ['cab', 'customer'];

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
            'id'            => data_get($data, 'id'),
            'to_lng'        => data_get($data, 'to_lng'),
            'to_lat'        => data_get($data, 'to_lat'),
            'from_lat'      => data_get($data, 'from_lat'),

            'from_lng'      => data_get($data, 'from_lng'),
            'started_at'    => data_get($data, 'started_at'),
            'ended_at'      => data_get($data, 'ended_at'),
            'status'        => data_get($data, 'status'),

            'price'         => data_get($data, 'price'). ' Dogecoin',
        ];
    }

    /**
     * Lazy load customer for the respective transit.
     *
     * @param $data
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeCustomer($data)
    {
        return $this->item($data->customer, new CustomersTransformer());
    }

    /**
     * Lazy load cab for the respective transit.
     *
     * @param $data
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeCab($data)
    {
        return $this->item($data->cab, new CabsTransformer());
    }
}
