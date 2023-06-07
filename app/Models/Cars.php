<?php

namespace Models;

class Cars extends Model
{
    public string $id;
    protected string $registration;
    protected string $brand;
    protected string $model;
    protected string $created;
    protected string $updated;

    /**
     * @throws \Exception
     */
    public function getTime($time): string
    {
        return (new \DateTime($time))->format('Y-m-d H:i');
    }

    /**
     * @throws \Exception
     */
    public function getCreated(): string
    {
        return $this->getTime($this->created);
    }

    /**
     * @throws \Exception
     */
    public function getUpdated(): string
    {
        return $this->getTime($this->updated);
    }

    public function getRegistration(): string
    {
        return strtoupper($this->registration);
    }

    public function getBrand(): string
    {
        $brands = $this->create('brands');
        $model = $brands->getBy('id', $this->brand);
        return $model->brand;
    }

    public function getModel(){
        $models = $this->create('models');
        $model = $models->getBy('id', $this->model);
        return $model->model;
    }
}
