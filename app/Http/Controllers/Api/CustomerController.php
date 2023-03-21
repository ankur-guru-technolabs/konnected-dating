<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\UserIceBreaker;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Helper;
use Validator;

class CustomerController extends BaseController
{
    //

    // GET LOGGED IN USER PROFILE

    public function getProfile(){
        try{
            $data['user']   =  User::with('iceBreakers', 'photos')->find(Auth::id());

            $data['user']->photos->map(function ($photo) {
                $photo->append('profile_photo');
            });
            return $this->success($data,'User profile data');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // UPDATE USER PROFILE

    public function updateProfile(Request $request){
        try{
            $messages = [
                'ice_breaker.required' => 'Ice breakers are required',
                'ice_breaker.array' => 'Ice breakers must be an array',
                'ice_breaker.min' => 'Ice breakers must have at least :min items',
                'ice_breaker.*.ice_breaker_id.required' => 'Ice breaker ID is required',
                'ice_breaker.*.answer.required' => 'Answer is required',
            ];
            $validateData = Validator::make($request->all(), [
                'user_id'    => 'required',
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|max:255|unique:users,email,'.$request->user_id,
                // 'phone_no'   => 'required|string|unique:users,phone_no|max:20',
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
                'photos'     => 'sometimes|required',
                'photos.*'   => 'sometimes|required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240',
                'ice_breaker'=> 'required|array|min:3',
                'ice_breaker.*.ice_breaker_id' => 'required',
                'ice_breaker.*.answer' => 'required',
            ], $messages);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',403);
            } 

            $user_data = User::where('id',$request->user_id)->first();

            if($user_data){
                if($user_data->email != $request->email){
                    $user_data->email_verified = 0;
                    $user_data->otp_verified = 0;
                    $user_data->save();
                    $this->sendOtp($request);
                }

                $user_data->update($request->except(['phone_no']));

                // Check ice_breaker id which is present in old data but not in new 

                $new_ice_breaker_id = collect($request['ice_breaker'])->pluck('ice_breaker_id');
                $old_ice_breaker_id = UserIceBreaker::where('user_id',$request->user_id)->pluck('ice_breaker_id');
                $ids_to_delete = $old_ice_breaker_id->diff($new_ice_breaker_id);
                UserIceBreaker::whereIn('ice_breaker_id', $ids_to_delete)->where('user_id',$request->user_id)->delete();

                foreach($request['ice_breaker'] as $ice_breaker_data){
                    $user_ice_breaker_data = UserIceBreaker::where('user_id',$request->user_id)->where('ice_breaker_id', $ice_breaker_data['ice_breaker_id'])->first();
                    if($user_ice_breaker_data){
                        $user_ice_breaker_data->update(['answer'=> $ice_breaker_data['answer']]);
                    }else{
                        $ice_breaker_data['user_id'] = $user_data->id;
                        UserIceBreaker::create($ice_breaker_data);
                    }
                }

                if (isset($request->image) && $request->hasFile('photos')) {

                    $user_old_photo_name = UserPhoto::whereIn('id', $request->image)->where('user_id',$request->user_id)->pluck('name')->toArray();

                    $deletedFiles = [];
                    foreach ($user_old_photo_name as $name) {
                        $path = public_path('user_profile/' . $name);
                        if (File::exists($path)) {
                            if (!is_writable($path)) {
                                chmod($path, 0777);
                            }
                            File::delete($path);
                            $deletedFiles[] = $path;
                        }
                    };
                    UserPhoto::whereIn('id', $request->image)->where('user_id',$request->user_id)->delete();

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
                return $this->success($user_data,'You profile successfully updated');
            }
            return $this->error('Something went wrong','Something went wrong');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // USER LOGOUT
    public function logout(){
        try{
            if (Auth::user()) {
                $user = Auth::user()->token();
                $user->revoke();
                return $this->success([],'You are succseefully logout');
            }
            return $this->error('Something went wrong','Something went wrong');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }
}
