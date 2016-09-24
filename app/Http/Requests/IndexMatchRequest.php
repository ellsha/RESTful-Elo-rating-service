<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $start start time for searching matches by the started_at time
 * @property string $end end time for searching matches by the started_at time
 */
class IndexMatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => 'required_with:end|date_format:Y-m-d H:i:s',
            'end'   => 'required_with:start|date_format:Y-m-d H:i:s',
        ];
    }
}