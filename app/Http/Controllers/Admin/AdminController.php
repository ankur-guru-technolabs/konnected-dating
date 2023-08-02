<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Age;
use App\Models\Bodytype;
use App\Models\Children;
use App\Models\ContactSupport;
use App\Models\Coin;
use App\Models\Education;
use App\Models\Ethnicity;
use App\Models\Faith;
use App\Models\Faq;
use App\Models\Gender;
use App\Models\Gift;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Industry;
use App\Models\Icebreaker;
use App\Models\Image;
use App\Models\Question;
use App\Models\Salary;
use App\Models\Setting;
use App\Models\SubQuestion;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserReport;
use App\Models\UserSubscription;
use Validator;
use Helper; 
use Auth;

class AdminController extends BaseController
{
    // AGE

    public function ageList(){
        $ages = Age::all();
        return view('admin.age.list',compact('ages'));
    }
    
    public function ageStore(Request $request){
        $age = new Age;
        $age->year = $request->year;
        $age->save();
        return redirect()->route('questions.ages.list')->with('message','Age added Successfully'); 
    }
    
    public function ageUpdate(Request $request){
        $age = Age::find($request->id);
        if ($age) {
            $age->year = $request->year;
            $age->save();
        } 
        return redirect()->route('questions.ages.list')->with('message','Age updated Successfully'); 
    }
    
    public function ageDelete($id){
        $ages = Age::findOrFail($id);
        $ages->delete();
        return redirect()->route('questions.ages.list')->with('message','Age deleted Successfully');
    }

    // BODYTYPE

    public function bodyTypeList(){
        $bodyTypes = Bodytype::all();
        return view('admin.bodytype.list',compact('bodyTypes'));
    }
    
    public function bodyTypeStore(Request $request){
        $bodyTypes = new Bodytype;
        $bodyTypes->name = $request->name;
        $bodyTypes->save();
        return redirect()->route('questions.bodytype.list')->with('message','Body type added Successfully'); 
    }
    
    public function bodyTypeUpdate(Request $request){
        $bodyTypes = Bodytype::find($request->id);
        if ($bodyTypes) {
            $bodyTypes->name = $request->name;
            $bodyTypes->save();
        } 
        return redirect()->route('questions.bodytype.list')->with('message','Body type updated Successfully'); 
    }
    
    public function bodyTypeDelete($id){
        $bodyTypes = Bodytype::findOrFail($id);
        $bodyTypes->delete();
        return redirect()->route('questions.bodytype.list')->with('message','Body type deleted Successfully');
    }

    // CHILDREN

    public function childrenList(){
        $childrens = Children::all();
        return view('admin.children.list',compact('childrens'));
    }
    
    public function childrenStore(Request $request){
        $childrens = new Children;
        $childrens->children = $request->children;
        $childrens->save();
        return redirect()->route('questions.children.list')->with('message','Children added Successfully'); 
    }
    
    public function childrenUpdate(Request $request){
        $childrens = Children::find($request->id);
        if ($childrens) {
            $childrens->children = $request->children;
            $childrens->save();
        } 
        return redirect()->route('questions.children.list')->with('message','Children updated Successfully'); 
    }
    
    public function childrenDelete($id){
        $childrens = Children::findOrFail($id);
        $childrens->delete();
        return redirect()->route('questions.children.list')->with('message','Children deleted Successfully');
    }

    // EDUCATION

    public function educationList(){
        $educations = Education::all();
        return view('admin.education.list',compact('educations'));
    }
    
    public function educationStore(Request $request){
        $educations = new Education;
        $educations->name = $request->name;
        $educations->save();
        return redirect()->route('questions.education.list')->with('message','Education added Successfully'); 
    }

    public function educationUpdate(Request $request){
        $educations = Education::find($request->id);
        if ($educations) {
            $educations->name = $request->name;
            $educations->save();
        }  
        return redirect()->route('questions.education.list')->with('message','Education updated Successfully'); 
    }
    
