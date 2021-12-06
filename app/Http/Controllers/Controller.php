<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @SWG\Swagger(
     *     basePath="",
     *     schemes={"http", "https"},
     *     host=L5_SWAGGER_CONST_HOST,
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="L5 Swagger API",
     *         description="L5 Swagger API description",
     *         @SWG\Contact(
     *             email="your-email@domain.com"
     *         ),
     *     )
     * )
     */

    /**
     * @OA\Info(title="My First API", version="0.1")
     */

    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
