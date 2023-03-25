<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;

    protected $table ="client";
    protected $fillable = ['id','matricule','nom','prenom','email','telephone','nompays','type','password','created_at','updated_at','fluctuation','pourcentage'];


    public function newusers($submitdata){
        return User::create($submitdata);
    }


    public function login($email){
        return User::where('client.email','=',$email)->first();
    }


    public function listcostomersdb(){
        return User::whereNull('client.type')->orderByDesc('client.created_at')->get();
    }


    public function newtransactiondb($savedata){
        return DB::table('transaction')->insert($savedata);
    }

    public function getalltransactiondb(){
        return DB::table('transaction')->select('transaction.*','client.nom','client.prenom')->leftjoin('client','transaction.codeclient','=','client.matricule')->orderByDesc('transaction.created_at')->get();
    }

    public function getalltransactioncostomersdb($costomermatricule){
        return DB::table('transaction')->select('transaction.*','client.nom','client.prenom')->where('transaction.codeclient','=',$costomermatricule)->leftjoin('client','transaction.codeclient','=','client.matricule')->orderByDesc('transaction.created_at')->get();
    }

    public function deletetransactiondb($code_transaction){
        return DB::table('transaction')->where('transaction.matricule','=',$code_transaction)->delete();
    }



}