    public function educationDelete($id){
        $educations = Education::findOrFail($id);
        $educations->delete();
        return redirect()->route('questions.education.list')->with('message','Education deleted Successfully');
    }

    // ETHNICITY

    public function ethnicityList(){
        $ethnicities = Ethnicity::all();
        return view('admin.ethnicity.list',compact('ethnicities'));
    }
    
    public function ethnicityStore(Request $request){
        $ethnicities = new Ethnicity;
        $ethnicities->name = $request->name;
        $ethnicities->save();
        return redirect()->route('questions.ethnicity.list')->with('message','Ethnicity added Successfully'); 
    }

    public function ethnicityUpdate(Request $request){
        $ethnicities = Ethnicity::find($request->id);
        if ($ethnicities) {
            $ethnicities->name = $request->name;
            $ethnicities->save();
        }   
        return redirect()->route('questions.ethnicity.list')->with('message','Ethnicity updated Successfully'); 
    }
    
    public function ethnicityDelete($id){
        $ethnicities = Ethnicity::findOrFail($id);
        $ethnicities->delete();
        return redirect()->route('questions.ethnicity.list')->with('message','Ethnicity deleted Successfully');
    }

    // FAITH

    public function faithList(){
        $faiths = Faith::all();
        return view('admin.faith.list',compact('faiths'));
    }
    
    public function faithStore(Request $request){
        $faiths = new Faith;
        $faiths->name = $request->name;
        $faiths->save();
        return redirect()->route('questions.faith.list')->with('message','Faith added Successfully'); 
    }

    public function faithUpdate(Request $request){
        $faiths = Faith::find($request->id);
        if ($faiths) {
            $faiths->name = $request->name;
            $faiths->save();
        }   
        return redirect()->route('questions.faith.list')->with('message','Faith updated Successfully'); 
    }
    
    public function faithDelete($id){
        $faiths = Faith::findOrFail($id);
        $faiths->delete();
        return redirect()->route('questions.faith.list')->with('message','Faith deleted Successfully');
    }

    // GENDER

    public function genderList(){
        $genders = Gender::all();
        return view('admin.gender.list',compact('genders'));
    }
    
    public function genderStore(Request $request){
        $genders = new Gender;
        $genders->gender = $request->gender;
        $genders->save();
        return redirect()->route('questions.gender.list')->with('message','Gender added Successfully'); 
    }

    public function genderUpdate(Request $request){
        $genders = Gender::find($request->id);
        if ($genders) {
            $genders->gender = $request->gender;
            $genders->save();
        }   
        return redirect()->route('questions.gender.list')->with('message','Gender updated Successfully'); 
    }
    
    public function genderDelete($id){
        $genders = Gender::findOrFail($id);
        $genders->delete();
        return redirect()->route('questions.gender.list')->with('message','Gender deleted Successfully');
    }

    // HEIGHT

    public function heightList(){
        $heights = Height::all();
        return view('admin.height.list',compact('heights'));
    }
    
    public function heightStore(Request $request){
        $heights = new Height;
        $heights->height = $request->height;
        $heights->save();
        return redirect()->route('questions.height.list')->with('message','Height added Successfully'); 
    }
    
    public function heightUpdate(Request $request){
        $heights = Height::find($request->id);
        if ($heights) {
            $heights->height = $request->height;
            $heights->save();
        }   
        return redirect()->route('questions.height.list')->with('message','Height updated Successfully'); 
    }
    
    public function heightDelete($id){
        $heights = Height::findOrFail($id);
        $heights->delete();
        return redirect()->route('questions.height.list')->with('message','Height deleted Successfully');
    }

    // HOBBY

    public function hobbyList(){
        $hobbies = Hobby::all();
        return view('admin.hobby.list',compact('hobbies'));
    }
    
    public function hobbyStore(Request $request){
        $hobbies = new Hobby;
        $hobbies->name = $request->name;
        $hobbies->save();
        return redirect()->route('questions.hobby.list')->with('message','Hobby added Successfully'); 
    }
    
