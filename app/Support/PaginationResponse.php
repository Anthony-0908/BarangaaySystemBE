<?php

namespace App\Support;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationResponse
{
   public static function make(LengthAwarePaginator $paginator)
   {
        return [
            'records' => $paginator->items(),

            'pagination' => [
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
                'lastPage' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            
        ];
   }
}
