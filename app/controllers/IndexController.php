<?php

namespace Controllers;

use JetBrains\PhpStorm\NoReturn;
use Model\Brands;
use Model\Cars;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    #[NoReturn]
    public function index()
    {
        $this->view->data = Cars::find();
        $this->view->pick('index/index');

        $this->view->render('index', 'index');
    }

    public function get()
    {
        $ret = [];

        foreach (Cars::find() as $car) {
            $rec = (object)$car->toArray();
            $rec->brand = $car->getBrand();
            $rec->model = $car->getModel();
            $ret[] = $rec;
        }

        return $this->response->setJsonContent($ret);
    }

    /**
     * Delete vehicle
     * @return void
     */
    public function delete($id)
    {
        $car = Cars::findFirst($id);
        if ($car) {
            $car->delete();
        }
    }

    /**
     * Update vehicle
     *
     * @return void
     */
    public function update($id)
    {
        $car = Cars::findFirst($id);
        $car->brandId = $this->request->getPost('brand');
        $car->modelId = $this->request->getPost('model');
        $car->registration = $this->request->getPost('registration');
        $car->update();
    }
}