    public function hobbyUpdate(Request $request){
        $hobbies = Hobby::find($request->id);
        if ($hobbies) {
            $hobbies->name = $request->name;
            $hobbies->save();
        }   
        return redirect()->route('questions.hobby.list')->with('message','Hobby updated Successfully'); 
    }
    
    public function hobbyDelete($id){
        $hobbies = Hobby::findOrFail($id);
        $hobbies->delete();
        return redirect()->route('questions.hobby.list')->with('message','Hobby deleted Successfully');
    }

    // ICE BREAKER

    public function icebreakerList(){
        $ice_breakers = Icebreaker::all();
        return view('admin.icebreaker.list',compact('ice_breakers'));
    }
    
    public function icebreakerStore(Request $request){
        $ice_breakers = new Icebreaker;
        $ice_breakers->question = $request->question;
        $ice_breakers->save();
        return redirect()->route('questions.icebreaker.list')->with('message','Icebreaker added Successfully');
    }
    
    public function icebreakerUpdate(Request $request){
        $ice_breakers = Icebreaker::find($request->id);
        if ($ice_breakers) {
            $ice_breakers->question = $request->question;
            $ice_breakers->save();
        }   
        return redirect()->route('questions.icebreaker.list')->with('message','Icebreaker updated Successfully');
    }
    
    public function icebreakerDelete($id){
        $ice_breakers = Icebreaker::findOrFail($id);
        $ice_breakers->delete();
        return redirect()->route('questions.icebreaker.list')->with('message','Icebreaker deleted Successfully');
    }

    // INDUSTRY

    public function industryList(){
        $industries = Industry::all();
        return view('admin.industry.list',compact('industries'));
    }
    
    public function industryStore(Request $request){
        $industries = new Industry;
        $industries->name = $request->name;
        $industries->save();
        return redirect()->route('questions.industry.list')->with('message','Industry added Successfully'); 
    }

    public function industryUpdate(Request $request){
        $industries = Industry::find($request->id);
        if ($industries) {
            $industries->name = $request->name;
            $industries->save();
        }    
        return redirect()->route('questions.industry.list')->with('message','Industry updated Successfully'); 
    }
    
    public function industryDelete($id){
        $industries = Industry::findOrFail($id);
        $industries->delete();
        return redirect()->route('questions.industry.list')->with('message','Industry deleted Successfully');
    }

    // QUESTION

    public function questionList(){
        $questions = Question::all();
        return view('admin.question.list',compact('questions'));
    }
    
    public function questionStore(Request $request){
        $questions = new Question;
        $questions->question = $request->question;
        $questions->save();

        $questionId = $questions->id;
        $options =  explode('₹',$request->option);
        foreach($options as $option){
            $sub_question = new Subquestion;
            $sub_question->question_id = $questionId;
            $sub_question->option = $option;
            $sub_question->save();
        }
        return redirect()->route('questions.question.list')->with('message','Question added Successfully');
    }
    
    public function questionUpdate(Request $request){
        $questionId = $request->id;
        Subquestion::where('question_id',$questionId)->delete();
        $questions = Question::find($request->id);
        if ($questions) {
            $questions->question = $request->question;
            $questions->save();
        }

        $options =  explode('₹',$request->option);

        foreach($options as $option){
            $sub_question = new Subquestion;
            $sub_question->question_id = $questionId;
            $sub_question->option = $option;
            $sub_question->save();
        }   
        return redirect()->route('questions.question.list')->with('message','Question updated Successfully');
    }
    
    public function questionDelete($id){
        Subquestion::where('question_id',$id)->delete();
        $questions = Question::findOrFail($id);
        $questions->delete();
        return redirect()->route('questions.question.list')->with('message','Question deleted Successfully');
    }

    public function subQuestionList($id){
        $tags = Subquestion::where('question_id',$id)->get('option');
        return response()->json(['tags' => $tags]);
    }

    // SALARY

    public function salaryList(){
        $salaries = Salary::all();
        return view('admin.salary.list',compact('salaries'));
    }
    
