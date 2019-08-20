<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DiagnosisTitle;
use App\Model\DiagnosisQuestion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $titles = DiagnosisTitle::all();
        return view('title', ["titles"=>$titles,]);
    }

    public function diagnosis($id)
    {
        $questions = DiagnosisQuestion::where("diagnosis_table_id", $id)->orderBy("id")->get();

        return view('questions', ["questions"=>$questions, "question_count"=>count($questions),]);
    }
}
