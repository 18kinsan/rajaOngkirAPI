<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Province;
use App\City;

class PageController extends Controller
{
    public function index(){
        return "halaman index";
    }

    public function getprovince(){
        $client = new Client();

        try{
            $response = $client->get('https://api.rajaongkir.com/starter/province',
            array(
                'headers' => array(
                    'key' => '917953838612adc75f0e7f41e5e13b49',
                )
            )
                );
        }catch(RequestException $e){
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        // print_r($array_result);
        // echo $array_result["rajaongkir"]["results"][1]["province"];
        for($i = 0; $i < count($array_result["rajaongkir"]["results"]); $i++)
        {
            $province = new \App\Province;
            $province->id = $array_result["rajaongkir"]["results"][$i]["province_id"];
            $province->name = $array_result["rajaongkir"]["results"][$i]["province"];
            $province->save();
        }
    
    }

    public function getcity(){
        $client = new Client();

        try{
            $response = $client->get('https://api.rajaongkir.com/starter/city',
            array(
                'headers' => array(
                    'key' => '917953838612adc75f0e7f41e5e13b49',
                )
            )
                );
        }catch(RequestException $e){
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        // print_r($array_result);
        // echo $array_result["rajaongkir"]["results"][1]["city_name"];
        for($i = 0; $i < count($array_result["rajaongkir"]["results"]); $i++)
        {
            $city = new \App\City;
            $city->id = $array_result["rajaongkir"]["results"][$i]["city_id"];
            $city->name = $array_result["rajaongkir"]["results"][$i]["city_name"];
            $city->id_province = $array_result["rajaongkir"]["results"][$i]["province_id"];
            $city->save();
        }
    }

    public function cek(){
        $title = "Cek Ongkos Kirim";
        $city = \App\City::get();

        return view('jne.cek', compact('title', 'city'));
    }

    public function proses(Request $request){
        $title = "Cek Ongkos Kirim";
        $client = new Client();

        try{
            $response = $client->request('POST', 'https://api.rajaongkir.com/starter/cost',
            [
                'body' => 'origin='.$request->origin.'&destination='.$request->destination.'&weight='.$request->weight.'&courier=jne',
                'headers' =>[
                    'key' => '917953838612adc75f0e7f41e5e13b49',
                    'content-type' => 'application/x-www-form-urlencoded',
                ]
            ]
        );
        }catch(RequestException $e){
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        $origin = $array_result["rajaongkir"]["origin_details"]["city_name"];
        $destination = $array_result["rajaongkir"]["destination_details"]["city_name"];

        // print_r($array_result);
        // echo $array_result["rajaongkir"]["results"][1]["city_name"];
        return view('jne.cek-result', compact('title', 'origin', 'destination', 'array_result'));
    }
}
