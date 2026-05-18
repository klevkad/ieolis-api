@extends('layouts.emails')

@section('content')
    <div>
        Cher {{$user->name}}, <br>
        Votre compte d'accès à iEOLIS vient d'être créé. <br>
        Vos informations de connexion sont: <br>
        &nbsp;&nbsp;&nbsp; Email : <strong> {{$user->email}} </strong> <br>
        &nbsp;&nbsp;&nbsp; Mot de passe : <strong> {{$clearPassword}} </strong> <br><br>
        Pour vous connecter cliquez <a href="https://eolis.ci"> ici </a>
    </div>
@endsection
