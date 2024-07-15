<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Date;

class DateValidationController extends Controller
{
    public function showForm(Request $request)
    {
        $lang = $request->get('lang', 'en'); // Default to English if lang is not set
        App::setLocale($lang);
        
        return view('date-validation-form');
    }

    public function validateDates(Request $request)
    {
        $messages = [
            'end_date_field.after_or_equal' => __('messages.end_date_invalid'),
        ];

        $request->validate([
            'start_date_field' => 'required|date',
            'end_date_field' => 'required|date|after_or_equal:start_date_field',
        ], $messages);

        Date::create([
            'start_date' => $request->start_date_field,
            'end_date' => $request->end_date_field,
        ]);

       
        return back()->with('success', __('lang.messages.dates_validated'));
    }
}
