<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the Contact Us page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contact-us', [
            'pageTitle'       => 'Contact Us | Kidz Wear',
            'metaDescription' => 'Get in touch with Kidz Wear. We\'d love to hear from you — reach out for orders, inquiries, or support.',
        ]);
    }
}
