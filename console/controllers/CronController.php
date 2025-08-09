<?php

/* @var $item common\models\Orders */
/* @var $orders common\models\Orders */

namespace console\controllers;

use admin\models\InsertOrders;
use common\models\Bot;
use common\models\Orders;
use Yii;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\console\Controller;

/**
 * Test controller
 */
class CronController extends Controller {

    public function actionIndex() {
        $orders = Orders::find()->where(['status' => Orders::STATUS_THEN_TAKES])->all();
        foreach ($orders as $item) {
            if ($item->take_time < time()){
                $item->status = Orders::STATUS_NEW;
                $item->is_then = 1;
                $item->save();
            }
        }
    }

    public function actionHold() {
        $orders = Orders::find()->where(['status' => Orders::STATUS_HOLD])->all();
        foreach ($orders as $item) {
            $oneDayAgo = time() - 86400;
            if ($item->updated_date < $oneDayAgo) {
                $item->status = Orders::STATUS_NEW;
                $item->is_hold = 1;
                $item->save();
            }
        }
    }

    public function actionImportExcel() {
        $model = InsertOrders::find()->where(['status' => InsertOrders::STATUS_NEW])->orderBy(['id' => SORT_DESC])->one();
        if ($model){
            $model->status = InsertOrders::STATUS_PREPARED;
            $model->save(false);
            $model->adminSendTelegram("⏳ - " . $model->filename . " faylga ishlov berilmoqda");
            $filePath = Yii::getAlias('@admin/web/uploads/excel/' . $model->filename);
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            $header = $rows[0] ?? [];
            if (!in_array('Status', $header)) {
                $header[] = 'Status';
                $sheet->fromArray([$header], null, 'A1');
            }
            foreach ($rows as $index => $row) {
                if ($index == 0) continue;
                $checker = Orders::find()->where(['phone' => $row[2], 'user_id' => $model->user_id, 'product_id' => $row[0]])->exists();
//                ->andWhere(['DATE(FROM_UNIXTIME(text))' => new Expression('CURDATE()')])
                if (!$checker){
                    if (strlen($row[2]) == 9){
                        $row[3] = 'Yangi qo\'shildi';
                        $model->inserted++;
                        $order = new Orders();
                        $order->phone = $row[2];
                        $order->product_id = $row[0];
                        $order->full_name = $row[1];
                        $order->user_id = $model->user_id;
                        $order->save(false);
                    }else{
                        $row[3] = 'Xato raqam';
                        $model->error++;
                    }
                }else{
                    $row[3] = 'Takroriy';
                    $model->double++;
                }
                $sheet->fromArray([$row], null, 'A' . ($index + 1));
            }
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($filePath);
            $model->updated_date = time();
            $model->status = InsertOrders::STATUS_READY;
            $model->save(false);
            $model->adminSendTelegram("✅ - " . $model->filename . " fayl tayyor bo'ldi");
        }
    }

}
?>