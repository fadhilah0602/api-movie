<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
// use App\Http\Controllers\API\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movie=Movie::all();
        return response()->json($movie);
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
        $validasi=$request->validate([
            'title'=>'required',
            'description'=>'required',
            'rating'=>'required',
            'image'=>'required|file|mimes:png,jpg'
        ]);
        try{
            $fileName = time().$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/movies',$fileName);
            $validasi['image']=$path;
            $response = Movie::create($validasi);
            return response()->json([
                'succes'=> true,
                'message'=> 'Movie Created',
                'data'=>$response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Error',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        $response = [
            'message' => 'Detail of Movie resource',
            'data' => $movie
        ];
        return response()->json($response, Response::HTTP_OK);
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
        $validasi=$request->validate([
            'title'=>'required',
            'description'=>'required',
            'rating'=>'required',
            'image'=>'required|file|mimes:png,jpg'
        ]);
        try{
            if($request->file('image')) {
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('uploads/movies',$fileName);
                $validasi['image']=$path;
            }
            $response = Movie::find($id);
            $response->update($validasi);
            return response()->json([
                'succes'=> true,
                'message'=> 'Movie Updated',
                'data'=>$response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Error',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $movie=Movie::find($id);
            $movie->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Movie Deleted'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'message'=>'Error',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
