<?php

namespace App\Http\Requests\Report;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return  [
            'crime_id' => 'required|exists:crimes,id',
            'osm_type' => 'required|string|in:node,way,relation',
            'osm_id' => 'required|integer',
            'lat' => 'required|string',
            'lon' => 'required|string', 
            'date' => 'required|string', 
            'time' => 'required|string',
            'suburb' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'region' => 'required|string',
            'country' => 'required|string',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 400));
    }
}
