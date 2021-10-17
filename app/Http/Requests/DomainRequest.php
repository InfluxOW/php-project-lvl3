<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'active_url'],
        ];
    }

    protected function prepareForValidation()
    {
        $scheme = parse_url($this->name, PHP_URL_SCHEME);
        if ($scheme === null) {
            $this->merge([
                'name' => "https://{$this->name}",
            ]);
        }
    }
}
