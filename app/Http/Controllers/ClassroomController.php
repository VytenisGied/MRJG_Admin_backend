<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classroom;

class ClassroomController extends Controller
{

    public function all()
    {
        if(!($classrooms = Classroom::with(['subject'])->get())->isEmpty()) {
            return response()->json(['classrooms' => $classrooms], 200);
        }
        return response()->json(['msg' => 'Kabinetų nėra'], 404);
    }

    public function show($id)
    {
        if($classroom = Classroom::with(['subject'])->find($id)) {
            return response()->json(['classroom' => $classroom], 200);
        }
        return response()->json(['msg' => 'Kabinetas nerastas'], 404);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $classroom = new Classroom();

        $classroom->name = $request->name;

        if($request->subject_id != null)
            $classroom->subject_id = $request->subject_id;

        if($classroom->save())
            return response()->json(['classroom' => $classroom, 'msg' => 'Kabinetas sukurtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti kabineto'], 417);
    }

    public function update($id, Request $request)
    {
        if(!($classroom = Classroom::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti kabineto'], 404);
        }

        if($request->name)
            $classroom->name = $request->name;
        
        if($request->subject_id)
            $classroom->subject_id = $request->subject_id;

        if($classroom->save())
            return response()->json(['msg' => 'Informacija atnaujinta sėkmingai'], 200);

        return response()->json(['msg' => 'Informacijos atnaujinti nepavyko'], 417);
    }

    public function destroy($id)
    {
        if(!($classroom = Classroom::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti kabineto'], 404);
        }

        if($classroom->delete()) {
            return response()->json(['msg' => 'Kabinetas buvo sėkmingai ištrintas'], 200);
        }

        return response()->json(['msg' => 'Klaida! Kabinetas nebuvo pašalintas'], 417);
    }
}
