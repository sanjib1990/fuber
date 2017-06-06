<?php

namespace App\Http\Requests;

/**
 * Class SearchNearbyCabRequest
 *
 * @package App\Http\Requests
 */
class SearchNearbyCabRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lat'           => 'required | numeric',
            'lng'           => 'required | numeric',
            'radius'        => 'numeric',
            'cab_type_id'   => 'numeric | exists:cab_types,id'
        ];
    }
}
