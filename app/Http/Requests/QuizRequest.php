<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
            'quiz.title' => 'required|string|max:100',
            'quiz.choice1' => 'required|string|max:20',
            'quiz.choice2' => 'required|string|max:20',
            'quiz.choice3' => 'required|string|max:20',
            'quiz.explanation' => 'required|string|max:200',
            'quiz.image' => 'nullable|file|image|mimes:jpeg,png',
        ];
    }
}
