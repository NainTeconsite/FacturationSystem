<?php

namespace App\Modules\Products\Controller;

use App\Controllers\BaseController;
use App\Modules\Categories\Models\Categories;
use App\Modules\ProductsControl\Models\ProductsControl;
use App\Modules\ProductTag\Models\ProductTag;
use App\Modules\ProductUserControl\Models\ProductUserControl;
use App\Modules\Tags\Models\Tags;
use App\Modules\Users\Models\Users;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use Dompdf\Dompdf;

class products extends BaseController
{
    use ResponseTrait;
    public function demoPDF($id)
    {
        $productModel = new \App\Modules\Products\Models\Products();
        $product = $productModel->find($id);
        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $trace = $productModel->select('pc.*,u.email, puc.description, puc.direction, puc.created_at')
            ->join('products_control as pc', 'pc.productid = products.productid')
            ->join('users as u', 'u.userid = pc.userid')
            ->join('products_users_control as puc', 'puc.products_controlid= pc.products_controlid')
            ->where('products.productid =', $id);
        $data = [
            'product' => $product,
            'trace' => $trace->findAll(),

        ];
        $dompdf = new Dompdf();
        $dompdf->load_html(
            view(
                'App\Modules\Products\Views\trace_pdf',
                $data
            )
        );
        // $dompdf->load_html('hello world');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();



    }

    function index()
    {
        $productsModel = new \App\Modules\Products\Models\Products();
        $usersModel = new Users();
        $tagsModel = new Tags();
        $categoryModel = new Categories();
        $category = '';
        $tag = [];
        if ($this->request->getGet('categoryid')) {
            $category = $this->request->getGet('categoryid');
            $productsModel->where('categoryid', $category);
        }
        if ($this->request->getGet('tagid')) {
            $tag = $this->request->getGet('tagid');
            log_message('debug', json_encode($tag));
            if($tag != [""]){
                $productsModel
                ->distinct()
                ->select('products.*') 
                ->join('product_tag as pt', 'pt.productid = products.productid')
                ->join('tags as t', 't.tagid = pt.tagid')
                ->whereIn('t.tagid', $tag);
            }
        }
        echo view('App\Modules\Products\Views\index', [
            'products' => $productsModel->paginate(10),
            'users' => $usersModel->where('type =', 'customer')->findAll(),
            'categories' => $categoryModel->findAll(),
            'category' => $category,
            'tags' => $tagsModel->findAll(),
            'tag' => $tag,
            'pager' => $productsModel->pager
        ]);
    }

    public function trace($id)
    {
        $productModel = new \App\Modules\Products\Models\Products();
        $userModel = new Users();
        $product = $productModel->find($id);
        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        // log_message('debug', $this->request->getGet('type')?$this->request->getGet('type'): '');

        $trace = $productModel->select('pc.*,u.email, puc.description, puc.direction, puc.created_at')
            ->join('products_control as pc', 'pc.productid = products.productid')
            ->join('users as u', 'u.userid = pc.userid')
            ->join('products_users_control as puc', 'puc.products_controlid= pc.products_controlid')
            ->where('products.productid =', $id);

        if ($type = $this->request->getGet('type')) {
            $trace = $trace->where('pc.type =', $type);
        }

        if ($type == 'exit') {
            $users = $userModel->where('type', 'customer')->findAll();
        } else if ($type == 'entry') {
            $users = $userModel->where('type', 'salesman')->findAll();
        } else {
            $users = $userModel->findAll();
        }

        if ($userid = $this->request->getGet('user_id')) {
            $trace = $trace->where('pc.userid =', $userid);
        }
        $min = 0;
        $max = 0;
        if ($this->request->getGet('check_can')) {
            $min = $this->request->getGet('min_can');
            $max = $this->request->getGet('max_can');
            $trace = $trace->where('pc.count <=', $this->request->getGet('max_can'));
            $trace = $trace->where('pc.count >=', $this->request->getGet('min_can'));
        }
        $searchs = explode(' ', trim($this->request->getGet('search')));
        if ($this->request->getGet('search')) {
            $trace->GroupStart();
            foreach ($searchs as $key) {
                $trace->orLike('u.username', $key)
                    ->orLike('u.email', $key);
            }
            $trace->groupEnd();
        }
        $data = [
            'product' => $product,
            'trace' => $trace->findAll(),
            'type' => $type,
            'min' => $min,
            'max' => $max,
            'search' => $this->request->getGet('search'),
            'users' => $users,
            'user' => $userid,
        ];
        // log_message('debug', json_encode($data));
        echo view(
            'App\Modules\Products\Views\trace',
            $data
        );
    }

