<?php

namespace App\Transformers;

/**
 * Class CabTypesTransformer
 *
 * @package App\Transformers
 */
class CabTypesTransformer extends Transformer
{
    /**
     * Resources that can be included if requested, for lazy loading.
     *
     * @var array
     */
    protected $availableIncludes    = ['cabs'];

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
            'id'                => data_get($data, 'id'),
            'type'              => data_get($data, 'type'),
            'price_per_km'      => data_get($data, 'price_per_km'). ' Dogecoin',
            'price_per_minute'  => data_get($data, 'price_per_minute'). ' Dogecoin',
        ];
    }

    /**
     * Lazy load cabs for the respective cab type.
     *
     * @param $data
     *
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
     */
    public function includeCabs($data)
    {
        return $data->cabs
            ? $this->collection($data->cabs, new CabsTransformer())
            : $this->null();
    }
}
