<?php
namespace Controllers;
use Models\Cars;
use Models\Model;

class Controller
{
    public Model $model;


    public function index(){
        /** @var Cars $cars */
        $cars = $this->model->create('cars');
        $cars->exec();
        include '../app/View/index.html';
        die();
    }

    /**
     * Delete vehicle
     * @return void
     */
    public function delete(){}

    /**
     * Update vehicle
     *
     * @return void
     */
    public function update(){}
}