    public function salaryStore(Request $request){
        $salaries = new Salary;
        $min_salary = 0;
        $max_salary = 0;
        $range = $request->range;
        $range_array = explode('-',$range);
        if(isset($range_array[0])){
            $min_salary = $range_array[0];
        }
        if(isset($range_array[1])){
            $max_salary = $range_array[1];
        }
        $salaries->range = $range;
        $salaries->min_salary = $min_salary;
        $salaries->max_salary = $max_salary;
        $salaries->save();
        return redirect()->route('questions.salary.list')->with('message','Salary added Successfully'); 
    }

    public function salaryUpdate(Request $request){
        $salaries = Salary::find($request->id);
        if ($salaries) {
            $min_salary = 0;
            $max_salary = 0;
            $range = $request->range;
            $range_array = explode('-',$range);
            if(isset($range_array[0])){
                $min_salary = $range_array[0];
            }
            if(isset($range_array[1])){
                $max_salary = $range_array[1];
            }
            $salaries->range = $range;
            $salaries->min_salary = $min_salary;
            $salaries->max_salary = $max_salary;
            $salaries->save();
        }   
        return redirect()->route('questions.salary.list')->with('message','Salary updated Successfully'); 
    }
   
    public function salaryDelete($id){
        $salaries = Salary::findOrFail($id);
        $salaries->delete();
        return redirect()->route('questions.salary.list')->with('message','Salary deleted Successfully');
    }

    // FEEDBACK

    public function feedbackList(){
        $feedbacks = ContactSupport::all();
        return view('admin.feedback.list',compact('feedbacks'));
    }

    // SETTING

    public function staticPagesList(){
        $settings = Setting::all();
        return view('admin.setting.list',compact('settings'));
    }

    public function pageEdit($id){
        $settings = Setting::where('id',$id)->first();
        return view('admin.setting.edit',compact('settings'));
    }

    public function pageUpdate(Request $request){

        $validator = Validator::make($request->all(),[
            'id'=>"required",
            'title'=>"required",
            'description'=>"required",
        ]);

        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        $input = $request->all();
        $insert_data['title']       = $input['title'];
        $insert_data['value']       = $input['description'];

        Setting::where('id',$request->id)->update($insert_data);
        return redirect()->route('static-pages.list')->with('message','Page updated Successfully'); 
    }

    // SUBSCRIPTION

    public function subscriptionOrder(){
        $orders = UserSubscription::with('user','subscriptionOrder')->get();
        return view('admin.subscription.order',compact('orders'));
    }
    
    public function subscriptionList(){
        $subscription = Subscription::all();
        return view('admin.subscription.list',compact('subscription'));
    }
    
    public function subscriptionEdit($id){
        $subscription = Subscription::where('id',$id)->first();
        $subscription['allowed_subscription'] = explode(',',$subscription->search_filters);
        return view('admin.subscription.edit',compact('subscription'));
    }
    
    public function subscriptionUpdate(Request $request){
        
        $validator = Validator::make($request->all(),[
            'id'=>"required",
            'title'=>"required",
            'description'=>"required",
            'search_filters'=>"required",
            'like_per_day'=>"required",
            'video_call'=>"required",
            'who_like_me'=>"required",
            'who_view_me'=>"required",
            'undo_profile' => "required",
            'read_receipt' => "required",
            'travel_mode' => "required",
            'profile_badge' => "required",
            'coin' => "required",
            'month'=>"required",
            'plan_duration'=>"required"
        ]);

        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        $input = $request->all();
        $insert_data['title']             = $input['title'];
        $insert_data['description']       = $input['description'];
        $insert_data['search_filters']    = implode(',',$input['search_filters']);
        $insert_data['like_per_day']      = $input['like_per_day'];
        $insert_data['video_call']        = $input['video_call'];
        $insert_data['who_like_me']       = $input['who_like_me'];
        $insert_data['who_view_me']       = $input['who_view_me'];
        $insert_data['undo_profile']      = $input['undo_profile'];
        $insert_data['read_receipt']      = $input['read_receipt'];
        $insert_data['travel_mode']       = $input['travel_mode'];
        $insert_data['profile_badge']     = $input['profile_badge'];
        $insert_data['coin']              = $input['coin'];
        $insert_data['month']             = $input['month'];
        $insert_data['plan_duration']     = $input['plan_duration'];
        
        Subscription::where('id',$request->id)->update($insert_data);
        return redirect()->route('subscription.list')->with('message','Subscription updated Successfully'); 
    }

