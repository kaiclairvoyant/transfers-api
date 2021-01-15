<?php

namespace App\Http\Request;

use App\Rules\PayerRule;
use App\Rules\TransferValueRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'value' => [
                'required',
                'integer',
                new TransferValueRule()
            ],
            'payer_id' => [
                'required',
                'integer',
                new PayerRule()
            ],
            'payee_id' => 'required|integer|exists:users,id',
        ];
    }
}
