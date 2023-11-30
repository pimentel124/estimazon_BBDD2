<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
