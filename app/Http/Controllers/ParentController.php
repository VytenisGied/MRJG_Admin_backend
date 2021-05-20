<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Parents;
use App\People;

class ParentController extends Controller
{

    public function all()
    {
        if(!($parents = Parents::with(['people'])->get())->isEmpty()) {
            return response()->json(['parents' => $parents], 200);
        }
        return response()->json(['msg' => 'Tėvų/globėjų nerasta'], 404);
    }

    public function show($id)
    {
        if($parent = Parents::with(['people'])->find($id)) {
            return response()->json(['parent' => $parent], 200);
        }
        return response()->json(['msg' => 'Tėvas/globėjas nerastas'], 404);
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

        $parent = new Parents();

        $parent->person_id = $person->id;

        if($parent->save())
            return response()->json(['parent' => $parent, 'msg' => 'Tėvas/globėjas sukurtas sėkmingai'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti tėvo/globėjo'], 417);
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
        if(!($parent = Parents::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti tėvo/globėjo'], 404);
        }

        $person_id = $parent->person_id;

        if(!($person = People::find($person_id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti asmens'], 404);
        }

        if(!$parent->delete()) {
            return response()->json(['msg' => 'Klaida! Tėvas/globėjas nebuvo pašalintas'], 417);
        }

        if($person->delete()) {
            return response()->json(['msg' => 'Tėvas/globėjas buvo sėkmingai ištrintas'], 200);
        }
        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
