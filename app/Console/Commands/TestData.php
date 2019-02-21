<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Model\Notification;

class TestData extends Command
{
    protected $signature = 'testdata:insert';
    protected $description = 'Create test data';

    public function handle()
    {
        DB::beginTransaction();

        try
        {
            $this->insertTestData();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }
    }

    private function insertTestData()
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
                'user_id'    => $userIds[0],
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

        $reviews = [
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

        $reviewItems = $this->insertItems(DB::table('reviews'), $reviews);

        $estimates = [
            [
                'review_id' => $reviewItems[1],
                'user_id'   => $userIds[0],
                'value'     => true,
            ],
            [
                'review_id' => $reviewItems[0],
                'user_id'   => $userIds[1],
                'value'     => false,
            ],
        ];

        $estimateItems = $this->insertItems(DB::table('estimates'), $estimates);

        $notifications = [
            [
                'type'        => Notification::TYPE_ESTIMATE,
                'user_id'     => $userIds[1],
                'estimate_id' => $estimateItems[0],
            ],
            [
                'type'        => Notification::TYPE_ESTIMATE,
                'user_id'     => $userIds[0],
                'estimate_id' => $estimateItems[1],
            ],
            [
                'type'        => Notification::TYPE_ESTIMATE,
                'user_id'     => $userIds[0],
                'estimate_id' => $estimateItems[1],
                'content'     => 'Ty pidor!',
            ],
        ];

        $this->insertItems(DB::table('notifications'), $notifications);
    }

    private function insertItems(Builder $table, array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            $result[] = $table->insertGetId($item);
        }

        return $result;
    }
}
