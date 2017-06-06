<?php

namespace App\Http\Requests;

/**
 * Class BookCabRequest
 *
 * @package App\Http\Requests
 */
class BookCabRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id'   => 'required | exists:customers,id',
            'cab_id'        => 'required | exists:cabs,id,available,1',
            'from_lat'      => 'required | numeric',
            'from_lng'      => 'required | numeric',
            'to_lat'        => 'required | numeric',
            'to_lng'        => 'required | numeric'
        ];
    }
}