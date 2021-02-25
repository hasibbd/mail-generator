<?php

namespace App\Http\Controllers;

use App\Models\GenMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{


    public function AdminDashBoard()
    {
        session(['page'=> 'adas']);
        $gen = GenMail::all();
        return view('admin.dashboard.dash',compact('gen'));
    }

    public function MailList(){
        session(['page'=>'mlist']);
        return view('admin.mail-list.list');
    }
    public function MailListData()
    {
        session(['page'=> 'mlist']);
        $gen = DB::table('gen_mails')
            ->join('users', 'gen_mails.cus_id','=', 'users.user_id')
            ->orderBy('gen_mails.posted_time', 'ASC')
            ->select('gen_mails.*','users.name')
            ->get();

        $data =[];
        foreach ($gen as $g){
            if ($g->posted_time){
               $date = date("jS F Y", strtotime($g->posted_time));
            }else{
                $date =null;
            }
            array_push($data,[
                'id'=>$g->id,
                'name'=>$g->name,
                'target_mail'=>$g->target_mail.'@'.$g->target_provider,
                'gen_mail'=>$g->gen_mail.'@'.$g->target_provider,
                'posted_time'=> $date,
            ]);
        }

        $data_table_render= DataTables::of($data)
        /*    ->addColumn('action',function ($row){
                $edit_url=url('/test/edit/'.$row['id']);
                return '<a href="'.$edit_url.'" class="btn btn-info btn-xs">Edit</a>'."&nbsp&nbsp;".
                    '<button onClick="deleteTestData('.$row['id'].');" class="btn btn-danger btn-xs">Delete</button>';
            })*/

            ->addIndexColumn()
            ->make(true);

        return $data_table_render;
    }
}
