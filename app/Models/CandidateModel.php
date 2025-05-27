<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CandidateModel extends Model
{
    use HasFactory;
    protected $table = 'candidates';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Picture',
        'FirstName',
        'MiddleName',
        'LastName',
        'Education',
        'Position'
    ];

    function dataTable($data){
        $query = $this->select(
            "Id",
            "Picture",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Education",
            "Position"
        );
        
        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
            });
        }

        $query = !empty($data->filterPosition) ? $query->where("Position", $data->filterPosition) : $query;
        $query = $query->orderBy("Id", "ASC");
        
        return $query;
    }

    function AddUpdateCandidate($data){
        $candidate = [
            "FirstName" => strtoupper(str_replace('ñ', 'Ñ', $data->FirstName)),
            "MiddleName" => !empty($data->MiddleName) ? strtoupper(str_replace('ñ', 'Ñ', $data->MiddleName)) : NULL,
            "LastName" => strtoupper(str_replace('ñ', 'Ñ', $data->LastName)),
            "Position" => $data->Position,
            "Education" => $data->Education
        ];

        if(isset($data->Id) && !empty($data->Id)){
            if(!empty($data->file('file'))){
                $candidate["Picture"] = file_get_contents($data->file('file')->getRealPath()); 
            }
            $this->find($data->Id)->update($candidate);
        }else{
            $candidate["Picture"] = file_get_contents($data->file('file')->getRealPath());
            $this->create($candidate);    
        }
    }

    function GetCandidate($id){
        $candidate = $this->find($id);

        return [
            "Picture" => "data:image/jpeg;base64," . base64_encode($candidate->Picture),
            "FirstName" => $candidate->FirstName,
            "MiddleName" => $candidate->MiddleName,
            "LastName" => $candidate->LastName,
            "Position" => $candidate->Position,
            "Education" => $candidate->Education
        ];
    }

    function GetAllCandidate(){
        $candidates = $this->get(); 
        $candidateList = array();
        foreach($candidates as $candidate){
            $candidateList[] = [
                "Id" => $candidate->Id,
                "Picture" => "data:image/jpeg;base64," . base64_encode($candidate->Picture),
                "FirstName" => $candidate->FirstName,
                "MiddleName" => $candidate->MiddleName,
                "LastName" => $candidate->LastName,
                "Education" => $candidate->Education,
                "Position" => $candidate->Position
            ]; 
        }
        return $candidateList;
    }
}
