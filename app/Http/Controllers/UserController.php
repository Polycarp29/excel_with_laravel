<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\Facades\DataTables; 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Maatwebsite\Excel\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    protected $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('users');
    }

    public function export()
    {
        return $this->excel->download(new UsersExport, 'users.xlsx');
    }
}
