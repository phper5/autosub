<?php


namespace App\Api;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Token
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
            'id'=>$user->id,
            'name'=>$user->name
        ])->save();
        return (new Response())->setData(['token' => $token,'id'=>$user->id,
            'name'=>$user->name])->Json();
    }
    public function post(Request $request) {

        $user = User::where('email',$request->input('email'))->first();
        $guard = Auth::guard();//password_verify
        if ($guard->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
        ],false)) {
            $token = Str::random(36);
            $user->forceFill([
                'api_token' => $token,//hash('sha256', $token),
            ])->save();
            return (new Response())->setData(['token' => $token,'id'=>$user->id,'name'=>$user->name])->Json();
        }else{
            throw  (new \App\Exceptions\ApiException(\App\Exceptions\ApiException::INVAILD_AUTH));
        }



    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