    function show($id)
    {
        $productsModel = new \App\Modules\Products\Models\Products();

        echo view('App\Modules\Products\Views\show', [
            'product' => $productsModel->find($id)
        ]);
    }

    function new()
    {
        $categoryModel = new Categories();
        $tagModel = new Tags();

        echo view('App\Modules\Products\Views\new', [
            'categories' => $categoryModel->findAll(),
            'tags' => $tagModel->findAll(),
            'productTags' => [],
        ]);
    }

    function edit($id)
    {
        $productsModel = new \App\Modules\Products\Models\Products();
        $categoryModel = new Categories();
        $tagModel = new Tags();
        $productTagModel = new ProductTag();
        // $tags = $productTagModel->select('t.tagid, t.name')
        //     ->join('tags as t', 't.tagid = product_tag.tagid')
        //     ->join('products as p', 'p.productid = product_tag.productid')
        //     ->where('p.productid', $id)->findAll();
        $productTags = array_column(
            $productTagModel
                ->asArray()
                ->select('tagid')
                ->where('productid', $id)
                ->findAll(),
            'tagid'
        );

        echo view('App\Modules\Products\Views\edit', [
            'product' => $productsModel->find($id),
            'categories' => $categoryModel->findAll(),
            'tags' => $tagModel->findAll(),
            'productTags' => $productTags,

        ]);
    }

    function create()
    {
        $productsModel = new \App\Modules\Products\Models\Products();
        $productTagModel = new ProductTag();

        if ($this->validate('products')) {
            $tags = $this->request->getPost('tagid') ?: [];

            $product = $productsModel->insert([
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'),
                'description' => $this->request->getPost('description'),
                'entry' => $this->request->getPost('entry'),
                'exit' => $this->request->getPost('exit'),
                'stock' => $this->request->getPost('stock'),
                'price' => $this->request->getPost('price'),
                'categoryid' => $this->request->getPost('categoryid'),
            ]);
            // log_message('debug', json_encode($productsModel->find($product)));
            foreach ($tags as $key) {
                try {
                    $productTagModel->insert(
                        [
                            'productid' => $productsModel->getInsertID(),
                            'tagid' => $key,
                        ]
                    );
                } catch (\Throwable $th) {
                }
            }
            return redirect()->back()->with('message', 'Registro creado correctamente');
        } else {
            session()->setFlashdata('validation', $this->validator);

            return redirect()->back()->withInput();
        }

    }

    function update($id)
    {


        $productsModel = new \App\Modules\Products\Models\Products();
        $productTagModel = new ProductTag();
        // log_message(
        //     'debug',
        //     $this->request->getPost('categoryid'),
        // );
        if ($this->validate('products')) {
            // log_message('debug', json_encode($this->request->getPost('tagid')));
            $tags = $this->request->getPost('tagid') ?: [];
            $productsModel->update($id, [
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'),
                'description' => $this->request->getPost('description'),
                'entry' => $this->request->getPost('entry'),
                'exit' => $this->request->getPost('exit'),
                'stock' => $this->request->getPost('stock'),
                'price' => $this->request->getPost('price'),
                'categoryid' => $this->request->getPost('categoryid'),
            ]);
            foreach ($tags as $key) {
                $productTagModel->insert(
                    [
                        'productid' => $id,
                        'tagid' => $key,
                    ]
                );

            }

            $productTagModel
                ->whereNotIn('tagid', $tags)
                ->where('productid', $id)
                ->delete();
            // log_message('debug', json_encode($productTagsDelete));
            return redirect()->back()->with('message', 'Registro actualizado correctamente');
        } else {
            session()->setFlashdata('validation', $this->validator);

            return redirect()->back()->withInput();
        }
    }

