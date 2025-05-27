<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsertypeModel extends Model
{
    use HasFactory;
    protected $table = 'usertype';
    protected $primaryKey = 'Id';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'UserType'
    ];

    function getUserType(){
        return $this->get();
    }

    function getUserTypeArray(){
        $result = array();
        
        foreach($this->get() as  $userType){
            $result[$userType["Id"]] = $userType["UserType"];
        }
        
        return $result;
    }
}
