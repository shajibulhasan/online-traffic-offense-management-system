<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'nid' => ['required', 'unique:users'],
            'role' => ['required', 'in:user,admin,officer'],
        ];
        
        // License validation for user role
        if (isset($data['role']) && $data['role'] === 'user') {
            $rules['license'] = ['required', 'unique:users,license'];
        } else {
            $rules['license'] = ['nullable'];
        }
        
        return Validator::make($data, $rules, [
            'license.required' => 'License number is required for user role.',
            'license.unique' => 'This license number is already registered.',
            'phone.unique' => 'This phone number is already registered.',
            'nid.unique' => 'This NID is already registered.',
            'email.unique' => 'This email is already registered.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['role'],
            'license' => $data['role'] === 'user' ? $data['license'] : null,
            'nid' => $data['nid'],
            'password' => Hash::make($data['password']),
            // 'created_at' will be automatically added by Laravel
        ]);
    }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        session()->flash('success', 'Registration successful! Welcome ' . $user->name);
        
        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'officer') {
            return redirect()->route('dashboard');
        }
        
        return redirect()->route('home');
    }
    
    /**
     * Handle registration validation errors
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse(Request $request, $exception)
    {
        session()->flash('error', 'Registration failed! Please check your input.');
        
        return redirect()->back()
            ->withErrors($exception->errors())
            ->withInput();
    }
}