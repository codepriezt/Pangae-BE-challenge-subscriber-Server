<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateValidateRequest extends FormRequest
{



    use ResponseTrait;
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
                'url'=> 'required|unique:subscriptions'
            ];
        
    }


     /**
     * Throws an exception that shows the error messages
     *
     * @return exception
     */
    protected function failedValidation(Validator $validator)
    {
       throw new HttpResponseException($this->error($validator->errors(),$this->code422)) ;
       
    }
}
