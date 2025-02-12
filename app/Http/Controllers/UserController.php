<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //de homepagina van mijn users
        $users = User::orderBy('id','desc')->paginate(10);

        //return view('backend.users.index',['users' => $users, 'roles' => $roles]);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $messages = [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.required' => 'Het wachtwoord is verplicht.',
            'password.min' => 'Het wachtwoord moet minimaal :min tekens bevatten.',
            'role_id.required' => 'Selecteer een rol voor de gebruiker.',
            'is_active.required' => 'Selecteer of de gebruiker actief is.',
            'photo_id.image' => 'De geüploade afbeelding moet een geldig afbeeldingsbestand zijn.',];

        //wegschrijven van de nieuwe user
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required|in:0,1',
            'password' => 'required|min:6',
//           'photo_id'=>'nullable|image'
        ], $messages);

        //paswoord hashen
        $validatedData['password'] = bcrypt($validatedData['password']);

        //gebruiker aanmaken
        User::create($validatedData);

        //redirect naar users
        return redirect()->route('users.index')->with('message', 'User created successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //weergave voor een nieuwe user
        $roles = Role::pluck('name', 'id')->all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //weergaven van 1 enkele user
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //weergave van 1 enkele user met de waarden opgehaald uit de DB
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //is het overschrijven van de gewijzigde waarden uit de function edit.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete van een user
    }
}
