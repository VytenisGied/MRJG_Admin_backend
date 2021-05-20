<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\People;

class PeopleController extends Controller
{

    public function all(){
        if(!($people = People::all())->isEmpty()) {
            return response()->json(['people' => $people], 200);
        }
        return response()->json(['msg' => 'Klaida! Asmenų nėra'], 404);
    }

    public function show($id)
    {
        if($person = People::find($id)) {
            return response()->json(['person' => $person], 200);
        }
        return response()->json(['msg' => 'Klaida! Asmuo nerastas'], 404);
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

        if($person->save())
            return response()->json(['person' => $person, 'msg' => 'Naujas asmuo sėkmingai įrašytas'], 200);

        return response()->json(['msg' => 'Klaida! Nepavyko įrašyti asmens'], 417);
    }

    public function update($id, Request $request)
    {
        if(!($person = People::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti asmens'], 404);
        }

        if($request->name != null)
            $person->name = $request->name;
        if($request->lastname != null)
            $person->lastname = $request->lastname;
        if($request->email != null) {
            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL))
                return response()->json(['email' => 'Klaida! Neteisingas el. pašto formatas'], 422);
            $person->email = $request->email;
        }
        if($request->phone != null)
            $person->phone = $request->phone;
        

        if($person->save()) {
            return response()->json(['person' => $person, 'msg' => 'Informacija atnaujinta sėkmingai'], 200);
        }

        return response()->json(['msg' => 'Klaida! Informacijos atnaujinti nepavyko'], 417);
    }

    public function destroy($id)
    {
        if(!($person = People::find($id))) {
            return response()->json(['msg' => 'Klaida! Nepavyko rasti asmens'], 404);
        }
        if($person->delete()) {
            return response()->json(['msg' => 'Asmuo buvo sėkmingai ištrintas'], 200);
        }
        return response()->json(['msg' => 'Klaida! Užklausa nebuvo apdorota'], 417);
    }
}
