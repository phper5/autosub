<?php


namespace App\Api;


use App\Exceptions\ApiException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class UserController
{
    public function get(Request $request)
    {
        $token = Str::random(36);
        $user = $request->user();
        if (!$user) {
            $user = new User();
            $user->id = '-'.substr(\Faker\Provider\Uuid::uuid(),0,-1);
            $user->name ='guest';
            $user->email = $user->id.'@diandi.org';
            $user->save();
        }
        $user->forceFill([
            'api_token' => $token,//hash('sha256', $token),
        ])->save();
        return (new Response())->setData(['token' => $token,'id'=>$user->id,'name'=>$user->name])->Json();
    }
    public function post(Request $request) {
        $validator = $this->validator($request->all());
        try{
            $validator->validate();
        }catch (ValidationException $e){
            $mesages = $validator->getMessageBag();
            foreach ($mesages->toArray() as $key =>$msg)
            {
                $str = '';
                if ($key == 'password') {
                    $str.='密码';
                }elseif ($key === 'email') {
                    $str.='邮箱地址';
                }else{
                    $str.=$key;
                }
                if ($msg[0]=='validation.min.string') {
                    $str.='长度不够';
                }elseif ($msg[0] == 'validation.confirmed'){
                    $str.='不一致';
                }elseif ($msg[0] == 'validation.unique'){
                    $str.='重复';
                }else{
                    $str.=$msg[0];
                }
                throw new ApiException(ApiException::INVAILD_PARAM,$str);
            }


        }
        $token = Str::random(36);
        $user = $this->create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
        ]);
        $user->forceFill([
            'api_token' => $token,//hash('sha256', $token),
        ])->save();
        return (new Response())->setData(['token' => $token,'id'=>$user->id,'name'=>$user->name])->Json();
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
