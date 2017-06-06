<?php

namespace App\Transformers;

/**
 * Class CabsTransformer
 *
 * @package App\Transformers
 */
class CabsTransformer extends Transformer
{
    /**
     * Resources that can be included if requested, for lazy loading.
     *
     * @var array
     */
    protected $availableIncludes    = ['type'];

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
            'lat'       => data_get($data, 'base_lat'),
            'lng'       => data_get($data, 'base_lng'),
            'available' => data_get($data, 'available'),
        ];
    }

    /**
     * Lazy load cab type for the respective cab.
     *
     * @param $data
     *
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\NullResource
     */
    public function includeType($data)
    {
        return $data->type
            ? $this->item($data->type, new CabTypesTransformer())
            : $this->null();
    }
}
