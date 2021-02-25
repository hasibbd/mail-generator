<?php

namespace App\Http\Controllers;

use App\Models\GenMail;
use Carbon\Carbon;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function Login(){
        return view('login');
    }

    public function UserDashBoard()
    {
        session(['page'=> 'udas']);
        $gen = GenMail::where('cus_id',session('user_id'))->get();
        return view('user.dashboard.dash',compact('gen'));
    }

    public function MailList()
    {
        session(['page'=> 'mlist']);
        $gen = GenMail::where('cus_id', session('user_id'))->get();
        return view('user.mail-list.list', compact('gen'));
    }

    public function MailGenerate()
    {
        session(['page'=> 'mgen']);
        return view('user.mail-list.mail');
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

        $check = GenMail::where('cus_id',session('user_id'))->count();
        if ($check > 0){
            return back()->withErrors(['The limit is over ...']);
        }
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
                    'cus_id' => session('user_id'),
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
    public function MailPost($id){
        GenMail::find($id)->update([
            'posted_time' => Carbon::today(),
        ]);
        return redirect('mail-list');
    }
    public function LogOut(){
        session()->flush();
        return redirect()->route('login')->with('msg','<div class="alert alert-primary" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Thank You! </strong> See you soon...
                        </div>');
    }


}
