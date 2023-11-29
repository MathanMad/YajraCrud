<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    public function index(){
        $data=Test::get();
        return view('index', compact('data'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required'
        ]);

        $stored=Test::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile
        ]);

        return response()->json(["message"=>"successfully created","data"=>$stored],200);
    }

    public function edit($id){
        $data = Test::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required'
        ]);

        $stored=Test::where('id',$request->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile
        ]);

        return response()->json(["message"=>"successfully updated","data"=>$stored],200);
    }

    public function delete($id){
        $deleted=Test::where('id',$id)->delete();
        return response()->json(["message"=>"successfully deleted","data"=>$deleted],200);
    }

    public function fetch_data(Request $request){
        if($request->ajax()){
            $data=Test::get();
            return DataTables::of($data)
            // ->addColumn('id', function($row){
            //     return $row->id;})
            ->addColumn('action', function($row){
                $actionBtn='<button type="button" class="btn btn-primary Edit"  data-id="'.$row->id.'">Edit</button>
                <button type="button" class="btn btn-danger Delete"  data-id="'.$row->id.'">Delete</button>';
                return $actionBtn;
            })

            ->Make(true);
        }
    }
}
