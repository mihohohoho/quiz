<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     //バリデーション
    public function rules()
    {
        return [
            'comment.body' => 'required|string|max:350',
        ];
    }

}
