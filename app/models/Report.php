<?php

class Report extends Model
{
    public function products(?string $keyword = null, ?int $month = null, ?int $year = null, ?string $category = null): array
    {
        return (new Product())->all($keyword, $month, $year, $category);
    }

    public function incoming(?int $month = null, ?int $year = null, ?string $category = null): array
    {
        return (new IncomingTransaction())->all($month, $year, $category);
    }

    public function outgoing(?int $month = null, ?int $year = null, ?string $category = null): array
    {
        return (new OutgoingTransaction())->all($month, $year, $category);
    }
}
