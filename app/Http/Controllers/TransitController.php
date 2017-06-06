<?php

namespace App\Http\Controllers;

use App\Contracts\CabContract;
use App\Utils\Transformer;
use App\Transformers\TransitsTransformer;
use App\Contracts\CabCustomerTransitContract;

/**
 * Class TransitController
 *
 * @package App\Http\Controllers
 */
class TransitController extends Controller
{
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * TransitController constructor.
     *
     * @param Transformer $transformer
     */
    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Get list of transits.
     *
     * @param CabCustomerTransitContract $transit
     *
     * @return mixed
     */
    public function get(CabCustomerTransitContract $transit)
    {
        if (request()->transitId) {
            return $this->getById($transit);
        }
        
        $transits   = $transit->getList(request()->all());

        return response()->jsend(
            $this
                ->transformer
                ->process($transits, new TransitsTransformer()),
            trans('api.success')
        );
    }

    /**
     * Get Transit by transit Id.
     *
     * @param CabCustomerTransitContract $transit
     *
     * @return mixed
     */
    private function getById(CabCustomerTransitContract $transit)
    {
        $transit    = $transit->getById(request()->transitId);
        
        return response()->jsend(
            $this
                ->transformer
                ->process($transit, new TransitsTransformer()),
            trans('api.success')
        );
    }

    /**
     * Start a transit.
     *
     * @param CabCustomerTransitContract $transit
     *
     * @return \Illuminate\Http\Response
     */
    public function start(CabCustomerTransitContract $transit)
    {
        $transit->start(request()->transitId);

        return response(null, 205);
    }

    /**
     * End a transit.
     *
     * @param CabContract                $cab
     * @param CabCustomerTransitContract $transit
     *
     * @return \Illuminate\Http\Response
     */
    public function end(CabContract $cab, CabCustomerTransitContract $transit)
    {
        // End the journey
        $transit->end(request()->transitId);

        // Get the cab id.
        $transit    = $transit->getById(request()->transitId);

        if (! empty($transit)) {
            // unblock the cab
            $cab->unblock($transit->cab_id);

            // update the current location of the cab
            $cab->updateCurrentLocation($transit->cab_id, $transit->to_lat, $transit->to_lng);
        }

        return response(null, 205);
    }
}
