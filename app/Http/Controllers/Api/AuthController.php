<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Temp;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Helper;
use Validator;

class AuthController extends BaseController
{
    // Send otp for register, login

    public function sendOtp(Request $request){
        try{

            $otp    = substr(number_format(time() * rand(),0,'',''),0,4);
            $data   = [];
            $data['is_user_exist'] = 0;
            
            if(isset($request->email)){
                $validateData = Validator::make($request->all(), [
                    // 'email' => 'required|email|unique:users,email',
                    'email' => 'required|email',
                ]);

                if ($validateData->fails()) {
                    return $this->error($validateData->errors(),'Validation error',403);
                } 
                
                $key          = $request->email;
                $email_data   = [
                    'email'   => $key,
                    'otp'     => $otp,
                    'subject' => 'Email OTP Verification - For Konnected dating',
                ];

                Helper::sendMail('emails.email_verify', $email_data, $key, '');

                if (User::where('email', '=', $key)->count() > 0) {
                    $data['is_user_exist'] = 1;
                }
                $data['send_in'] = 'email';

            } else if(isset($request->phone_no)){

                $validateData = Validator::make($request->all(), [
                    // 'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone_no',
                    'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                ]);

                if ($validateData->fails()) {
                    return $this->error($validateData->errors(),'Validation error',403);
                } 
               
                $key             = $request->phone_no;

                if (User::where('phone_no','=', $key)->count() > 0) {
                    $data['is_user_exist'] = 1;
                }
                $data['send_in'] = 'phone_no';
            } else {
                return $this->error('Please enter email or phone number','Required parameter');
            }
            
            $temp         = Temp::firstOrNew(['key' => $key]);
            $temp->key    = $key;
            $temp->value  = $otp;
            $temp->save();
            
            return $this->success($data,'OTP send successfully');

        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur',);
        }
    }
}
