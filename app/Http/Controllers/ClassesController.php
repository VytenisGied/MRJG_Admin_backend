<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes;
use App\People;
use App\Student;

class ClassesController extends Controller
{

    public function all(){
        if(!($classes = Classes::with(['schoolmaster'])->orderBy('group', 'ASC')
        ->orderBy('name', 'ASC')->get())->isEmpty()) {
            return response()->json(['classes' => $classes], 200);
        }
        return response()->json(['msg' => 'Klaida! Klasių nėra'], 404);
    }

    public function show($id)
    {
        if($class = Classes::with(['schoolmaster'])->find($id)) {
            return response()->json(['class' => $class], 200);
        }
        return response()->json(['msg' => 'Klasė nerasta'], 404);
    }

    public function showStudents($id)
    {
        if(!($class = Classes::find($id)->students)) {
            return response()->json(['msg' => 'Klasė nerasta'], 404);
        }
        
        $students = [];
        foreach ($class as $student) {
            array_push ($students, ((new StudentController)->show($student->id))->original);
        }

        if(empty($students))
            return response()->json(['msg' => 'Klasėje moksleivių nėra'], 404);

        return response()->json(['class' => $students], 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'group' => 'required|integer',
            'name' => 'required|max:1',
        ]);

        $class = new Classes();

        $class->group = $request->group;
        $class->name = $request->name;

        if($class->save())
            return response()->json(['class' => $class, 'msg' => 'Klasė sukurta sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Klasės sukurti nepavyko'], 417);
    }

    public function assignSchoolmaster($id, Request $request)
    {
        if(!($class = Classes::find($id)))
            return response()->json(['msg' => 'Klaida! Klasės rasti nepavyko'], 404);

        $this->validate($request, [
            'schoolmaster_id' => 'required|integer',
        ]);

        $class->schoolmaster_id = $request->schoolmaster_id;

        if($class->save())
            return response()->json(['class' => $class, 'msg' => 'Auklėtojas pridėtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Auklėtojo pridėti nepavyko nepavyko'], 417);
    }

    public function assignStudent(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required|integer',
            'class_id' => 'required|integer',
        ]);

        if(!($student = Student::find($request->student_id)))
            return response()->json(['msg' => 'Klaida! Moksleivio rasti nepavyko'], 404);

        if(!($class = Classes::find($request->class_id)))
            return response()->json(['msg' => 'Klaida! Klasės rasti nepavyko'], 404);

        $student->class_id = $request->class_id;

        if($student->save())
            return response()->json(['class' => $class, 'msg' => 'Moksleivis pridėtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Moksleivio pridėti nepavyko nepavyko'], 417);
    }

    //TODO: Implamentuoti visų moksleivių skirstymą į klases-----------------------
    public function distributeAll(Request $request)
    {
        return response()->json(['msg' => 'Klaida! Neimplamentuota'], 501);
    }
    //TODO:------------------------------------------------------------------------

    public function updateGroups()
    {
        if(($classes = Classes::all())->isEmpty()) {
            return response()->json(['msg' => 'Klaida! Klasių nepavyko rasti'], 404);
        }

        foreach($classes as $curr_class) {
            if(($curr_class->group = $curr_class->group + 1) >= 5) {
                $curr_class->group = 9999;
            }
            $curr_class->save();

        }
        return response()->json(['classes' => $classes], 200);
    }

    public function destroy($id)
    {
        if(!($class = Classes::find($id)))
            return response()->json(['msg' => 'Klaida! Klasės rasti nepavyko'], 404);

        if($this->showStudents($class->id))
            return response()->json(['msg' => 'Klaida! Klasė nėra tuščia'], 422);

        if($class->delete())
            return response()->json(['msg' => 'Klasė buvo sėkmingai ištrinta'], 200);

        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
