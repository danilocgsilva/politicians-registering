<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\CRUD\Traits;

trait CRUDTrait
{
    public function delete(int $id)
    {
        $this->pdo
            ->prepare(
                sprintf("DELETE FROM %s WHERE id = ?;", self::TABLE_NAME)
            )->execute([$id]);
    }
}