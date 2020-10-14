<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Title as Title;
use App\Client as Client;

class ClientController extends Controller
{
    //
    public function __construct( Title $titles, Client $client)
    {   
        $this->titles = $titles->all();

        //accessing the datas in table and storing it variable/object
        $this->client = $client;
    }

    public function di()
    {
        dd($this->titles);
    }

    public function index()
    {
        $data = [];

        $data['clients'] = $this->client->all();
        
        return view('client/index', $data);
    }

    public function export()
    {
        $data = [];

        $data['clients'] = $this->client->all();
        header('Content-Disposition: attachment;filename=export.xls');
        return view('client/export', $data);
    }


    //2 routes will call this method for modify and create clients
    public function newClient( Request $request, Client $client)
    {
        $data = [];

        //storing each html input value into $data array
        $data['title'] = $request->input('title');
        $data['name'] = $request->input('name');
        $data['last_name'] = $request->input('last_name');
        $data['address'] = $request->input('address');
        $data['zip_code'] = $request->input('zip_code');
        $data['city'] = $request->input('city');
        $data['state'] = $request->input('state');
        $data['email'] = $request->input('email');

        

        
        if( $request->isMethod('post'))//if the call is using the post it is a create client
        {
            //dd($data);


            //code for form save
            $this->validate(
                $request,
                [
                    //form validation
                    'name' => 'required|min:5',
                    'last_name' => 'required',
                    'address' => 'required',
                    'zip_code' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'email' => 'required',
                ]
            );

            $client->insert($data);//inserting data after the form is validated

            return redirect('clients');//return to index.blade.php if the form is succesfully saved
        }

        $data['titles'] = $this->titles;//seding options in title select box
        $data['modify'] = 0;
        return view('client/form', $data);
    }

    public function create()
    {
            return view('client/create');
    }

    public function show($client_id, Request $request)
    {
        $data = []; 
        $data['client_id'] = $client_id;

        $data['titles'] = $this->titles;
        $data['modify'] = 1;

        $client_data = $this->client->find($client_id);

        $data['name'] = $client_data->name;
        $data['last_name'] = $client_data->last_name;
        $data['address'] = $client_data->address;
        $data['zip_code'] = $client_data->zip_code;
        $data['city'] = $client_data->city;
        $data['state'] = $client_data->state;
        $data['email'] = $client_data->email;


        //stroing values in session variable
        $request->session()->put('last_updated', $client_data->name . ' ' . 
        $client_data->last_name);

        return view('client/form', $data);
    }

    public function modify( Request $request, $client_id, Client $client)
    {
        $data = [];

        //storing each html input value into $data array
        $data['title'] = $request->input('title');
        $data['name'] = $request->input('name');
        $data['last_name'] = $request->input('last_name');
        $data['address'] = $request->input('address');
        $data['zip_code'] = $request->input('zip_code');
        $data['city'] = $request->input('city');
        $data['state'] = $request->input('state');
        $data['email'] = $request->input('email');

        

        
        if( $request->isMethod('post'))//if the call is using the post it is a create client
        {
            //dd($data);


            //code for form save
            $this->validate(
                $request,
                [
                    //form validation
                    'name' => 'required|min:5',
                    'last_name' => 'required',
                    'address' => 'required',
                    'zip_code' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'email' => 'required',
                ]
            );

            $client_data = $this->client->find($client_id);

            $client_data->title = $request->input('title');
            $client_data->name = $request->input('name');
            $client_data->last_name = $request->input('last_name');
            $client_data->address = $request->input('address');
            $client_data->zip_code = $request->input('zip_code');
            $client_data->city = $request->input('city');
            $client_data->state = $request->input('state');
            $client_data->email = $request->input('email');

            $client_data->save();//update data

            return redirect('clients');//return to index.blade.php if the form is succesfully saved
        }

        $data['titles'] = $this->titles;//seding options in title select box
        //$data['modify'] = 0;

        return view('client/form', $data);
    }

}
