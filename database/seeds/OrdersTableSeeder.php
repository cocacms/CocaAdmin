<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oid = 10123;
        for ($i = 0; $i < 1000 ; $i++){
            $status = mt_rand(1,4);
            $oid++;
            $orders[] = [
                'id' => $oid,
                'oid' => order_id_create(),
                'uid' => 1,
                'account' => 'test1',
                'remark' => str_random(10),
                'addressee' => str_random(10),
                'tel' => str_random(10),
                'address' => str_random(10),
                'status' => $status,
                'waybill' => str_random(10),
                'waybill_type' => 'sf',
                'amount' => mt_rand(100,3000)
            ];

            $order_items[] = [
                'order_id'=>$oid,
                'product_id' => 4,
                'count' => 1
            ];

            $d_status = mt_rand(0,5);
            for ($j = 0;$j < mt_rand(1,5);$j++){
                $order_details[] = [
                    'order_id' => $oid,
                    'pic' => '/storage/uploads/20170813/9uMGcsJ2wGQfgBMpnUW5l6DEOsdImPVKXcBD1UxR.jpeg',
                    'status' => $d_status,
                    'waybill' => str_random(10),
                    'waybill_type' => 'sf',
                    'return_waybill' => str_random(10),
                    'return_waybill_type' => 'sf',
                    'return_remark' => str_random(10)
                ];
            }

        }
        try{
            DB::beginTransaction();
            DB::table('orders')->insert($orders);
            DB::table('order_items')->insert($order_items);
            DB::table('order_details')->insert($order_details);
            DB::commit();
        }catch (Exception $e){
            dd($e->getMessage());
        }


    }
}
