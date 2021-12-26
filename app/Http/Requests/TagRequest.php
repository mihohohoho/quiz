<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     //バリデーション（入力データの検証）の定義
    public function rules()
    {
        return [
            'tag.name' => 'nullable|string|max:30',
        ];
    }
}
