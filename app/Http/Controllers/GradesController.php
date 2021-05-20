<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grades;
use App\Student;

class GradesController extends Controller
{

    public function all()
    {
        if(!($grades = Grades::with(['student'])->with('subject')->get())->isEmpty()) {
            return response()->json(['grades' => $grades], 200);
        }
        return response()->json(['msg' => 'Pažymių nerasta'], 404);
    }

    public function show($id)
    {
        if(!($grades = Grades::with(['student'])->with('subject')->where('student_id', $id)->get())->isEmpty()) {
            return response()->json(['grades' => $grades], 200);
        }
        return response()->json(['msg' => 'Pažymių nerasta'], 404);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required|max:255',
            'subject_id' => 'required|max:255',
            'grade' => 'required|max:255',
        ]);

        $grade = new Grades();

        $grade->student_id = $request->student_id;
        $grade->subject_id = $request->subject_id;
        $grade->grade = $request->grade;

        if($grade->save())
            return response()->json(['grade' => $grade, 'msg' => 'Pažimys įvestas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įvesti pažymio'], 417);
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
        if(!($grades = Grades::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti pažymio'], 404);
        }

        if($grades->delete()) {
            return response()->json(['msg' => 'Pažimys sėkmingai pašalintas'], 200);
        }

        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);


    }
}
