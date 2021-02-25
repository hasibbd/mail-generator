<?php

namespace App\Exports;

use App\Models\GenMail;
use Maatwebsite\Excel\Concerns\FromArray;

class UsersExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        if (session('type') == 2){
            $total = GenMail::where('cus_id',session('user_id'))->get();
        }else{
            $total = GenMail::all();
        }

        $gen=[];
        $s =1;
        foreach ($total as $t){
            if ($t->posted_time != null){
                $tt = $t->posted_time;
            }else{
                $tt = null;
            }
            $gen[]=[
                'sl'=> $s++,
                'main_mail' => $t->target_mail.'@'.$t->target_provider,
                'gen_mail' => $t->gen_mail.'@'.$t->target_provider,
                'posted' => $tt,
            ];
        }

        return $gen;
    }
}
