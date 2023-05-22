<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
use App\Models\Question;
use App\Models\Salary;
use App\Models\Subquestion;

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
        $options =  explode(',',$request->option);

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

        $options =  explode(',',$request->option);

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
}
