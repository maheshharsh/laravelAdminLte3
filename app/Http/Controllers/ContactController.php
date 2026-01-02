<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact', [
            'contactInfo' => [
                'address' => 'Choudhariyo ki gali bahety chowk bikaner rajasthan',
                'phone' => '+91 9828977775',
                'email' => 'parimalharsh7@gmail.com',
                'whatsapp' => '919828977775'
            ]
        ]);
    }
}
