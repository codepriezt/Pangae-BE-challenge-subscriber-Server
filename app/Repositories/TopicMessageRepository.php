<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\TopicMessage;

class TopicMessageRepository implements InterfaceRepository
{

    
    public function __construct()
    {
        $this->model = new TopicMessage();
    }


     /**
     * fetch paginated model collection
     * @return collection 
     */
    public function all()
    {
        return $this->model->paginate(5);
    }



    /**
     * Create model instance 
     * @param array
     * @return instance
    */
    public function create(array $data)
    {
        return TopicMessage::create($data);
    }


     /**
     * show a model  instance 
     * @param int 
     * @return instance
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Delete a model instance 
     * @param int 
     * @return instance
    */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }


    /**  
     * Get model instance 
     * @return instance
     */
    public function getModel()
    {
        return $this->model;
    }


     /**
     * get the latest model instance  
     * @param array
     * @return instance
     */
    public function first(array $data)
    {
        return $this->model->firstOrNew($data);
    }



    /**
     * Update class instance 
     * @param array
     * @param int 
     * @return instance
     */
    public function update(array $data, $id)
    {
        $model = $this->model->find($id);
        $model->update($data);
        return $model;
    }


     /**
     * Get a model by name field
     * @param string
     * @return instance
     */
    public function getModelByName(string $name){
        return $this->model->where(['name'=> $name]);
    }



    /**
     * Set a model instance
     * @param App\Models\Subscription
     * @return instance
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this->model;
    }


    /**
     * Get instance attributtes with eloquent relationship
     * @param App\Models
     * @return array 
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }


    public function whereColumn(array $data){
        return $this->model->where($data);
    }


}