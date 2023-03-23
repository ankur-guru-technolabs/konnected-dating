<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Age;
use App\Models\Bodytype;
use App\Models\Children;
use App\Models\Education;
use App\Models\Ethnicity;
use App\Models\Faith;
use App\Models\Gender;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Industry;
use App\Models\Icebreaker;
use App\Models\Salary;
use App\Models\Temp;
use App\Models\User;
use App\Models\UserIceBreaker;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Exception;
use Helper;
use Validator;

class AuthController extends BaseController
{
    // SEND OTP FOR REGISTRATION, LOGIN, RESEND OTP

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
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // VERIFY OTP (IF USER EXISTS AND OTP VERIFIED THEN IT IS USED AS A LOGIN) 

    public function verifyOtp(Request $request){
        // $user = User::where('email', '=', $request->email_or_phone)
        // ->orWhere('phone_no','=', $request->email_or_phone)
        // ->select('id','email', 'phone_no')
        // ->first();
        // $data['token'] = $user->createToken('Auth token')->accessToken;
        // return $data;
        try{
            $validateData = Validator::make($request->all(), [
                'email_or_phone' => 'required',
                'otp' => 'required',
            ]);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',403);
            } 
            
            $temp         = Temp::where('key',$request->email_or_phone)->first();
            if($temp != null){
                $is_data_present = Temp::where('key',$request->email_or_phone)->where('value',$request->otp)->first();
                if($is_data_present != null){

                    $is_data_present->delete();
                    $data = [];
                    $data['user_id'] = 0;
                    $data['is_user_exist'] = 0;
                    $data['is_email_verified'] = 0;
                    $data['otp'] = $request->otp;

                    if(isset($request->id)){
                        $user = User::where('id','=', $request->id)
                        ->select('id','email', 'phone_no','email_verified')
                        ->first();
                        if ($user && filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
                            $user->update(['email'=> $request->email_or_phone]);
                        }
                    }

                    $user = User::where('email', '=', $request->email_or_phone)
                            ->orWhere('phone_no','=', $request->email_or_phone)
                            ->select('id','email', 'phone_no','email_verified')
                            ->first();

                    if ($user) {
                        $data['is_user_exist'] = 1;
                        $data['user_id'] = $user->id;
                        $data['email'] = $user->email;
                        
                        if ($user->email === $request->email_or_phone) {
                            $user->email_verified = 1;
                        }
                        $user->otp_verified = 1;
                        $user->save();
                        
                        // If user is exists and email not verifiy then show email send otp screen
                        $data['is_email_verified'] = $user->email_verified;

                        if($user->email_verified == 0){
                            $request1 = new Request();
                            $request1->merge(['email' => $user->email]);
                            $this->sendOtp($request1);
                        }

                        if($user->email_verified == 1 && $user->phone_verified = 1 && $user->otp_verified == 1){
                            $data['token'] = $user->createToken('Auth token')->accessToken;
                        }
                    } 
                    return $this->success($data,'OTP verified successfully');
                }
                return $this->error('OTP is wrong','OTP is wrong');
            } 
            $can_not_find = "Sorry we can not find data with this credentials";
            return $this->error($can_not_find,$can_not_find);

        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // RETRIVE DATA WHICH ARE NEEDED FOR REGISTRATION FORM

    public function getRegistrationFormData(){
        try{
            $data               = [];
            $data['age']        = Age::all();
            $data['body_type']  = Bodytype::all();
            $data['children']   = Children::all();
            $data['education']  = Education::all();
            $data['ethnicity']  = Ethnicity::all();
            $data['faith']      = Faith::all();
            $data['gender']     = Gender::all();
            $data['height']     = Height::all();
            $data['hobby']      = Hobby::all();
            $data['industry']   = Industry::all();
            $data['icebreaker'] = Icebreaker::all();
            $data['salary']     = Salary::all();
            return $this->success($data,'Registration form data');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }
    
    // USER REGISTRATION

    public function register(Request $request){
        try{
            $messages = [
                'ice_breaker.required' => 'Ice breakers are required',
                'ice_breaker.array' => 'Ice breakers must be an array',
                'ice_breaker.min' => 'Ice breakers must have at least :min items',
                'ice_breaker.*.ice_breaker_id.required' => 'Ice breaker ID is required',
                'ice_breaker.*.answer.required' => 'Answer is required',
            ];
            $validateData = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email|max:255',
                'phone_no'   => 'required|string|unique:users,phone_no|max:20',
                'location'   => 'required|string|max:255',
                'latitude'   => 'required|numeric',
                'longitude'  => 'required|numeric',
                'job'        => 'required|string|max:255',
                'bio'        => 'required|string',
                'company'    => 'required|string|max:255',
                'gender'     => 'required',
                'age'        => 'required',
                'height'     => 'required',
                'education'  => 'required',
                'industry'   => 'required',
                'salary'     => 'required',
                'body_type'  => 'required',
                'children'   => 'required',
                'faith'      => 'required',
                'ethnticity' => 'required',
                'hobbies'    => 'required',
                'photos'     => 'required',
                'photos.*'   => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240',
                'ice_breaker'=> 'required|array|min:3',
                'ice_breaker.*.ice_breaker_id' => 'required',
                'ice_breaker.*.answer' => 'required',
            ], $messages);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',403);
            } 

            $this->sendOtp($request);
            $input                   = $request->all();
            $input['user_type']      = 'user';
            $input['phone_verified'] = 1;
            $user_data  = User::create($input);

            if(isset($user_data->id)){

                foreach($input['ice_breaker'] as $ice_breaker_data){
                    $ice_breaker_data['user_id'] = $user_data->id;
                    UserIceBreaker::create($ice_breaker_data);
                }

                if ($request->hasFile('photos')) {
                    $photos = $request->file('photos');
                    $folderPath = public_path().'/user_profile';
                    if (!is_dir($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    foreach ($photos as $photo) {
                        $extension  = $photo->getClientOriginalExtension();
                        $filename = 'User_'.$user_data->id.'_'.random_int(10000, 99999). '.' . $extension;
                        $photo->move(public_path('user_profile'), $filename);

                        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                            $user_photo_data['type'] = 'image';
                        } elseif ($extension == 'mp4' || $extension == 'avi' || $extension == 'mov') {
                            $user_photo_data['type'] = 'video';
                        } 
                        $user_photo_data['user_id'] = $user_data->id;
                        $user_photo_data['name'] = $filename;
                        UserPhoto::create($user_photo_data);
                    }
                }
                return $this->success($user_data,'You are successfully registered');
            }
            return $this->error('Something went wrong','Something went wrong');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // CHECK EMAIL EXISTS OR NOT DURING REGISTRATION AND EMAIL CHANGE FROM MODAL

    public function emailExist(Request $request){
        try{
            $validateData = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',403);
            } 
                
            $key  = $request->email;
            
            $data['is_email_exist'] = 0;
            if (User::where('email', '=', $key)->count() > 0) {
                $data['is_email_exist'] = 1;
            }
            return $this->success($data,'Email exists check');

        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }
}
