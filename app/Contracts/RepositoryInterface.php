<?php

namespace App\Contracts;

interface RepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []);

    public function paginate(int $perPage = 15, array $columns = ['*']);

    public function find(int $id, array $columns = ['*'], array $relations = []);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findBy(string $field, $value, array $columns = ['*']);

    public function findWhere(array $where, array $columns = ['*']);
}