    // FAQ

    public function faqList(){
        $faqs = Faq::all();
        return view('admin.faq.list',compact('faqs'));
    }

    public function faqEdit($id){
        $faqs = Faq::where('id',$id)->first();
        return view('admin.faq.edit',compact('faqs'));
    }

    public function faqUpdate(Request $request){

        $validator = Validator::make($request->all(),[
            'id'=>"required",
            'question'=>"required",
            'answer'=>"required",
        ]);

        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        $input = $request->all();
        $insert_data['question']    = $input['question'];
        $insert_data['answer']       = $input['answer'];

        Faq::where('id',$request->id)->update($insert_data);
        return redirect()->route('faq.list')->with('message','FAQ updated Successfully'); 
    }

    // COIN

    public function coinList(){
        $coins = Coin::all();
        return view('admin.coin.list',compact('coins'));
    }
    
    public function coinStore(Request $request){
        $coin = new Coin;
        $coin->coins = $request->coins;
        $coin->price = $request->price;
        $coin->save();
        return redirect()->route('coin.list')->with('message','Coin added Successfully'); 
    }
    
    public function coinUpdate(Request $request){
        $coin = Coin::find($request->id);
        if ($coin) {
            $coin->coins = $request->coins;
            $coin->price = $request->price;
            $coin->save();
        } 
        return redirect()->route('coin.list')->with('message','Coin updated Successfully'); 
    }
    
    public function coinDelete($id){
        $coins = Coin::findOrFail($id);
        $coins->delete();
        return redirect()->route('coin.list')->with('message','Coin deleted Successfully');
    }

    // GIFT

    public function giftList(){
        $gifts = Gift::all();
        return view('admin.gift.list',compact('gifts'));
    }
    
    public function giftStore(Request $request){
        $folderPath = public_path().'/gift';
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        
        $filename = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension  = $image->getClientOriginalExtension();
            $filename = 'Gift_'.random_int(10000, 99999). '.' . $extension;
            $image->move(public_path('gift'), $filename);
        }

