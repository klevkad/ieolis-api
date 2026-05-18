<?php

namespace App\Http\Controllers;

use App\Http\Requests\DouaneLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UsernameLoginRequest;
use App\Models\Fichiers\RLieu;
use App\Models\Old\Acconage\Mod_Docker;
use App\Models\Old\Eolis\Username;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($type, LoginRequest $request)
    {
        if($type == 'eolis') {
            if($user = User::Where('name',request()->name)->first())
            {
                if($username = Username::find(request()->name))
                {
                    if(Hash::make($username->motdepass) !== $user->password)
                    {
                        $user->update([
                            'email' => $username->employe ? $username->employe->email : 'no@eolis.ci', 
                            'password' => Hash::make($username->motdepass), 
                            'ct_num' => 'CEOLISCI', 
                        ]);
                    }
                }
            }
            else
            {
                if($username = Username::find(request()->name))
                {
                    $username->user()->save(new User([
                            'name' => $username->codeuser, 
                            'email' => $username->employe ? ($username->employe->email ? $username->employe->email : 'undefined@eolis.ci' ) : 'no@eolis.ci', 
                            'password' => Hash::make($username->motdepass), 
                            'ct_num' => 'CEOLISCI', 
                            'enabled' => 1,
                            'change_password' => 0
                        ])
                    );
                }
            }
        }

        $credentials = strtolower($type) == 'client' ? $request->only(['email', 'password']) : $request->only(['name', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login et/ou mot de passe invalides'], 401);
        }

        $user = User::findOrFail(Auth::user()->id);
        if (!Auth::user()->enabled) {
            $user->AauthAcessToken()->delete();
            return response()->json(['message' => 'Ce compte a été désactivé'], 401);
        }

        return $this->respondWithToken( $user->createToken('userJwt'/*, ['permissions' => Auth::user()->getAllPermissions()->pluck('name'), 'roles' => Auth::user()->roles]*/) );
    }


    public function loginAgentDouane(DouaneLoginRequest $request)
    {
        if($user = User::Where('name',$request->name)->first())
        {
            if($user->hasRole('agt-douane'))
            {
                $credentials = $request->only(['name', 'password']);
                if (!Auth::attempt($credentials)) {
                    return response()->json(['message' => 'Login et/ou mot de passe invalides'], 401);
                }
                if (!Auth::user()->enabled) {
                    return response()->json(['message' => 'Ce compte a été désactivé'], 401);
                }
                return $this->respondWithToken( Auth::user()->createToken('userJwt') );
            }
        }
        return response()->json(['message' => 'Login et/ou mot de passe invalides'], 401);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        //$user = User::findOrFail(Auth::user()->id);
        /*
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();
        $token->delete();
        //Auth::user()->AauthAcessToken()->delete();
        //Auth::logout();
        */
        $ans = '';
        if (Auth::check()) {
            $user = Auth::user()->token();
            $user->revoke();
            //$user->AauthAcessToken()->delete();
            $ans = 'Déconnexion éffectuée!';
        }
        return response()->json(['message' => $ans]);          
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  Object $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = User::findOrFail(Auth::user()->id);
        Auth::user()->model;

        return response()->json([
            'access_token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_in' => 365*24*3600,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'user' => Auth::user(),
            'dockers' => $user->isUsername() ? Mod_Docker::orderBy('nom')->orderBy('prenoms')->where('statut',1)->get() : [],
            'lieux' => RLieu::orderBy('lib_lieu')->get()
        ]);
    }

}
