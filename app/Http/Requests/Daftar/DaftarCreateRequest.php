<?php

namespace App\Http\Requests\Daftar;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class UserCreateRequest
 *
 * @package App\Http\Requests\User
 */
class DaftarCreateRequest extends Request
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
     * Declaration an attributes
     *
     * @var array
     */
    protected $attrs = [
        'name'    => 'Name',
        'email'   => 'Email',
        'password' => 'Password',
        'phone'   => 'Phone',
        'status'   => 'Status',
        'level'   => 'Level'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:225',
            'email'   => 'required|email|unique:daftars,email|max:225',
            'password' => 'required|max:60',
            'phone'   => 'required|max:30',
            'status'   => 'required|max:30',
            'level'   => 'required|max:30'
        ];
    }

    /**
     * @param $validator
     *
     * @return mixed
     */
    public function validator($validator)
    {
        return $validator->make($this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attrs);
    }

    public function formatErrors(Validator $validator)
    {
        $message = $validator->errors();
        return [
            'success'    => false,
            'validation' => [
                'name' => $message->first('name'),
                'email' => $message->first('email'),
                'password' => $message->first('password'),
                'phone' => $message->first('phone'),
                'status' => $message->first('status'),
                'level' => $message->first('level'),
            ]
        ];
    }
}
