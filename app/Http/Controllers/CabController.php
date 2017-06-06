<?php

namespace App\Http\Controllers;

use App\Utils\Transformer;
use App\Contracts\CabContract;
use App\Contracts\CabTypeContract;
use App\Http\Requests\BookCabRequest;
use App\Transformers\CabsTransformer;
use App\Transformers\TransitsTransformer;
use App\Transformers\CabTypesTransformer;
use App\Http\Requests\SearchNearbyCabRequest;
use App\Contracts\CabCustomerTransitContract;

/**
 * Class CabController
 *
 * @package App\Http\Controllers
 */
class CabController extends Controller
{
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * CabController constructor.
     *
     * @param Transformer $transformer
     */
    public function __construct(Transformer $transformer)
    {
        $this->transformer  = $transformer;
    }

    /**
     * Get List of Cabs.
     *
     * @param CabContract $cab
     *
     * @return mixed
     */
    public function get(CabContract $cab)
    {
        if (request()->id) {
            return $this->getById($cab);
        }

        $cabs   = $cab->getList(request()->all());

        return response()->jsend(
            $this
                ->transformer
                ->process($cabs, new CabsTransformer()),
            trans('api.success')
        );
    }

    /**
     * Get details for a specific Cab.
     *
     * @param CabContract $cab
     *
     * @return mixed
     */
    private function getById(CabContract $cab)
    {
        $cab    = $this
            ->transformer
            ->process(
                $cab->getById(request()->id),
                new CabsTransformer()
            );

        return response()->jsend($cab, trans('api.success'));
    }

    /**
     * Search near by available cabs.
     *
     * @param CabContract            $cab
     * @param SearchNearbyCabRequest $request
     */
    public function search(CabContract $cab, SearchNearbyCabRequest $request)
    {
        $cabs   = $cab->getNearby($request->all());

        return response()->jsend(
            $this
                ->transformer
                ->process($cabs, new CabsTransformer()),
            trans('api.success')
        );
    }

    /**
     * Get list of cab types.
     *
     * @param CabTypeContract $cabType
     *
     * @return mixed
     */
    public function types(CabTypeContract $cabType)
    {
        return response()->jsend(
            $this
                ->transformer
                ->process($cabType->all(), new CabTypesTransformer()),
            trans('api.success')
        );
    }

    /**
     * Book a cab.
     *
     * @param CabContract                $cab
     * @param BookCabRequest             $request
     * @param CabCustomerTransitContract $transit
     *
     * @return mixed
     */
    public function book(CabContract $cab, BookCabRequest $request, CabCustomerTransitContract $transit)
    {
        // Store in Transit
        $book   = $transit->store($request->all());

        // block the cab
        $cab->block($request->get('cab_id'));

        return response()->jsend(
            $this
                ->transformer
                ->process($book, new TransitsTransformer()),
            trans('api.success'),
            201
        );
    }
}
