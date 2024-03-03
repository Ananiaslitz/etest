<?php

namespace Core\Infrastructure\Http\Controllers;

use Illuminate\View\View;
use OpenApi\Generator;

/**
 * @OA\Get(
 *     path="/projects",
 * @OA\Response(response="200", description="Display a listing of projects.")
 * )
 */
class DocumentationController extends BaseController
{
    public function __construct(private Generator $generator)
    {
    }

    public function html(): View
    {
        return view('documentation-swagger');
    }

    public function index()
    {
        $swagger = $this->generator::scan([BASE_PATH . '/core/Infrastructure/Http/Controllers']);

        return $swagger->toJson();
    }
}
