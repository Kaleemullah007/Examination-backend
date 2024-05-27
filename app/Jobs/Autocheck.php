<?php

namespace App\Jobs;

use App\Models\Examination;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use App\Notifications\TestNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class Autocheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $test;
    public $reqdata;
    public $user;
    public function __construct($test, $reqdata, $user)
    {
        $this->test = $test;
        $this->reqdata = $reqdata;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $statistics = $this->checkQuestion($this->test);
        $correct_answer = $statistics['correct'];
        unset($statistics['correct']);
        $wrong_answer = $statistics['wrong'];
        $statistics['wrong'];
       
        $user_attempts  = Result::where([
            'paper_id' => $this->reqdata['paper_id'],
            'subject_id' => $this->reqdata['subject_id'],
            'user_id' => $this->user['id']
        ])
            ->count() + 1;
        $result = [
            'correct_answer' => $correct_answer,
            'wrong_answer' => $wrong_answer,
            'user_attempts' => $user_attempts,
            'paper_id' => $this->reqdata['paper_id'],
            'subject_id' => $this->reqdata['subject_id'],
            'user_id' => $this->user['id'],
        ];

        $res_id = Result::create($result)->id;

        $attempted_questions = array();

        foreach($statistics['exam'] as $ques){

            $ques['result_id'] = $res_id;
            $attempted_questions[]  = $ques; 

        }

        
        Examination::insert($attempted_questions);

        $message = "You have attempted " . $user_attempts . " time with correct answer" . $correct_answer . ", wrong answer " . $wrong_answer;
        $this->user->notify(new TestNotification($message));
        $message = $this->user->name . " has attempted test " . $user_attempts . " times with correct answer" . $correct_answer . ", wrong answer " . $wrong_answer;
        $users = User::where('role', 'admin')->get();
        foreach ($users as $user) {
            $user->notify(new TestNotification($message));
        }
    }

    function checkQuestion($submittedTest)
    {

        $questions = Question::where('paper_id', $this->reqdata['paper_id'])->get()->pluck(null, 'id');


        $paper_id = $this->reqdata['paper_id'];
        $subject_id = $this->reqdata['subject_id'];
        $correct = 0;
        $wrong = 0;
        $user_id = $this->user['id'];
        $data = array();
        foreach ($questions as $key => $question) {
            $user_selected = '';
            if (isset($submittedTest[$key])) {
                $user_selected = is_array($submittedTest[$key]) ?
                    !empty($submittedTest[$key]) ? implode('__', $submittedTest[$key]) :
                    $submittedTest[$key] : $submittedTest[$key];
            }
            $flag = false;
            if (isset($submittedTest[$key])) {
                
                
                if ($question->question_type == 'radio') {
                    $user_answer = $submittedTest[$key];
                    info($user_answer);

               
                    if(strtolower($question->correct_answer) == $user_answer){
                        ++$correct;
                        $flag = true;
                    } else {
                        ++$wrong;
                    }
               
                } elseif ($question->question_type == 'checkbox') {
                    $user_submitted_answer = ($submittedTest[$key]);
                    $user_submitted_answer = is_array($user_submitted_answer) ? $user_submitted_answer : [$user_submitted_answer];
                    sort($user_submitted_answer);
                    $dd  = implode(',',$user_submitted_answer);
                   if(strtolower($question->correct_answer) == strtolower($dd)){
                    ++$correct;
                    $flag = true;
                   }
                   else {
                    ++$wrong;
                }

                } else {
                    ++$wrong;
                }
            } else {
                ++$wrong;
            }



            $data['exam'][] = [
                'user_answer' => $user_selected,
                'paper_id' => $paper_id,
                'subject_id' => $subject_id,
                'user_id' => $user_id,
                'question_id' => $key,
                'is_correct' => $flag,
                'is_auto' => true,

            ];
        }
        $data['correct'] = $correct;
        $data['wrong'] = $wrong;

        return $data;
    }
}
