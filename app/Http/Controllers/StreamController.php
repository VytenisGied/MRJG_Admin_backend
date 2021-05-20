<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stream;

class StreamController extends Controller
{

    public function all(){
        if(!($streams = Stream::all())->isEmpty()) {
            return response()->json(['streams' => $streams], 200);
        }
        return response()->json(['msg' => 'Klaida! Srautų nėra'], 404);
    }

    public function show($id)
    {
        if($stream = Stream::find($id)) {
            return response()->json(['stream' => $stream], 200);
        }
        return response()->json(['msg' => 'Srautas nerastas'], 404);
    }

    public function showStudents($id)
    {
        if(!($stream = Stream::find($id)->students)) {
            return response()->json(['msg' => 'Srautas nerastas'], 404);
        }

        $students = [];
        foreach ($stream as $student) {
            array_push ($students, ((new StudentController)->show($student->id))->original);
        }

        if(empty($students))
            return response()->json(['msg' => 'Sraute mosleivių nėra'], 404);

        return response()->json(['class' => $students], 200);
    }

    public function create(Request $request)
    {
        $streams = new Stream();

        if($streams->save())
            return response()->json([/*'class' => $class, */'msg' => 'Srautas sukurtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Srauto sukurti nepavyko'], 417);
    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {
        //
    }

    public function destroy($id)
    {
        if(!($class = Stream::find($id)))
            return response()->json(['msg' => 'Klaida! Srauto rasti nepavyko'], 404);

        if($class->delete())
            return response()->json(['msg' => 'Srautas buvo sėkmingai ištrintas'], 200);

        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
