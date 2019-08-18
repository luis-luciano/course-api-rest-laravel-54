<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract as Transformer;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    protected function successResponse(array $data = [], int $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($messages, int $code)
    {
        return response()->json(['error' => $messages, 'code' => $code], $code);
    }

    protected function seeAll(Collection $collection, int $code = Response::HTTP_OK)
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, int $code = Response::HTTP_OK)
    {
        return $this->successResponse(['data' => $instance], $code);
    }

    protected function transformData($data, Transformer $transformer)
    {
        $transformation = fractal($data, new $transformer);

        // Se utiliza toArray para visibilidad comprensible por usuario
        return $transformation->toArray();
    }
}
