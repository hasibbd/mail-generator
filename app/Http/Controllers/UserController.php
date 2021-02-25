<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\GenMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    public function UserList(Request $request)
    {
        $users = User::all();
        session(['page'=> 'use']);
        return view('admin.users.list',compact('users'));
    }
    public function MailListDataUser()
    {
        $gen = GenMail::where('cus_id',session('user_id'))->orderBy('posted_time', 'ASC')->get();

        $data =[];
        foreach ($gen as $g){
            if ($g->posted_time){
                $date = date("jS F Y", strtotime($g->posted_time));
            }else{
                $date =null;
            }
            array_push($data,[
                'id'=>$g->id,
                'cus_id'=>$g->cus_id,
                'target_mail'=>$g->target_mail.'@'.$g->target_provider,
                'gen_mail'=>$g->gen_mail.'@'.$g->target_provider,
                'posted_time'=> $date,
            ]);
        }

        $data_table_render= DataTables::of($data)
            ->addColumn('action',function ($row){
                $edit_url=url('post/'.$row['id']);
                $val = $row['gen_mail'];
                return '<a href="'.$edit_url.'" class="btn btn-info btn-sm">Post</a>'."&nbsp&nbsp;".'<input type="hidden" value="'.$val.'"  id="C'.$row['id'].'">'.
                    '<button onclick="MyFunx('.$row['id'].')" class="btn btn-danger btn-sm copy" >Copy</button>';
            })

            ->addIndexColumn()
            ->make(true);

        return $data_table_render;
    }

    public function UserAdd(Request $request)
    {
        session(['page'=> 'use']);
        $res = User::create([
            'user_id' => rand(1000, 999999),
            'name' => $request->name,
            'password' => $request->password,
            'email' => $request->email,
            'type' => $request->type,
        ]);

        return response()->json([
            $res
        ], 200);
    }
    public  function MailGenerate(){
        session(['page'=>'gen']);
        $users = User::all();
        return view('admin.mail-list.mail', compact('users'));
    }
    public function ThreeDot($email)
    {
        $gen = [];
        $len = strlen($email) + 2;
        $i = 1;
        while ($i < $len) {
            $email2 = substr_replace($email, ".", $i, 0);
            $i2 = $i + 2;
            while ($i2 < $len) {
                $email3 = substr_replace($email2, ".", $i2, 0);
                $i3 = $i2 + 2;
                while ($i3 < $len) {
                    $email4 = substr_replace($email3, ".", $i3, 0);
                    array_push($gen, ['gen_mail' => $email4]);
                    $i3++;
                }
                $i2++;
            }
            $i++;
        }
        return $gen;
    }

    public function TwoDot($email)
    {
        $gen = [];
        $len = strlen($email) + 1;
        $i = 1;
        while ($i < $len) {
            $email2 = substr_replace($email, ".", $i, 0);
            $i2 = $i + 2;
            while ($i2 < $len) {
                $email3 = substr_replace($email2, ".", $i2, 0);
                $i3 = $i2 + 2;
                array_push($gen, ['gen_mail' => $email3]);
                $i2++;
            }
            $i++;
        }
        return $gen;
    }

    public function OneDot($email)
    {
        $gen = [];
        $len = strlen($email);
        $i = 1;
        while ($i < $len) {
            $email2 = substr_replace($email, ".", $i, 0);
            $i2 = $i + 2;
            array_push($gen, ['gen_mail' => $email2]);
            $i++;
        }
        return $gen;
    }

    public function MailGen(Request $request)
    {
        dd($request);

        $da = GenMail::where('target_mail',$request->email)->count();
        if ($da > 0){
            return back()->withErrors(['This mail used']);
        }
        $len = strlen(str_replace(".", "",$request->email));

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['Please remove the email provider extension']);
        }
        if ($request->number_dot == 1 && $len < 2) {
            return back()->withErrors(['Please use minimum 2 character for target mail']);
        }
        if ($request->number_dot == 2 && $len < 3) {
            return back()->withErrors(['Please use minimum 3 character for target mail']);
        }
        if ($request->number_dot == 3 && $len < 4) {
            return back()->withErrors(['Please use minimum 4 character for target mail']);
        }


        switch ($request->number_dot) {
            case "3":
                $res = $this->ThreeDot(str_replace(".", "",$request->email));

                break;
            case "2":
                $res = $this->TwoDot(str_replace(".", "",$request->email));
                break;
            case "1":
                $res = $this->OneDot(str_replace(".", "",$request->email));
                break;
            default:
                return back()->withErrors(['Number of dot should not over 3.']);

        }
        if ($res) {
            $data = [];
            foreach ($res as $r) {
                $data[] = [
                    'cus_id' => $request->user,
                    'recover_mail' => $request->recovery_email,
                    'password' => $request->password,
                    'target_dot' => $request->number_dot,
                    'gen_mail' => $r['gen_mail'],
                    'posted_time' => null,
                    'target_mail' => $request->email,
                    'target_provider' => $request->provider,
                ];
            }
            $results = GenMail::insert($data);
            if ($results) {
                return back()->withErrors(['msg' => count($res) . ' mail generated']);
            } else {
                return back()->withErrors(['Something error']);
            }
        } else {
            return back()->withErrors(['Not Found']);
        }
    }
    public function ExportExcel(){
        return Excel::download(new UsersExport, Carbon::today().'.xlsx');
    }
}
