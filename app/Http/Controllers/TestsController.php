<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Code;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            '1',
            '2',
            '3',
            [
                'a' => '333',
                ['b' => '111']
            ]
        ];

        $result = $this->recursion($data);
        dump($result);

    }


//    public function fetchArr($data)
//    {
//        if () {}
//    }

    public function recursion($data)
    {
        static $res = [];
        foreach ($data as $k => $v) {

            if (is_array($v)) {
                $this->recursion($v);
            } else {
                $res[] = (int)$v;
            }
        }

        return $res;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
