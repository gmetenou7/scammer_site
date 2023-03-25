<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;



class UserController extends Controller
{

    public function __construct(){
        $this->users = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validatedData = $request->validate([
            'contacts__email' => 'required|email',
            'password' =>'required|regex:/^[a-zA-Z0-9._éèêÉÈ@=+ÊàôÀÔïÏ\'\- ]+$/|max:255'
        ], [
            'contacts__email.required' => 'email is required',
            'contacts__email.email' => 'one or more unauthorized characters found',

            'password.required' => 'password is required',
            'password.regex' => 'one or more unauthorized characters found',
        ]);


        /**on verifi l'employe en fonction de son email*/
        $query = $this->users->login($validatedData['contacts__email']);

        /**si erreur survenu */
        if(!$query){
            return redirect('/login')->with('status', 'Incorrect email or password.');
        }

        $password = $validatedData['password'];

        if(!Hash::check($password,$query['password'])){
            return redirect('/login')->with('status', 'Incorrect email or password.');
        }

        $sessiondata = [
            "id" => $query['id'],
            "matricule" => $query['matricule'],
            "nom" => $query['nom'],
            "prenom" => $query['prenom'],
            "email" => $query['email'],
            "telephone" => $query['telephone'],
            "nompays" => $query['nompays'],
            "type" => $query['type'],
            "created_at" => $query['created_at'],
            "updated_at" => $query['updated_at']
        ];

        session($sessiondata);

        //$request->session()->all()
        return redirect('/client-portal')->with('status', 'happy to see you '.$request->session()->get('prenom').' '.$request->session()->get('nom'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'firstname' => 'required|regex:/^[a-zA-Z0-9._éèêÉÈÊàôÀÔïÏ\'\- ]+$/|max:255',
            'lastName' => 'required|regex:/^[a-zA-Z0-9._éèêÉÈÊàôÀÔïÏ\'\- ]+$/|max:255',
            'contacts__email' => 'required|email',
            'address__countryCode' => 'required|regex:/^[a-zA-Z0-9._éèêÉÈÊàôÀÔïÏ\'\- ]+$/|max:255',
            'contacts__phone' => 'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/',
            'password' =>'required|regex:/^[a-zA-Z0-9._éèêÉÈ@=+ÊàôÀÔïÏ\'\- ]+$/|max:255|same:cpassword',
            'cpassword' =>'required|regex:/^[a-zA-Z0-9._éèêÉÈ@=+ÊàôÀÔïÏ\'\- ]+$/|max:255|same:password',
        ], [
            'firstname.required' => 'first name is required',
            'firstname.regex' => 'one or more unauthorized characters found',

            'lastName.required' => 'last Name is required',
            'lastName.regex' => 'one or more unauthorized characters found',

            'contacts__email.required' => 'email is required',
            'contacts__email.email' => 'one or more unauthorized characters found',

            'address__countryCode.required' => 'country is required',
            'address__countryCode.regex' => 'one or more unauthorized characters found',

            'contacts__phone.required' => 'phone is required',
            'contacts__phone.regex' => 'one or more unauthorized characters found',

            'password.required' => 'password is required',
            'password.regex' => 'one or more unauthorized characters found',
            'password.same' => 'the password must be identical to the password confirmation',

            'cpassword.required' => 'confirm password is required',
            'cpassword.regex' => 'one or more unauthorized characters found',
            'cpassword.same' => 'the password confirmation must be identical to the password',
        ]);

        $submitdata = [
            "matricule" => code(5),
            "nom" => $validatedData['firstname'],
            "prenom" => $validatedData['lastName'],
            "email" => $validatedData['contacts__email'],
            "telephone" => $validatedData['contacts__phone'],
            "nompays" => $validatedData['address__countryCode'],
            "password" => \bcrypt($validatedData['password']),
        ];
        $query = $this->users->newusers($submitdata);
        if(!$query){
            return redirect('/register')->with('status', 'error occurred, user not created!');
        }

        return redirect('/login')->with('status', 'account created successfully, login to continue.');
    }


    public function newtransaction(Request $request){


        $validator = Validator::make($request->all(),[
            'clientlist' => 'required|regex:/^[a-zA-Z0-9._éèêÉÈÊàôÀÔïÏ\'\- ]+$/|max:255',
            'amount' => 'required|regex:/^[0-9.]+$/|max:255',
            'fluctuation' => 'required|regex:/^[0-9\-]+$/|max:255',
        ], [
            'clientlist.required' => 'costomer name is required',
            'clientlist.regex' => 'one or more unauthorized characters found',

            'amount.required' => 'amount is required',
            'amount.regex' => 'one or more unauthorized characters found',

            'fluctuation.required' => 'percentage of fluctuation is required',
            'fluctuation.regex' => 'one or more unauthorized characters found',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }


        $fluctus = (($request->amount * $request->fluctuation) / 100);

        $savedata = [
            "matricule" =>  code(5),
            "montant" => $request->amount,
            "pourcentage" => $request->fluctuation,
            "fluctuation" => $fluctus,
            "codeclient" => $request->clientlist,
            "created_at" => dates(),
            "updated_at" => dates(),
        ];

        $query = $this->users->newtransactiondb($savedata);
        if(!$query){
            return response()->json([
                'error' => 'error, transaction not created'
            ]);
        }
        return response()->json([
            'success' => 'transaction created successfully '
        ]);

    }



    public function listcostomers(){
        $query = $this->users->listcostomersdb();

        if ($query->isEmpty()) {
            return response()->json([ 'error' => 'no customers available' ]);
        }
        return response()->json(['success' => $query]);
    }

    public function getalltransaction(){
        $query = $this->users->getalltransactiondb();

        if ($query->isEmpty()) {
            return response()->json([ 'error' => 'no transaction available' ]);
        }
        return response()->json(['success' => $query]);
    }

    public function getalltransactioncostomers(){
        $costomermatricule = session()->get('matricule');
        $query = $this->users->getalltransactioncostomersdb($costomermatricule);

        if ($query->isEmpty()) {
            return response()->json([ 'error' => 'no transaction available' ]);
        }
        return response()->json(['success' => $query]);
    }




    public function deltransaction(Request $request){

        $query = $this->users->deletetransactiondb($request->mat_);

        if (!$query) {
            return response()->json([ 'error' => 'Transaction not deleted successfully'.$request->mat_ ]);
        }
        return response()->json(['success' => 'Transaction deleted successfully']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function logout(){
        session()->flush();


        session()->forget([
        "_token" => "Gxw8CNogZ9Q4sy0kgOAifvZBCM5VFUmV0Dx2WMoL",
        "id" => 3,
        "matricule" => "23-94016",
        "nom" => "Gildas",
        "prenom" => "consulting",
        "email" => "ok@ok.com",
        "telephone" => "+234566789344",
        "nompays" => "le pays est grave",
        "type" => "admin",
        "created_at" => "2023-03-15 20:13:19",
        "updated_at" => "2023-03-15 20:13:19",
        "status" => "happy to see you consulting Gildas"
      ]);
        return redirect('/login')->with('status', 'you are disconnected, see you soon');
    }
}
