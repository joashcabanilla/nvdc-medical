<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VotersModel extends Model
{
    use HasFactory;
    protected $table = 'voters';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Pbno',
        'MemberId',
        'FirstName',
        'MiddleName',
        'LastName',
        'Birthdate',
        'UpdateBirthdateBy',
        'UpdateBirthdate',
        'Contact',
        'MembershipDate',
        'Status',
        'UpdateStatusBy',
        'UpdateStatus',
        'Branch',
    ];

    function SearchMember($id){
        return $this->where("Pbno",$id)->orWhere("MemberId",$id)->get();
    }

    function GetBranchList(){
        return $this->select("Branch")->distinct()->orderBy("Branch", "ASC")->get();
    }

    function GetTotalMember($status = ""){
        if(!empty($status)){
            return $this->where("Status",$status)->count();
        }
        return $this->count();
    }

    function GetTotalUpdateBirthDate(){
        return $this->where("UpdateBirthDateBy","!=", NULL)->count();
    }

    function GetTotalUpdateStatus(){
        return $this->where("UpdateStatusBy","!=", NULL)->count();
    }

    function GetStatusList(){
        return $this->select("Status")->distinct()->orderBy("Status", "ASC")->get();
    }

    function memberTable($data){
        $query = $this->select(
            "Id",
            "Pbno",
            "MemberId",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Branch",
            "Birthdate",
            "Status"
        );
        
        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
                $q->orWhere("Pbno", $search);
                $q->orWhere("MemberId", $search);
            });
        }

        $query = !empty($data->filterStatus) ? $query->where("Status", $data->filterStatus) : $query;
        $query = !empty($data->filterBranch) ? $query->where("Branch", $data->filterBranch) : $query;
        $query = $query->orderBy("Id", "ASC");
        return $query;
    }

    function AddMember($data){
        return $this->create($data);
    }

    function GetMember($id){
        return $this->find($id);
    }

    function UpdateMember($data){
        $var = (object) $data;
        $member = $this->find($var->Id);
        if($member->Birthdate != $var->Birthdate){
            $member->update([
                "UpdateBirthdateBy" => Auth::user()->Id,
                "UpdateBirthdate" => Carbon::now()
            ]);
        }
        $member->update($data);
    }

    function UpdateMemberStatus($data,$verified){
        $result = array();
        $result["status"] = "success";
        $var = (object) $data;
        $member = $this->find($var->Id);
                                                    
        if($member->Status != "MIGS" && $var->Status == "MIGS"){
            if($verified){
                $member->update([
                    "UpdateStatusBy" => Auth::user()->Id,
                    "UpdateStatus" => Carbon::now()
                ]);
                $data["Status"] = $var->Status;
            }else{
                $result["status"] = "failed";
                $result["message"] = "The member is not verified. Please proceed to 'Utility Verification' to verify the member.";
                $data["Status"] = $member->Status;
            }
        }      

        $member->update($data);
        return $result;
    }

    function updateContact($id, $contact){
        $this->find($id)->update(["Contact" => $contact]);
    }

    function GetMemberForVerification($filter,$idList){
        $result = array();
        if(!empty($idList)){
            $memberList = $this->select(
                "Id",
                "Pbno",
                "MemberId",
                DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
                "Branch",
                "Contact",
                "Status"
            )->whereIn("Id",$idList);

            if(!empty($filter->filterSearch)){
                $search = strtoupper(str_replace('ñ', 'Ñ', $filter->filterSearch));
                $memberList->where(function($q) use($search){
                    $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
                    $q->orWhere("Pbno", $search);
                    $q->orWhere("MemberId", $search);
                });
            }

            $memberList = !empty($filter->filterBranch) ? $memberList->where("Branch", $filter->filterBranch) : $memberList;
            $memberList = $memberList->get();
            if(!empty($memberList)){
                foreach($memberList as $member){
                    $result[$member->Id] = [
                        "Pbno" => $member->Pbno,
                        "MemberId" => $member->MemberId,
                        "Name" => $member->Name,
                        "Branch" => $member->Branch,
                        "Contact" => $member->Contact,
                        "Status" => $member->Status
                    ];
                }
            }
        }

        return $result;
    }

    function GetMemberIDs($data){
        return $this->whereIn("Id", $data)->get();
    }

    function memberVotedTable($data,$voterIdList){
        $query = $this->select(
            "Id",
            "Pbno",
            "MemberId",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Branch",
        );
        
        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
                $q->orWhere("Pbno", $search);
                $q->orWhere("MemberId", $search);
            });
        }

        $query = !empty($data->filterBranch) ? $query->where("Branch", $data->filterBranch) : $query;
        $query = !empty($voterIdList) ? $query->whereIn("Id", $voterIdList) : $query;
        $query = $query->orderBy("Id", "ASC");
        return $query;
    }

    function memberReceivedItems($voterIdList){
        $query = $this->select(
            "Id",
            "Pbno",
            "MemberId",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Branch",
        );
        
        $query = !empty($voterIdList) ? $query->whereIn("Id", $voterIdList) : $query;
        $query = $query->orderBy("Id", "ASC");
        return $query;
    }

    function electionMemberList($data){
        $users = DB::table("users")->where("UserType","!=","5")->get();
        $userList = array();
        foreach($users as $user){
            $userList[$user->Id] = strtoupper(str_replace('ñ', 'Ñ', $user->FirstName . " " . $user->LastName)); 
        }

        $voters = DB::table("votes")->select(
            "VoterId",
            "VoteF2F",
            "created_at AS DateVoted"
        );

        if(!empty($data->voteMethod)){
            $voteMethod = $data->voteMethod == "online" ? "NO" : "YES";
            $voters = $voters->where("VoteF2F", $voteMethod);
        }
        
        $voters = $voters->get();

        $voterList = array();
        foreach($voters as $voter){
            $voterList[$voter->VoterId] = [
                "VoteF2F" => $voter->VoteF2F == "NO" ? "ONLINE" : "FACE TO FACE",
                "DateVoted" => $voter->DateVoted,
            ];
        }

        $gaItems = DB::table("gaitems")->select(
            "VoterId",
            "RegisterBy AS IssuedBy",
            "Register AS DateReceived",
        )->get();

        $gaItemsList = array();
        foreach($gaItems as $gaItem){
            $gaItemsList[$gaItem->VoterId] = [
                "IssuedBy" => $userList[$gaItem->IssuedBy],
                "DateReceived" => $gaItem->DateReceived
            ];
        }

        $members = $this->select(
            "Id",
            "Pbno",
            "MemberId",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Birthdate",
            "Branch"
        )->where("Status", "MIGS")->get();

        $memberList = array();

        foreach($members as $member){
            $age = Carbon::parse($member->Birthdate)->age;
            $ageBracket = $age >= 60 ? "SENIOR" : "18-59 YEARS OLD";
            $memberList[] = [
                "pbno" => $member->Pbno,
                "memberId" => $member->MemberId,
                "name" => $member->Name,
                "birthdate" => date("m/d/Y", strtotime($member->Birthdate)),
                "age" => $age,
                "ageBracket" => $ageBracket, 
                "branch" => $member->Branch,
                "voteMethod" => isset($voterList[$member->Id]) ? $voterList[$member->Id]["VoteF2F"] : "",
                "dateVoted" => isset($voterList[$member->Id]) ? date("m/d/Y",strtotime($voterList[$member->Id]["DateVoted"])) : "",
                "issuedBy" => isset($gaItemsList[$member->Id]) ? $gaItemsList[$member->Id]["IssuedBy"] : "",
                "dateReceived" => isset($gaItemsList[$member->Id]) ? date("m/d/Y",strtotime($gaItemsList[$member->Id]["DateReceived"])) : ""
            ];
        }

        return $memberList;
    }
}
