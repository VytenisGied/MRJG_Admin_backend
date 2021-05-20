<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\People;

class TeacherController extends Controller
{

    public function all()
    {
        if($teacher = Teacher::with(['person'])->with('classroom')->with('subject')->get()) {
            return response()->json(['teachers' => $teacher], 200);
        }
        return response()->json(['msg' => 'Mokytojų nerasta'], 404);
    }

    public function show($id)
    {
        if($teacher = Teacher::with(['person'])->with('classroom')->find($id)) {
            return response()->json(['teachers' => $teacher], 200);
        }
        return response()->json(['msg' => 'Mokytojas nerastas'], 404);
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

        $teacher = new Teacher();

        $teacher->person_id = $person->id;

        if($request->subject_id != null)
            $teacher->subject_id = $request->subject_id;

        if($teacher->save())
            return response()->json(['teacher' => $teacher, 'msg' => 'Mokyojas sukurtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti Mokytojo'], 417);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'classroom_id' => 'required|max:255',
            'attach' => 'required|boolean',
        ]);

        if($teacher = Teacher::with(['person'])->with('classroom')->find($id)) {
            if($request->attach == true) {
                $teacher->classroom()->attach($request->classroom_id);
                return response()->json(['teacher' => $teacher, 'msg' => 'Kabinetas priskirtas sėkmingai'], 200);
            }
            $teacher->classroom()->detach($request->classroom_id);
            return response()->json(['teacher' => $teacher, 'msg' => 'Kabinetas atjungtas sėkmingai'], 200);
        }

    }

    public function destroy($id)
    {
        if(!($teacher = Teacher::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti mokytojo'], 404);
        }

        $teacher_for_later = $teacher;
        $person_id = $teacher->person_id;

        if(!($person = People::find($person_id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti asmens'], 404);
        }

        if(!$teacher->delete()) {
            return response()->json(['msg' => 'Klaida! Mokytojas nebuvo pašalintas'], 417);
        }

        if($person->delete()) {
            return response()->json(['teacher' => $teacher_for_later,'msg' => 'Mokytojas buvo sėkmingai ištrintas'], 200);
        }
        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
