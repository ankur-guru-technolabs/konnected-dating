<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\API\AuthController;
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
use App\Models\Question;
use App\Models\Salary; 
use App\Models\User;
use App\Models\UserIceBreaker;
use App\Models\UserPhoto;
use App\Models\UserQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Helper;
use Validator;
use DB;

class CustomerController extends BaseController
{
    //

    // GET LOGGED IN USER PROFILE

    public function getProfile(){
        try{

            $answeredIceBreakerIds = DB::table('user_ice_breakers')
                            ->where('user_id', Auth::id())
                            ->pluck('ice_breaker_id');

            $iceBreakers = DB::table('icebreakers')
                 ->whereNotIn('id', $answeredIceBreakerIds)
                ->select('id', 'question')
                ->get();

            foreach ($iceBreakers as $iceBreaker) {
                $iceBreaker->user_id = Auth::id();
                $iceBreaker->ice_breaker_id = $iceBreaker->id;
                $iceBreaker->answer =  null;
                $iceBreaker->question =  $iceBreaker->question;
            }
 
            $data['user'] = User::with(['iceBreakers' => function ($query) {
                $query->leftJoin('icebreakers', 'icebreakers.id', '=', 'user_ice_breakers.ice_breaker_id')
                      ->select('user_ice_breakers.id', 'icebreakers.question','user_ice_breakers.user_id', 'user_ice_breakers.ice_breaker_id', 'user_ice_breakers.answer', );
            }, 'photos', 'userQuestions' => function ($query) {
                $query->leftJoin('questions', 'questions.id', '=', 'user_questions.question_id')
                      ->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_questions.answer_id')
                      ->select('user_questions.id', 'user_questions.user_id', 'user_questions.question_id', 'user_questions.answer_id as selected_answer_id', 'questions.question', 'sub_questions.option');
            }])->find(Auth::id());
            
            if(!empty($data['user']) && !empty($data['user']['iceBreakers'])){
                $data['user']['ice_breakers_new'] = $data['user']['iceBreakers']->concat($iceBreakers);
            }

            $data['user']->photos->map(function ($photo) {
                $photo->append('profile_photo');
            });
           
            $hobbies_id                     = $data['user']['hobbies'];
            $hobbyNames                     = Hobby::whereRaw("FIND_IN_SET(id, '$hobbies_id') > 0")->pluck('name');
           
            $ethnticity_id                  = $data['user']['ethnticity'];
            $ethnticityNames                = Ethnicity::whereRaw("FIND_IN_SET(id, '$ethnticity_id') > 0")->pluck('name');

        
            $data['user']['age_new']        = Age::where('id',$data['user']['age'])->pluck('year')->first();
            $data['user']['body_type_new']  = Bodytype::where('id',$data['user']['body_type'])->pluck('name')->first();
            $data['user']['children_new']   = Children::where('id',$data['user']['children'])->pluck('children')->first();
            $data['user']['education_new']  = Education::where('id',$data['user']['education'])->pluck('name')->first();
            $data['user']['ethnticity_new'] = implode(", ", $ethnticityNames->toArray());
            $data['user']['faith_new']      = Faith::where('id',$data['user']['faith'])->pluck('name')->first();
            $data['user']['gender_new']     = Gender::where('id',$data['user']['gender'])->pluck('gender')->first();
            $data['user']['height_new']     = Height::where('id',$data['user']['height'])->pluck('height')->first();
            $data['user']['hobbies_new']    = implode(", ", $hobbyNames->toArray());
            $data['user']['industry_new']   = Industry::where('id',$data['user']['industry'])->pluck('name')->first();
            $data['user']['salary_new']     = Salary::where('id',$data['user']['salary'])->pluck('range')->first();

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
                'questions.required' => 'Questions are required',
                'questions.array' => 'Questions must be an array',
                'questions.*.question_id.required' => 'Question ID is required',
                'questions.*.answer_id.required' => 'Answer is required',
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
                'questions'   => 'required|array',
                'questions.*.question_id' => 'required',
                'questions.*.answer_id' => 'required',
            ], $messages);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',403);
            } 

            $user_data = User::where('id',$request->user_id)->first();

            if($user_data){
                if($user_data->email != $request->email){
                    // $user_data->email_verified = 0;
                    // $user_data->otp_verified = 0;
                    // $user_data->save();
                    (new AuthController)->sendOtp($request);
                }

                $user_data->update($request->except(['phone_no','email']));

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

                foreach($request['questions'] as $question){
                    $user_question_data = UserQuestion::where('user_id',$request->user_id)->where('question_id', $question['question_id'])->first();
                    if($user_question_data){
                        $user_question_data->update(['answer_id'=> $question['answer_id']]);
                    }
                }

                if (isset($request->image) && $request->hasFile('photos')) {

                    $user_old_photo_name = UserPhoto::whereIn('id', $request->image)->where('user_id',$request->user_id)->pluck('name')->toArray();

                    $deletedFiles = [];
                    if(!empty($user_old_photo_name)){
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
                    }
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

                $user_data->new_email = null;
                if($user_data->email != $request->email){
                    $user_data->new_email = $request->email;
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
