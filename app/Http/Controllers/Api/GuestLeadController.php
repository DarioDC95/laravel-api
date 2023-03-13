<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestLead;
use Illuminate\Http\Request;
use App\Mail\GuestContact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class GuestLeadController extends Controller
{
    public function store(Request $request) {
        // RECUPERIAMO I DATI DELLA FORM
        $form_data = $request->all();

        // LI VALIDIAMO
        $validator = FacadesValidator::make($form_data, [
            'name' => 'required|max:50',
            'surname' => 'required|max:80',
            'email' => 'required|max:50',
            'phone_number' => 'required|max:20',
            'message' => 'required|max:65535'
        ]);

        // SE LA VALIDAZIONE FALLISCE
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // ALTRIMENTI VA AVANTI E SALVA NEL DATABASE
        $newContact = new GuestLead();
        $newContact->fill($form_data);

        $newContact->save();

        // INVIAMO LA MAIL
        Mail::to('info@boolpress.com')->send(new GuestContact($newContact));

        return response()->json([
            'success' => true,
        ]);
    }
}
