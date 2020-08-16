<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Redirect,Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cpf'=>'required',
            'name'=>'required',
            'age'=>'required',
            'whatsapp'=>'required',
            'image' =>'required'
        ]);

        $contactId = $request->contact_id;
        $cpf = $request->get('cpf');

        if(Contact::where('cpf', $cpf)->exists()){
            return redirect('/contacts')->with('error', 'Usuário já existe!');
        } else {
            if(empty($contactId)) {
                $contact = new Contact([
                    'cpf' => $request->get('cpf'),
                    'name' => $request->get('name'),
                    'age' => $request->get('age'),
                    'whatsapp' => $request->get('whatsapp'),
                    'image' => $request->get('image')
                ]);
                $contact->save();
                return redirect('/contacts')->with('success', 'Usuário gravado com sucesso!');
            }
            else {
                $contact = Contact::find($contactId);
                $contact->cpf =  $request->get('cpf');
                $contact->name = $request->get('name');
                $contact->age = $request->get('age');
                $contact->whatsapp = $request->get('whatsapp');
                $contact->image = $request->get('image');
                $contact->save();
        
                return redirect('/contacts')->with('success', 'Usuário atualizado!');
            }
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
		$where = array('id' => $id);
		$contact = Contact::where($where)->first();
		return Response::json($contact); 
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
        $contact = Contact::find($id);
        $contact->delete();

        return redirect('/contacts')->with('success', 'Usuário deletado!');
    }
}
