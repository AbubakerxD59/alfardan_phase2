<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Feedback;
use App\Models\Survey;

class SurveyController extends BaseController
{
    public function index(Request $request)
    {
        $data = [
            'questions' => Question::with('answers')->get(),
        ];

        return $this->successResponse($data);
    }
	
	public function getSurvey(Request $request){
        
        $data = [
            'survey' => Survey::where('status',1)->get(),
        ];

        return $this->successResponse($data);
    }

    public function feedback(Request $request)
    {
        $questions = explode(',', $request->question_ids);
        $answers = explode(',', $request->answer_ids);

        $data = [];

        foreach ($questions as $key => $id) {
            
            $data[] = [
                'question_id' => $id,
                'answer_id' => $answers[$key],
                'user_id' => auth()->id()
            ];
        }

        Feedback::insert($data);

        return $this->successResponse([], 'Feedback has been sent successfully');
    }
}
