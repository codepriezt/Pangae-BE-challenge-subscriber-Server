<?php 
namespace App\Repositories;


interface InterfaceRepository
{

	public function all();

	public function show($id);

	public function delete($id);

	public function update(array $data , $id);
	
	public function create( array $data);

}