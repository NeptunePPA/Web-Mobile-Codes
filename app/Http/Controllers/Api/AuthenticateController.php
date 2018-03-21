<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use App\LoginUser;

class AuthenticateController extends Controller {
	use Helpers;

	public function authenticate(Request $request) {
		$data = $request->all();

		$user = User::where('email', $request->get('email'))
            ->where('status','Enabled')
            ->first();
		//if not found the email than redirect back
		if ($user == Null) {
			return response()->json(['status' => 0, 'msg' => 'this email is not found', 'data' => []], 400);
		}

		if(!empty($user)){
		    $checkuser = User::where('id',$user->id)->where('roll',3)->first();
		    if(empty($checkuser)){
                return response()->json(['status' => 0, 'msg' => 'Only Physician can Login here', 'data' => []], 400);
            }
        }

		$rule = [
			'email' => 'required|email',
			'password' => 'required',
		];
		$validate = Validator::make($request->only('email', 'password'), $rule);
		if ($validate->fails()) {
			return response()->json(['status' => '0', 'msg' => 'validation fail', 'data' => ['errors' => $validate->errors()->all()]], 400);
		}
		$credentials = $request->only('email', 'password');
		try {
			// verify the credentials and create a token for the user
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['status' => 0, 'msg' => 'login fail ', 'data' => ['errors' => array('invalid_credentials')]], 401);
			}
		} catch (JWTException $e) {
			// something went wrong
			return response()->json(['status' => 0, 'msg' => 'login fail ', 'data' => ['errors' => array('invalid_credentials')]], 500);
		}

		$user = JWTAuth::toUser($token);

        $data1['userId'] = $user->id;
        $login = new LoginUser();
        $login->fill($data1);
        $login->save();

		return response()->json(['status' => 1, 'msg' => 'login successfully', 'data' => ['token' => $token, 'user_data' => $user]], 200);

	}

	public function agree() {
		return view('pages.api.agree');
	}

	public function confirm_agree(Request $request){

        $user =JWTAuth::toUser($request->token);

        $agree = 0;

        if($request->get('is_agree') == true){
            $agree = 1;
        }

        $update = User::where('id',$user->id)->update(['is_agree'=>$agree]);

        return response()->json(['status'=>1,'msg'=>'User Active Sucessfully'],200);
    }
}
