<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class TicketsModel extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Id',
        'VoterId',
    ];

    function CreateTicket($voterId){
        $memberCheck = $this->where("VoterId", $voterId)->first();
        if(empty($memberCheck)){
            return $this->create([
                "VoterId" => $voterId
            ]);
        }
    }

    function GetTicketNo($voterId){
        $ticketNo = "";
        $ticket = $this->where("VoterId",$voterId)->first();

        if(!empty($ticket)){
            $ticketNo = "ON-".sprintf('%05d', $ticket->Id);
        }

        return $ticketNo;
    }

    function dataTable($data){
        $query = $this->select(
            "tickets.Id AS ticketNo",
            "voters.Pbno",
            "voters.MemberId",
            DB::raw("CONCAT(COALESCE(voters.FirstName, ''), ' ', COALESCE(voters.MiddleName, ''), ' ', COALESCE(voters.LastName, '')) AS Name"),
            "voters.Branch",
            "tickets.created_at AS DateTime",
            "voters.Contact",
            "tickets.VoterId"
        )->join("voters","voters.Id","tickets.VoterId");

        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(voters.FirstName, ''), ' ', COALESCE(voters.MiddleName, ''), ' ', COALESCE(voters.LastName, '')) LIKE '%".$search."%'");
            });
        }
        
        $query = !empty($data->filterBranch) ? $query->where("voters.Branch", $data->filterBranch) : $query;
        $query = !empty($data->DateTimeFrom) ? $query->where("tickets.created_at",">=",$data->DateTimeFrom) : $query;
        $query = !empty($data->DateTimeTo) ? $query->where("tickets.created_at","<=",$data->DateTimeTo) : $query;
        
        $query = $query->orderBy("tickets.Id", "ASC");
        
        return $query;
    }
}
