<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Subjects;
use App\Domain\Contracts\SubjectsInterface;
use App\Domain\Contracts\Crudable;


/**
 * Class SubjectsRepository
 * @package App\Domain\Repositories
 */
class SubjectsRepository extends AbstractRepository implements SubjectsInterface, Crudable
{

    /**
     * @var Subjects
     */
    protected $model;

    /**
     * SubjectsRepository constructor.
     * @param Subjects $Subjects
     */
    public function __construct(Subjects $subjects)
    {
        $this->model = $subjects;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param int $limit
     * @param int $page
     * @param array $column
     * @param string $field
     * @param string $search
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate($limit = 10, $page = 1, array $column = ['*'], $field, $search = '')
    {
        // query to aql
        $akun = $this->model
            ->join('teachers', 'subjects.teachers_id', '=', 'teachers.id')
            ->where(function ($query) use ($search) {
                $query->where('subjects.name', 'like', '%' . $search . '%')
                    ->orWhere('teachers.name', 'like', '%' . $search . '%');
                    
                })
            ->select('subjects.*')
            ->paginate($limit)
            
            ->toArray();
        return $akun;
    }

    /**
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(array $data)
    {
        // execute sql insert
        return parent::create([
            'name'    => e($data['name']),
            'teachers_id'   => e($data['teachers_id']),
            'descriptions' => e($data['descriptions']),
        ]);

    }

    /**
     * @param $id
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, array $data)
    {
        return parent::update($id, [
            'name'    => e($data['name']),
            'teachers_id'   => e($data['teachers_id']),
            'descriptions' => e($data['descriptions']),
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        return parent::delete($id);
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findById($id, array $columns = ['*'])
    {
        return parent::find($id, $columns);
    }
public function getList()
    {
        // query to aql
        $akun = $this->model->get()->toArray();
        // if data null
        if (null == $akun) {
            // set response header not found
            return $this->errorNotFound('Data belum tersedia');
        }

        return $akun;

    }
}