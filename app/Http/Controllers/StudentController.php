<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\People;

class StudentController extends Controller
{

    public function all()
    {
        if($students = Student::with(['people'])->with('classes')->get()) {
            return response()->json(['students' => $students], 200);
        }
        return response()->json(['msg' => 'Moksleivių nerasta'], 404);
    }

    public function show($id)
    {
        if($student = Student::with(['people'])->with('classes')->find($id)) {
            return response()->json(['students' => $student], 200);
        }
        return response()->json(['msg' => 'Moksleivis nerastas'], 404);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
        ]);

        $person = new People();

        $person->name = $request->name;
        $person->lastname = $request->lastname;

        if(!$person->save())
            return response()->json(['msg' => 'Klaida! Nepavyko įrašyti asmens'], 417);

        $student = new Student();

        $student->person_id = $person->id;

        if($student->save())
            return response()->json(['student' => $student, 'msg' => 'Moksleivis sukurtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti moksleivio'], 417);
    }

    public function destroy($id)
    {
        if(!($student = Student::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti moksleivio'], 404);
        }

        $student_for_later = $student;
        $person_id = $student->person_id;

        if(!($person = People::find($person_id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti asmens'], 404);
        }

        if(!$student->delete()) {
            return response()->json(['msg' => 'Klaida! Moksleivis nebuvo pašalintas'], 417);
        }

        if($person->delete()) {
            return response()->json(['student' => $student_for_later, 'msg' => 'Moksleivis buvo sėkmingai ištrintas'], 200);
        }
        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
