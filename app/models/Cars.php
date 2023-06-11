<?php

namespace Model;

class Cars extends Model
{
    public string $id;
    protected string $registration;
    protected string $brandId;
    protected string $modelId;
    protected string $created;
    protected string $updated;

    public function initialize()
    {
        $this->hasOne('brandId', 'Model\Brands', 'id', ['alias' => 'brandName']);
        $this->hasOne('modelId', 'Model\Models', 'id', ['alias' => 'modelName']);
    }

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

    public function getBrand()
    {
        if ($this->brandName) {
            return $this->brandName->brand;
        }
        return '';
    }

    public function getModel()
    {
        if ($this->modelName) {
            return $this->modelName->model;
        }
        return '';
    }

    public function setBrandId($brand)
    {
        $brandRec = Brands::findFirstByBrand($brand);
        if (!$brandRec) {
            $brandRec = new Brands();
            $brandRec->brand = $brand;
            $brandRec->create();
        }
        $this->brandId = $brandRec->id;
    }

    public function setModelId($model)
    {
        $modelRec = Models::findFirstByModel($model);
        if (!$modelRec) {
            $modelRec = new Models();
            $modelRec->model = $model;
            $modelRec->create();
        }
        $this->modelId = $modelRec->id;
    }

    public function setRegistration($registration)
    {
        $this->registration = $registration;
    }

}
