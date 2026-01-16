<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $isAjax = $request->ajax();

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:today',
            'email' => 'nullable|email',
            'country_code' => 'nullable|in:+375,+7',
            'phone' => 'nullable|array',
            'phone.*' => 'nullable|string|max:20',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'about' => 'nullable|string|max:1000',
            'agreed' => 'accepted',
        ]);

        if(empty($validated['email']) && empty(array_filter($validated['phone'] ?? []))){
            if($isAjax){
                return response()->json(['errors'=>['contact'=>['Укажите email или телефон']]],422);
            } else {
                return back()->withErrors(['contact'=>'Укажите email или телефон'])->withInput();
            }
        }

        ContactForm::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'] ?? null,
            'country_code' => $validated['country_code'] ?? null,
            'phone' => json_encode($validated['phone'] ?? []),
            'marital_status' => $validated['marital_status'],
            'about' => $validated['about'] ?? null,
            'agreed' => true,
        ]);

        if($isAjax){
            return response()->json(['success'=>true,'message'=>'Успешно']);
        } else {
            return redirect()->back()->with('success','Успешно');
        }
    }

}
