<?php

namespace App\Http\Controllers;

use App\Utils\Transformer;
use App\Contracts\CustomerContract;
use App\Transformers\CustomersTransformer;

/**
 * Class CustomerController
 *
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * CustomerController constructor.
     *
     * @param Transformer $transformer
     */
    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Get Customers.
     *
     * @param CustomerContract $customer
     *
     * @return mixed
     */
    public function get(CustomerContract $customer)
    {
        if (request()->id) {
            return $this->getById($customer);
        }

        $customers  = $customer->getList(request()->all());

        return response()->jsend(
            $this
                ->transformer
                ->process($customers, new CustomersTransformer()),
            trans('api.success')
        );
    }

    /**
     * Get specific customer detail.
     *
     * @param CustomerContract $customer
     *
     * @return mixed
     */
    private function getById(CustomerContract $customer)
    {
        $customer   = $customer->getById(request()->id);

        return response()->jsend(
            $this
                ->transformer
                ->process($customer, new CustomersTransformer()),
            trans('api.success')
        );
    }
}
