<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyfilesRequest extends ParentIdBaseRequest
{
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(),[
            'all' => 'nullable|bool',
            'ids.*' => Rule::exists('files', 'id')->where(function($query){
                $query->where('created_by', Auth::id());
            })
        ]);
    }
}
