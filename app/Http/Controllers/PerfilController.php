<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Add this import statement

class PerfilController extends Controller
{
    public function index()
    {
        $userName = auth()->user()->name;
        return view('perfil', compact('userName'));
    }

    public function actualizar(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8|confirmed',
    ]);
    $user->fill($data);
    $user->save();
    // ...

    public function actualizar(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update the user record
        User::where('id', $user->id)->update($data);

        return redirect()->route('perfil')->with('success', 'Perfil actualizado con éxito');
    }
    $user->update($data);

    return redirect()->route('perfil')->with('success', 'Perfil actualizado con éxito');
}

public function getRoleId()
{
    $user = auth()->user();

    if ($user) {
        return $user->role_id;
    }

    return null; // O un valor predeterminado en caso de que el usuario no esté autenticado.
}

}