        $gift = new Gift;
        $gift->image = $filename;
        $gift->coin = $request->coin;
        $gift->save();
        return redirect()->route('gift.list')->with('message','Gift added Successfully'); 
    }
    
    public function giftUpdate(Request $request){
          
        $folderPath = public_path().'/gift';

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $gift = Gift::find($request->id);
        if ($gift) {

            $filename = $gift->image;
            if (isset($request->image) && $request->hasFile('image')) {
                $path = public_path('gift/' . $gift->image);
               
                if (File::exists($path)) {
                    if (!is_writable($path)) {
                        chmod($path, 0777);
                    }
                    File::delete($path);
                }

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $extension  = $image->getClientOriginalExtension();
                    $filename = 'Gift_'.random_int(10000, 99999). '.' . $extension;
                    $image->move(public_path('gift'), $filename);
                }
            }

            $gift->image = $filename;
            $gift->coin = $request->coin;
            $gift->save();
        } 
        return redirect()->route('gift.list')->with('message','Gift updated Successfully'); 
    }
    
    public function giftDelete($id){
        $gifts = Gift::findOrFail($id);

        $path = public_path('gift/' . $gifts->image);         
        if (File::exists($path)) {
            if (!is_writable($path)) {
                chmod($path, 0777);
            }
            File::delete($path);
        }

        $gifts->delete();
        return redirect()->route('gift.list')->with('message','Gift deleted Successfully');
    }


    // NOTIFICATION

     public function notificationIndex(){
        return view('admin.notification.index');
    }

    public function notificationSend(Request $request){

        $validator = Validator::make($request->all(),[
            'title'=>"required",
            'message'=>"required",
        ]);

        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        $title = $request->title;
        $message = $request->message;
        Helper::send_notification_by_admin($title, $message, []);

        return view('admin.notification.index');
    }

    // REPORT

    public function reportList(){
        $report = UserReport::with(['reporter:id,first_name,last_name','reportedUser:id,status,first_name,last_name'])->get(); 
        return view('admin.report.list',compact('report'));
    }

    public function userBlock(Request $request){
        try{
            $userId = $request->input('id');
            $user = User::find($userId); 
            if($user){
                $user->status = $request->status;
                $user->fcm_token = null;
                $user->save();

                $tokens = $user->tokens;
        
                foreach ($tokens as $token) {
                    $token->revoke();
                }
                return $this->success([],'User block successfully');
            }
            return $this->error('User not found','User not found');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // https://api.postman.com/collections/26159511-9f6ccf59-b792-460a-8d91-dd900cd19292?access_key=PMAT-01GZXFXWF9N0AQECZ7MZ1SJCCS
    // IMAGE LIST

    public function imageList()
    {
        try{
            $data['image_list'] = Image::where('type','test_user')->get();
            return $this->success($data,'Image list');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // IMAGE ADD

    public function imageStore(Request $request)
    {
        try{
            $validateData = Validator::make($request->all(), [
                'image'   => 'required|file|mimes:jpeg,webp|max:100000', 
            ]);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',422);
            }

            $media      = $request->file('image');
            $extension  = $media->getClientOriginalExtension();
			$filename   = 'Test_user_' . random_int(10000, 99999) . '.' . $extension;
			$media->move(public_path('test_user'), $filename);

            $image            = new Image();
            $image->type_id   = 0;
            $image->file_name = $filename;
            $image->type      = "test_user";
            $image->save();

            return $this->success([],'Image added successfully');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }
   
    // IMAGE DETAILS

    public function imageDetail(Request $request,$id)
    {
        try{
            if ($id < 1) {
                return $this->error('Please select valid image','Please select valid image');
            }
            $data['image_details'] = Image::where('id',$id)->first();
            if(!empty($data['image_details'])){
                return $this->success($data,'Image details');
            }
            return $this->error('Image not found','Image not found');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // PRODUCT UPDATE

    public function imageUpdate(Request $request)
    {
        try{
            $validateData = Validator::make($request->all(), [
                'image_id'  => 'required',
                'image'     => 'required|file|mimes:jpeg,webp|max:100000', 
            ]);

            if ($validateData->fails()) {
                return $this->error($validateData->errors(),'Validation error',422);
            } 

            $image_details = Image::where('id',$request->image_id)->first();
            if(!empty($image_details)){ 
                $path = public_path('test_user/' . $image_details->file_name);
                if (File::exists($path)) {
                    if (!is_writable($path)) {
                        chmod($path, 0777);
                    }
                    File::delete($path);
                }
 
                $media      = $request->file('image');
                $extension  = $media->getClientOriginalExtension();
                $filename   = 'Test_user_' . random_int(10000, 99999) . '.' . $extension;
                $media->move(public_path('test_user'), $filename);
    
                $image_details->file_name  = $filename;
                $image_details->save();

                return $this->success([],'Image updated successfully');
            }
            return $this->error('Image not found','Image not found');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }

    // IMAGE DELETE

    public function imageDelete($id)
    {
        try{
            if ($id < 1) {
                return $this->error('Please select valid image','Please select valid image');
            }
            $image_details = Image::where('id',$id)->first();
            if(!empty($image_details)){
                $path = public_path('test_user/' . $image_details->file_name);
                if (File::exists($path)) {
                    if (!is_writable($path)) {
                        chmod($path, 0777);
                    }
                    File::delete($path);
                }
                $image_details->delete();
                return $this->success([],'Image delete successfully');
            }
            return $this->error('Image not found','Image not found');
        }catch(Exception $e){
            return $this->error($e->getMessage(),'Exception occur');
        }
        return $this->error('Something went wrong','Something went wrong');
    }
}
