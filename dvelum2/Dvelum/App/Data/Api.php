<?php

namespace Dvelum\App\Data;

use Dvelum\Orm;
use Dvelum\Orm\Model;
use Dvelum\App\Session\User;

class Api
{
    /**
     * @var Api\Request
     */
    protected $apiRequest;
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Model\Query
     */
    protected $dataQuery;

    public function __construct(Api\Request $request, User $user)
    {
        $this->apiRequest = $request;
        $this->user = $user;

        $object = $this->apiRequest->getObjectName();
        $ormObjectConfig = Orm\Record\Config::factory($object);

        $model = Model::factory($object);

        if($ormObjectConfig->isDistributed()){
            $model = Model::factory($ormObjectConfig->getDistributedIndexObject());
        }

        $this->dataQuery = $model->query()
            ->params($this->apiRequest->getPagination())
            ->filters($this->apiRequest->getFilters())
            ->search($this->apiRequest->getQuery());
    }

    public function getList()
    {
        if(empty($this->fields)){
            $fields = $this->getDefaultFields();
        }else{
            $fields = $this->fields;
        }

        $object = $this->apiRequest->getObjectName();
        $ormObjectConfig = Orm\Record\Config::factory($object);
        if($ormObjectConfig->isDistributed()){
            $indexConfig = Orm\Record\Config::factory($ormObjectConfig->getDistributedIndexObject());
            $fields = array_keys($indexConfig->getFields());
        }
        return  $this->dataQuery->fields($fields)->fetchAll();
    }

    public function getCount() : int
    {
        return  $this->dataQuery->getCount();
    }

    /**
     * Set fields to be fetched
     * @param array $fields
     */
    public function setFields(array $fields) : void
    {
        $this->fields = $fields;
    }

    /**
     * Get list of fields to be fetched
     * @return array
     */
    public function getFields() : array
    {
        if(empty($this->fields)){
            return $this->getDefaultFields();
        }
        return $this->fields;
    }

    /**
     * Get default field list
     * @return array
     */
    protected function getDefaultFields() : array
    {
        $result = [];
        $objectName = $this->apiRequest->getObjectName();
        $config = Orm\Record\Config::factory($objectName);

        $fields = $config->getFields();
        foreach($fields as $k=>$v)
        {
            if($v->isText() || $v->isMultiLink()){
                continue;
            }
            $result[] = $v->getName();
        }
        return $result;
    }
}