<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionsModel extends Model
{
    use HasFactory;
    protected $table = 'positions';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'PositionLevel',
        'Description',
        'VoteLimit'
    ];

    function dataTable($data){
        $query = $this->select(
            "Id",
            "PositionLevel",
            "Description",
            "VoteLimit"
        );
        
        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("Description LIKE '%".$search."%'");
            });
        }

        $query = $query->orderBy("PositionLevel", "ASC");
        
        return $query;
    }

    function AddUpdatePosition($data){
        $var = (object) $data;
        $result = array();
        $result["status"] = "success";
        unset($data["Id"]);

        if(isset($var->Id) && !empty($var->Id)){
            $this->find($var->Id)->update($data);
        }else{
            $canSave = $this->where("PositionLevel", $var->PositionLevel)->count();
            if($canSave > 0){
                $result["status"] = "failed";
            }else{
                $this->create($data);
            }           

        }

        return $result;
    }

    function GetPosition($id){
        return $this->find($id);
    }

    function GetPositionList(){
        return $this->orderBy("PositionLevel","ASC")->get();
    }
}
