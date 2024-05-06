<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class ContactController extends Controller
{
    private function getData()
    {
        if (!Cookie::has('contact')) {
            return [];
        }

        // Mendapatkan data JSON dari cookie dan mengonversinya ke dalam bentuk array
        return json_decode(Cookie::get('contact'), true);
    }

    public function view()
    {
        return view('contact');
    }

    public function actionContact(Request $request)
    {
        // Mendapatkan data kontak dari form
        $contact = [
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "message" => $request->input('message'),
        ];

        // Mendapatkan data kontak yang sudah ada dari cookie
        $contacts = $this->getData();

        // Menambahkan data kontak baru ke dalam array
        $contacts[] = $contact;

        // Mengubah data kontak menjadi format JSON
        $jsonData = json_encode($contacts);

        // Membuat cookie baru dengan data kontak yang baru
        $cookie = cookie('contact', $jsonData, 60*24*30);

        // Menambahkan cookie ke dalam respons
        return response('Success')->cookie($cookie);
    }

    public function contactList(Request $request)
    {
        // Mendapatkan data kontak dari cookie
        $contacts = $this->getData();

        // Menampilkan view 'contact_list' dengan data kontak
        return view('contact-list', ['contacts' => $contacts]);
    }


public function deleteContact(Request $request)
{
    // Retrieve the email of the contact to be deleted from the request
    $email = $request->input('email');

    // Retrieve the current contacts from the cookie
    $contacts = $this->getData();

    // Find the contact to be deleted and mark it as deleted
    foreach ($contacts as &$contact) {
        if ($contact['email'] === $email) {
            $contact['deleted'] = true;
            break;
        }
    }

    // Encode the updated contacts array to JSON
    $jsonData = json_encode($contacts);

    // Update the cookie with the updated contacts data
    $cookie = cookie('contact', $jsonData, 60*24*30);

    // Return a success response
    return response()->json(['success' => true])->withCookie($cookie);
}
    



}