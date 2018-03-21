<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Carbon;
use Response;
use Excel;
use View;
use Mail;
use Session;
use App\User;
use App\UserMail;
use App\customContact;



class ValidationController extends Controller
{
    public function getphone(Request $request){
        $mail = $request->get('cc');

        $data = UserMail::where('email',$mail)->value('phoneNumber');

        if(empty($data)){
            $data = User::where('email',$mail)->value('mobile');
        }

        if ($data)
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }

    public function securemail(){
        $data = User::where('status','Enabled')->get();

        foreach ($data as $value){
            $row['name'] = $value->name;
            $row['email'] = $value->email;
            $row['phoneNumber'] = $value->mobile;
            $row['status'] = $value->status;
            $row['password'] = $value->password;

            $securemail = new UserMail();
            $securemail->fill($row);
            if($securemail->save()){
                $title = "Welcome to Neptune-PPA Secure Mail Server Network";

                $datas = array(
                    'title' => $title,
                    'user' => $value->name,
                    'to' => $value->email,
                );

                Mail::send('emails.sendsecuremail', $datas, function ($message) use ($datas) {

                    $message->from('admin@neptuneppa.com', 'Neptune-PPA Secure Mail')->subject($datas['title']);

//                    $message->to($datas['to']);
                    $message->to('punit@micrasolution.com');
                });
            }
        }

    }
}
