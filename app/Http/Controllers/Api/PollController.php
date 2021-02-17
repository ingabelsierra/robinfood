<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Poll;
use App\Question;
use App\Answer;
use Validator;

class PollController extends Controller {

    public function index(Request $request) {

        try {

            $polls = Poll::all();
            
            if($polls)
            return response()->json($polls, 200);           
            
        } catch (\Exception $e) {

            Log::critical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function show($id) {

        try {            

            $questions = Question::with('answers')->where('poll_id', $id)->get();
           
             if($questions)
                 return response()->json($questions, 200);           
            
        } catch (\Exception $e) {

            Log::critical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function saveResultPoll(Request $request) {

        try {

            //validamos los campos obligatorios en el request
            $validator = Validator::make($request->all(), [
                        'client_name' => 'required',
                        'poll_id' => 'required',
                        'questions' => 'required',
                        'answers' => 'required',
            ]);


            if ($validator->fails()) {
                Log::error('Falló la validación');
                return response()->json(['Falló la validación' => $validator->errors()], 422);
            }

            //validamos que exista la encuesta
            $poll = Poll::find($request->poll_id);
            if (!$poll) {
                return response()->json('La encuesta no existe ', 422);
            }

            //validamos que el numero de preguntas sea igual al numero de respuestas
            $questions_count = count($request->questions);
            $answers_count = count($request->answers);

            if ($questions_count != $answers_count) {

                return response()->json('El numero de preguntas debe ser igual al numero de respuestas ', 422);
            }

            //Realizamos las validaciones antes de insertar los datos
            for ($i = 0; $i < $questions_count; $i++) {

                //validamos que cada una de las preguntas exista y que pertenezca a la encuesta                
                $ques = Question::where('id', $request->questions[$i])
                        ->where('poll_id', $request->poll_id)
                        ->first();

                if (!$ques) {
                    return response()->json('La pregunta ' . $request->questions[$i] . ' no existe o no pertenece a la encuesta: ' . $request->poll_id, 422);
                }

                //validamos que cada una de las respuestas exista y que pertenezca a la pregunta
                $ans = Answer::where('id', $request->answers[$i])
                        ->where('question_id', $ques->id)
                        ->first();

                if ($ans instanceof Answer) {
                    
                } else {
                    return response()->json('La respuesta ' . $request->answers[$i] . ' no existe o no pertenece a la pregunta ' . $ques->id, 422);
                }
            }

            //Una vez validados los arrays, procedemos a insertar en la tabla results
            for ($i = 0; $i < $questions_count; $i++) {

                $ques = Question::where('id', $request->questions[$i])
                        ->where('poll_id', $request->poll_id)
                        ->first();

                $ans = Answer::where('id', $request->answers[$i])
                        ->where('question_id', $ques->id)
                        ->first();

                DB::table('results')->insert([
                    'client_name' => $request->client_name,
                    'poll_id' => $request->poll_id,
                    'question_id' => $ques->id,
                    'answer_id' => $ans->id
                ]);
            }

            return response()->json('Encuesta Guardada...', 200);
           
        } catch (\Exception $e) {

            Log::critical('Error: ' . $e->getMessage() . ' Code: ' . $e->getCode());
            return response()->json($e->getMessage(), 500);
        }
    }

}
