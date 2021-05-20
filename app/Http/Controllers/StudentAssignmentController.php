<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentAssignmentController extends Controller
{

    public function generate()
    {
        return response()->json(['msg' => 'Klaida! Nerealizuota'], 501);
    }

    public function get($id)
    {
        $this->validate($request, [
            'slug' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        return response()->json(['msg' => 'Klaida! Nerealizuota'], 501);
    }

    public function destroy($id)
    {
        //
    }
}
