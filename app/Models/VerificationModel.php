<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VerificationModel extends Model
{
    use HasFactory;
    protected $table = 'verification';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
       'VoterId',
       'Status',
       'VerifiedBy',
       'DateTime'
    ];

    function GetTotalVerification($status){
        return $this->where("Status", $status)->count();
    }

    function CheckMemberVerified($id){
        $result = false; 
        $member = $this->where("VoterId",$id)->first();
        if(!empty($member) && $member->Status == "Verified"){
            $result = true;
        }
        return $result;
    }

    function AddMember($data){
        $var = (object) $data;
        $result = array();
        $result["status"] = "success";
        $result["message"] = "Your request for MIGS status verification has been successfully sent.";

        $member = $this->where("VoterId",$var->Id)->first();
        if(!empty($member)){
            $result["status"] = "failed";
            $result["message"] = "You already have a request for MIGS status verification. Please wait for your account to be verified. Thank you for your understanding.";
        }else{
            $this->create([
                "VoterId" => $var->Id,
                "DateTime" => Carbon::now()
            ]);
        }
        return $result;
    }

    function verificationTable($data){
        $query = $this->select(
            "Id",
            "VoterId",
            "Status",
            "VerifiedBy",
            "DateTime"
        );

        $query = !empty($data->filterStatus) ? $query->where("Status", $data->filterStatus) : $query;
        return $query;
    }

    function UpdateMember($data){
        $var = (object) $data;
        return $this->find($var->Id)->update([
            "Status" => $var->Status,
            "VerifiedBy" => Auth::user()->Id,
            "DateTime" => Carbon::now()
        ]);
    }
}
