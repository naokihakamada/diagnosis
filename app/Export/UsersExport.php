<?php

namespace App\Export;

use App\Model\UserResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = DB::table('user_results')
        ->select(
            'id',
            'name',
            'email',
            'access_id',
            'alias',
            'my_type'
        )
        ->whereNotNull("email")->get();

        //dd($users);
        
        return $users;
    }

    public function headings(): array
    {
        return [
            "DB-id",
            "名前",
            "メールアドレス",
            "アクセスID",
            "診断エイリアス",
            "診断結果タイプ",
        ];
    }

    //ダウンロードの実行、現時点でのファイル保存
    public function downloadNow()
    {
        //現時点での保存
        $filename = $this->store_xls_fileNow();

        //ダウンロード実行する
        return $this->download($filename);
    }

    //現時点でのファイル保存
    public function store_xls_fileNow()
    {
        //現在の日付をつけたファイル名
        $filename = sprintf("users-%s-%s.xlsx", Carbon::now()->format('YmdHis'), Carbon::now()->timestamp);

        // 保存
        $this->store_xls_file($filename);

        return $filename;
    }

    //xlsファイル保存
    public function store_xls_file($filename)
    {
        // storage/app/に保存
        Excel::store($this, $filename, "download");
    }

    //ダウンロード処理
    public function download($filename)
    {
        return Excel::download($this, $filename);
    }
}
