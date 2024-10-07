<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $client = new Client();
        $url = "http://localhost:8000/api/buku";
        $response = $client->request("GET", $url);
        $content =  $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        // print_r($data);

        return view('buku.index', ['data' => $data]);
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
        $judul = $request->judul;
        $pengarang = $request->pengarang;
        $tanggal_publikasi = $request->tanggal_publikasi;

        $payload = [

            "judul" => $judul,
            "pengarang" => $pengarang,
            "tanggal_publikasi" => $tanggal_publikasi,

        ];

        $client = new Client();
        $url = "http://localhost:8000/api/buku";
        $response = $client->request("POST", $url, [
            'headers'=>['Content-type'=>'application/json'],
            'body' => json_encode($payload),
        ]);

        $content =  $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error);
        }else{
            return redirect()->to('buku');
        }

        // return view('buku.index', ['data' => $data]);

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

        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request("GET", $url);
        $content =  $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['message'];

            return redirect()->to('buku')->withErrors($error);
        }else{
            $data = $contentArray['data'];
            return view('buku.index', ['data' => $data]);
        }
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

        $judul = $request->judul;
        $pengarang = $request->pengarang;
        $tanggal_publikasi = $request->tanggal_publikasi;

        $payload = [

            "judul" => $judul,
            "pengarang" => $pengarang,
            "tanggal_publikasi" => $tanggal_publikasi,

        ];

        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request("PUT", $url, [
            'headers'=>['Content-type'=>'application/json'],
            'body' => json_encode($payload),
        ]);

        $content =  $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error);
        }else{
            return redirect()->to('buku');
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
        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request("DELETE", $url);

        $content =  $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error);
        }else{
            return redirect()->to('buku');
        }
    }
}
