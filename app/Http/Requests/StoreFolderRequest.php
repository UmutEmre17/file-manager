<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class StoreFolderRequest extends ParentIdBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

     
        Log::info('Parent ID in request:', ['parent_id' => $this->parent_id, 'created_by' => Auth::id(), ]);
        return array_merge(parent::rules(),
            [
                'name' => [
                    'required', 'unique:files',
                     Rule::unique(File::class, 'name')
                        ->where('created_by', Auth::id())
                        ->where('parent_id', $this->input('parent_id'))
                        ->whereNull('deleted_at')
                        
                ],
                
            ]
        );
    }

    public function messages()
    {
        return [
            'name.unique' => 'Folder ":input" already exists'
        ];
    }

}