    function delete($id)
    {
        $productsModel = new \App\Modules\Products\Models\Products();
        $productsModel->delete($id);
        return redirect()->back()->with('message', 'Registro borrado correctamente');
    }

    public function addStock()
    {
        $entry = $this->request->getPost('entry');
        $id = $this->request->getPost('id');
        $userid = $this->request->getPost('userid');
        $description = $this->request->getPost('description');
        $direction = $this->request->getPost('direction');

        $validation = \Config\Services::validation();
        if (!$validation->check($entry, 'required|is_natural_no_zero')) {
            return $this->failValidationError('Cantidad no valida');
        }

        $productModel = new \App\Modules\Products\Models\Products;
        $productsControlModel = new ProductsControl();
        $productsUserControlModel = new ProductUserControl();

        // log_message('debug', $user);
        $product = $productModel->find($id);

        $res = $this->validate(
            [
                'userid' => 'checkType[salesman]',
                'direction' => 'required|min_length[2]',
                'description' => 'required|min_length[2]',
            ]
        );
        if (!$res) {
            return $this->failValidationErrors([
                'direction' => $this->validator->getError('direction'),
                'description' => $this->validator->getError('description'),
            ]);
        }
        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $product->stock += $entry;
        $product->entry = $entry;
        $productModel->update($id, [
            'stock' => $product->stock,
            'entry' => $entry
        ]);

        $productsControlModel->insert(
            [
                'productid' => $id,
                'count' => $entry,
                'type' => 'entry',
                'userid' => $userid,
            ]
        );
        // DONE: RESVISAR PQ ESTA FUNCION NO VA
        // $productControlId = $productsControlModel->select('products_controlid')->orderBy('created_at','desc')->first();
        $productControlId = $productsControlModel->getInsertID();
        // log_message('debug', json_encode($productControlId));
        $productsUserControlModel
            ->insert([
                'products_controlid' => $productControlId,
                'direction' => $direction,
                'description' => $description,
            ]);

        // return $this->respond(['stock' => 50]);
        // log_message('debug', json_encode($productsControlModel->select('*')->where('productid =', $id)->findAll()));
        return $this->respondUpdated($productModel->find($id));
    }

    public function removeStock()
    {
        $exit = $this->request->getPost('exit');
        $id = $this->request->getPost('id');
        $userid = $this->request->getPost('userid');
        $description = $this->request->getPost('description');
        $direction = $this->request->getPost('direction');
        // log_message('debug',$userid);
        $validation = \Config\Services::validation();

        if (!$validation->check($exit, 'required|is_natural_no_zero')) {
            return $this->failValidationError('Cantidad no valida');
        }

        //  log_message('debug', $validation."");

        $productModel = new \App\Modules\Products\Models\Products;
        $productsControlModel = new ProductsControl();
        $productsUserControlModel = new ProductUserControl();

        $res = $this->validate(
            [
                'userid' => 'customer',
                'direction' => 'required|min_length[2]',
                'description' => 'required|min_length[2]',
            ]
        );
        if (!$res) {
            return $this->failValidationErrors([
                'direction' => $this->validator->getError('direction'),
                'description' => $this->validator->getError('description'),
            ]);
        }
        $product = $productModel->find($id);

        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        if ($product->stock - $exit < 0) {
            return $this->failValidationError('No hay stock suficiente');
        }
        $product->stock -= $exit;
        $product->exit = $exit;
        $productModel->update($id, [
            'stock' => $product->stock,
            'exit' => $exit
        ]);

        $productsControlModel->insert(
            [
                'productid' => $id,
                'count' => $exit,
                'type' => 'exit',
                'userid' => $userid,

            ]
        );
        $productControlId = $productsControlModel->getInsertID();
        // log_message('debug', json_encode($productControlId));
        $productsUserControlModel
            ->insert([
                'products_controlid' => $productControlId,
                'direction' => $direction,
                'description' => $description,
            ]);

        // return $this->respond(['stock' => 50]);
        //  log_message('debug', json_encode($productsControlModel->select('*')->orderBy('created_at', 'desc')->findAll()));
        return $this->respondUpdated($productModel->find($id));
    }
}