<?php

namespace Core\Application\Query;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     description="Product model",
 *     @OA\Xml(name="Product"),
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the product",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the product",
 *         example="A nice product"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="decimal",
 *         description="Name of the product",
 *         example="A nice product"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the product",
 *         example="A nice product"
 *     )
 * )
 */
class GetAllProductsQuery implements QueryInterface
{
    public $perPage;
    public $page;

    public function __construct($perPage = 15, $page = null)
    {
        $this->perPage = $perPage;
        $this->page = $page ?: request()->input('page', 1);
    }
}
