<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'property_type' => 'required|integer',
            'description' => 'required|string',
            'tenancy_status' => 'required|integer',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'area' => 'required|string',
            'funishing_status' => 'required|integer',
            'funishing_details' => 'required|string',
            'share_property_url' => 'required|url',
            'images.*.image' => 'required|integer',
            'amenities' => 'required|array',
            'rooms.*.image' => 'required|integer',
            'rooms.*.name' => 'required|string',
            'rooms.*.type' => 'required|integer',
            'questions.*.question_id' => 'required|integer'
        ];
    }
}
