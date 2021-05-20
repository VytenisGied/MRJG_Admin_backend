<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;

class SubjectController extends Controller
{

    public function all(){
        if(!($subjects = Subject::all())->isEmpty()) {
            return response()->json(['subjects' => $subjects], 200);
        }
        return response()->json(['msg' => 'Klaida! Mokomųjų dalykų nėra'], 404);
    }

    public function show($id)
    {
        if($subject = Subject::find($id)) {
            return response()->json(['subject' => $subject], 200);
        }
        return response()->json(['msg' => 'Klaida! Mokomojo dalyko nėra'], 404);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $subject = new Subject();

        $subject->name = $request->name;
        
        if($subject->save())
            return response()->json(['person' => $subject, 'msg' => 'Naujas mokomasis dalykas sėkmingai įrašytas'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti mokomojo dalyko'], 417);
    }

    public function update($id, Request $request)
    {
        //
    }

    public function destroy($id)
    {
        if(!($subject = Subject::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti mokomojo dalyko'], 404);
        }
        if($subject->delete()) {
            return response()->json(['msg' => 'Mokomasis dalykas buvo sėkmingai ištrintas'], 200);
        }
        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
