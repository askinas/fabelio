<?php

namespace App\Http\Controllers;

use App\Fabelio;
use App\Price;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FabelioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage and display it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Fabelio $fabelio, Price $price, Request $request)
    {   
        $input = $request->all();

        $client = new Client();
        $crawler = $client->request('GET', $input['url']);

        $content['title'] = $crawler->filter('div .page-title-wrapper h1')->first()->text();
        $content['price'] = $crawler->filter('span .price')->first()->text();
        $content['images'] = $crawler->filter('[property="og:image"]')->first()->attr('content');
        $content['description'] = $crawler->filter('div #description')->first()->text();

        $item = $fabelio->firstOrCreate(
            ['url' => trim($input['url'])],
            ['title' => $content['title'], 'images' => $content['images'], 'description' => $content['description']]
        );

        try {
            $price->where('fabelio_id', $item->id)
                  ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime("-1hour")))
                  ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $price->fabelio_id = $item->id;
            $price->price = $content['price'];
            $price->save();
        }

        $content['prices'] = $price->get();
        return view('detail', $content );
    }

    /**
     * Display the list.
     *
     * @param  \App\Fabelio  $fabelio
     * @return \Illuminate\Http\Response
     */
    public function lists(Fabelio $fabelio)
    {
        $lists = $fabelio->get();
        return view('lists', [ 'lists'=> $lists]);
    }
}
