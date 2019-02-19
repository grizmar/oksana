<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

/**
 * Class CreateTestData
 * TODO delete before production
 */
class CreateTestData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = [
            [
                'name'     => 'Dummy 1',
                'email'    => 'ildargafurof@gmail.com',
                'password' => '123',
                'active'   => true,
            ],
            [
                'name'     => 'Dummy 2',
                'email'    => 'elanthes@gmail.com',
                'password' => '123',
                'active'   => false,
            ],
        ];

        $userIds = $this->insertItems(DB::table('users'), $users);

        $vendors = [
            [
                'name' => 'Channel',
            ],
            [
                'name' => 'Avon',
            ],
        ];

        $vendorIds = $this->insertItems(DB::table('vendors'), $vendors);

        $products = [
            [
                'barcode'     => '5012345678100',
                'name'        => 'Rouge coco flash',
                'description' => 'A comfortable lipstick with intense colour that transforms on contact with lips for an enhanced high-shine effect.',
                'vendor_id'   => $vendorIds[0],
            ],
            [
                'barcode'     => '5012345678200',
                'name'        => 'True Color Perfectly Matte Lipstick',
                'description' => 'Meet your perfect matte, Avon True Color Perfectly Matte Lipstick... An extremely smooth, completely matte lipstick that never cakes, cracks, or compromises. Seals in moisture for a lightweight velvety feel.',
                'vendor_id'   => $vendorIds[1],
            ],
        ];

        $productIds = $this->insertItems(DB::table('products'), $products);

        $ratings = [
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[0],
                'value'      => 5,
            ],
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[1],
                'value'      => 1,
            ],
        ];

        $ratingIds = $this->insertItems(DB::table('ratings'), $ratings);

        $historyItems = [
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[0],
            ],
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[1],
            ],
        ];

        $this->insertItems(DB::table('search_history'), $historyItems);

        $comments = [
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[0],
                'rating_id'  => $ratingIds[0],
                'content'    => 'Some example comment 1',
            ],
            [
                'product_id' => $productIds[0],
                'user_id'    => $userIds[1],
                'rating_id'  => $ratingIds[1],
                'content'    => 'Some example comment 2',
            ],
        ];

        $this->insertItems(DB::table('comments'), $comments);
    }

    private function insertItems(Builder $table, array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = $table->insertGetId($item);
        }

        return $result;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
