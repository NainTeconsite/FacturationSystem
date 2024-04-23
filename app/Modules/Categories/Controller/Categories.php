<?php

namespace App\Modules\Categories\Controller;

use App\Controllers\BaseController;

class Categories extends BaseController
{
    function index()
    {
        $categoriesModel = new \App\Modules\Categories\Models\Categories();

        echo view('App\Modules\Categories\Views\index', [
            'categorias' => $categoriesModel->paginate(10),
            'pager'=> $categoriesModel->pager
        ]);
    }

    function show($id)
    {
        $categoriesModel = new \App\Modules\Categories\Models\Categories();

        echo view('App\Modules\Categories\Views\show', [
            'categoria' => $categoriesModel->find($id)
        ]);
    }

    function new()
    {
        echo view('App\Modules\Categories\Views\new', ['name' => '']);
    }

    function edit($id)
    {
        $categoriesModel = new \App\Modules\Categories\Models\Categories();

        echo view('App\Modules\Categories\Views\edit', [
            'categoria' => $categoriesModel->find($id)
        ]);
    }

    function create()
    {
        $categoriesModel = new \App\Modules\Categories\Models\Categories();
        if ($this->validate('categories')) {

            $categoriesModel->insert([
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
        $categoriesModel = new \App\Modules\Categories\Models\Categories();

        if ($this->validate('categories')) {
            $categoriesModel->update($id, [
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
        $categoriesModel = new \App\Modules\Categories\Models\Categories();
        $categoriesModel->delete($id);
        return redirect()->back()->with('message', 'Registro borrado correctamente');

    }
}