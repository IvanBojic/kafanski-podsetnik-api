<?php

namespace App\Http\Controllers;

use App\Models\User;
use Croonus\Ecommerce\Globals\Classes\Common;
use Croonus\Ecommerce\Globals\Classes\ErrorHandler;
use Dirape\Token\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{

    public function loginUser(Request $request) {
        // Request params.

        dd('ccc');
        $return = [
            'code' => '',
            'message' => '',
            'payload' => (object) array(),
            'success' => ''
        ];

        $fields = [
            'id',
            'first_name',
            'last_name',
            'email',
            'role'
        ];

        $user = User::where(['email' => $request->email])
            ->first()
        ;

        if(!$user) {
            $return['code'] = 422;
            $return['message'] = 'Uneli ste nepostojećeg korisnika.';
            $return['success'] = false;
        } else if(md5($request->password) != $user->password) {
            $return['code'] = 422;
            $return['message'] = 'Lozinka nije ispravna.';
            $return['success'] = false;
        } else {
            //Update user token
            $updateToken =  User::where('id', $user->id)
                ->update(['remember_token' => (new Token())
                    ->Unique('users', 'remember_token', 60)])
            ;
            //Display user data after token update
            $userData = $user = User::select($fields)->where(['email' => $request->email])
                ->first()
            ;

            $token = User::select('remember_token')->where('id', $userData->id)->first();

            $return = [
                'code' => 200,
                'message' => 'Uspešno ste se ulogovali.',
                'payload' => (object) array(
                    'user_data'     => $userData,
                    'access_token'  => $token->remember_token
                ),
                'success' => true
            ];

            //$user_token = User::findOrFail($user->id)->update([$user->remember_token => (new Token())->Unique('users', 'remember_token', 60)]);

        }


        return Response::json($return)->setStatusCode($return['code']);

    }

    public function logoutUser(Request $request)
    {
        $return = [
            'code' => '',
            'message' => '',
            'payload' => (object) array(),
            'success' => ''
        ];

        $token = $request->bearerToken();

        $user = User::select('id')
            ->where("remember_token", $token)
            ->first();

        if($user){
            $token_destroy = User::where('id', $user->id)
                ->update([
                    'remember_token'          => NULL,
                ]);

            if($token_destroy){
                $return['code'] = 200;
                $return['message'] = 'Uspešno ste se izlogovali!';
                $return['success'] = true;
            } else {
                $return['code'] = 422;
                $return['message'] = 'Došlo je do greške!';
                $return['success'] = false;
            }
        } else {
            $return['code'] = 422;
            $return['message'] = 'Došlo je do greške!';
            $return['success'] = false;
        }

        return Response::json($return)->setStatusCode($return['code']);
    }
}
