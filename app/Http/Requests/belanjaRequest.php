<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class belanjaRequest extends FormRequest
{
    protected $balance;
    protected $user_id;
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

    public function rules(Request $request)
    {

        $balance = User::findOrFail($request->id)->only('balance')['balance'];
        $this->balance = $balance;
        $this->user_id = $request->id;
        return [
            'nominal' => 'required|integer|max:' . $balance,
            'bank' => 'required',
            'vendor' => 'required',
            'id' => 'required'
        ];
    }
    public function messages()
    {
        $balance = User::findOrFail($this->user_id)->only('balance')['balance'];
        return [
            'nominal.max' => 'Saldo anda tidak cukup, saldo anda Rp ' . $balance,
            'bank.required' => 'Nama bank belum di isi',
            'vendor.required' => 'Vendor belum diisi '
        ];
    }
}
