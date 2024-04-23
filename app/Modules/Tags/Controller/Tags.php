<?php

namespace App\Modules\Tags\Controller;

use App\Controllers\BaseController;

class Tags extends BaseController
{
    function index()
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();

        echo view('App\Modules\Tags\Views\index', [
            'tags' => $tagsModel->paginate(10),
            'pager'=> $tagsModel->pager
        ]);
    }

    function show($id)
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();

        echo view('App\Modules\Tags\Views\show', [
            'tag' => $tagsModel->find($id)
        ]);
    }

    function new()
    {
        echo view('App\Modules\Tags\Views\new', ['name' => '']);
    }

    function edit($id)
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();

        echo view('App\Modules\Tags\Views\edit', [
            'tag' => $tagsModel->find($id)
        ]);
    }

    function create()
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();
        if ($this->validate('tags')) {

            $tagsModel->insert([
                'name' => $this->request->getPost('name')
            ]);
            return redirect()->back()->with('message', 'Registro creado correctamente');
        } else {
            session()->setFlashdata('validation', $this->validator);

            return redirect()->back()->withInput();
        }

    }

    function update($id)
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();

        if ($this->validate('tags')) {
            $tagsModel->update($id, [
                'name' => $this->request->getPost('name')
            ]);
            return redirect()->back()->with('message', 'Registro actualizado correctamente');
        } else {
            session()->setFlashdata('validation', $this->validator);

            return redirect()->back()->withInput();
        }
    }

    function delete($id)
    {
        $tagsModel = new \App\Modules\Tags\Models\Tags();
        $tagsModel->delete($id);
        return redirect()->back()->with('message', 'Registro borrado correctamente');

    }
}