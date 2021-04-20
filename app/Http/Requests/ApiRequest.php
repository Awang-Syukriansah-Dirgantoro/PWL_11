<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Dotenv\Validator;
use Facade\FlareClient\Http\Response;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator as IlluminateValidationValidator;
use PHPUnit\Util\Xml\Validator as XmlValidator;
use Ramsey\Uuid\Rfc4122\Validator as Rfc4122Validator;

abstract class ApiRequest extends FormRequest
{
    use ApiResponse;

    abstract public function rules();

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException($this->apiError($validator->errors(),
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
        ));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->apiError(null,
            HttpResponse::HTTP_UNAUTHORIZED
        ));
    }
}
