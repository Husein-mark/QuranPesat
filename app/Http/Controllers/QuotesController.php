<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('https://dummyjson.com/quotes');
        $singleQuote = null;
        $author = null;
        $quoteList = [];
        $totalQuotes = 0;

        if ($response->successful()){
            $data = $response->json();
            $quoteList = $data['quotes'] ?? [];
            $totalQuotes = $data['total'] ?? count($quoteList);
            if (!empty($quoteList)) {
                $singleQuote = $quoteList[array_rand($quoteList)];
                $author = $singleQuote['author'];
            }
        }

        // Ambil 3 quote pilihan lain untuk section rekomendasi/eksplorasi
        $featured = [];
        if (count($quoteList) > 3) {
            $randomKeys = array_rand($quoteList, 3);
            foreach ($randomKeys as $key) {
                $featured[] = $quoteList[$key];
            }
        }

        return view('welcome', [
            'quotes' => $singleQuote,
            'author' => $author,
            'featured' => $featured,
            'totalQuotes' => $totalQuotes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
