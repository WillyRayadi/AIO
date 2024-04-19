<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Delivery extends BaseController
{
    use ResponseTrait;

    private $deliveryModel;
    private $deliveryItemModel;
    private $vehicleModel;
    private $saleItemModel;
    private $saleModel;
    private $validation;
    private $apiKeyModel;
    private $productModel;

    public function __construct()
    {
        $this->deliveryModel = model("App\Models\Delivery");
        $this->deliveryItemModel = model("App\Models\DeliveryItem");
        $this->vehicleModel = model("App\Models\Vehicle");
        $this->saleItemModel = model("App\Models\SaleItem");
        $this->saleModel = model("App\Models\Sale");
        $this->validation = \Config\Services::validation();
        $this->apiKeyModel = model("App\Models\ApiKey");
        $this->productModel = model("App\Models\Product");
    }

    public function index()
    {
        $body = $this->validate([
            'sale_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} is required"
                ]
            ]
        ]);

        if (!$body) {

            $data = [
                "messages" => implode(", ", $this->validation->getErrors()),
                "status" => 400,
                "error" => true
            ];

            return $this->respond($data, 400);
        }

        $sale_id = $this->request->getVar("sale_id");

        $do = $this->deliveryModel
            ->select(["deliveries.id as delivery_id", "deliveries.sale_id", "deliveries.sent_date", "delivery_items.quantity as delivered_quantity", "sale_items.product_id", "products.name"])
            ->join('delivery_items', 'deliveries.id = delivery_items.delivery_id', 'left')
            ->join('sale_items', 'delivery_items.sale_item_id = sale_items.id', 'left')
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->where('deliveries.sale_id', $sale_id)
            ->findAll();

        // Jika Do Tidak Ditemukan
        if (empty($do)) {

            $data = [
                "messages" => "Delivery record not found",
                "status" => 404,
                "error" => true
            ];

            return $this->respond($data, 404);
        }

        return $this->respond(["message" => "success", "status" => 200, "data" => $do, "error" => false], 200);
    }

    public function insert()
    {
        $body = $this->validate([
            "sale_id" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ],
            "sent_date" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required",
                ]
            ],
            "remarks" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ],
            "vehicle" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ],
            "products" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ]
        ]);

        if (!$body) {

            $data = [
                "messages" => implode(", ", $this->validation->getErrors()),
                "status" => 400,
                "error" => true
            ];

            return $this->respond($data, 400);
        }

        $products = $this->request->getVar('products');
        $vechile = $this->getVehicleID($this->request->getVar('vehicle'));
        $remarks = $this->getDriverAndNotes($this->request->getVar('remarks'));

        $data = [
            "sale_id" => $this->request->getVar('sale_id'),
            "sent_date" => $this->request->getVar('sent_date'),
            "driver_name" => $remarks['driver'],
            "warehouse_notes" => $remarks['notes'],
            "vehicle_id" => $vechile
        ];

        $delivery = $this->deliveryModel->insert($data);

        $deliveryID = $this->deliveryModel->getInsertID();

        $items = $this->prepareDeliveryItems($deliveryID, $products, $data["sale_id"]);

        if ($items == false) {
            $message = [
                "Delivery Order" => $delivery,
                "error" => "Failed to insert delivery items. The quantity of one or more delivered items exceeds the available sale quantity."
            ];


            return $this->failValidationErrors(json_encode($message));
        }

        $successMessage = [
            "message" => "success",
            "status" => 201,
            "error" => false,
            "delivery_order" => $data
        ];

        return $this->respondCreated($successMessage);
    }

    public function delete()
    {
        $body = $this->validate([
            "sale_id" => [
                "rules" => "required",
                "errors" => [
                    "required" => '{field} is required'
                ]
            ]
        ]);

        if (!$body) {

            $data = [
                "messages" => implode(", ", $this->validation->getErrors()),
                "status" => 400,
                "error" => true
            ];

            return $this->respond($data, 400);
        }

        $delivery = $this->deliveryModel->select('id')->where('sale_id', $this->request->getVar('sale_id'))->findAll();

        if (empty($delivery)) {

            $data = [
                "messages" => "Delivery record not found",
                "status" => 404,
                "error" => true
            ];

            return $this->respond($data, 404);
        }

        foreach ($delivery as $item) :
            $this->deliveryItemModel->where('delivery_id', $item->id)->delete();
            $this->deliveryModel->where('id', $item->id)->delete();
        endforeach;

        $this->saleModel->where('id', $this->request->getVar('sale_id'))->set(["status" => 2])->update();

        $data = [
            "messages" => "Delivery record deleted!",
            "status" => 200,
            "error" => false
        ];

        return $this->respond($data, 200);
    }

    private function getVehicleID($array)
    {
        $value = explode("-", $array);

        $value = array_map('trim', $value);

        if (isset($value[2])) {
            $vechile = $this->vehicleModel->select(["id"])->where('number', $value[2])->first();

            return $vechile->id;
        } else {
            $vechile = $this->vehicleModel->select(["id"])->where('type', $value[0])->first();

            return $vechile->id;
        }
    }

    private function getDriverAndNotes($array)
    {
        $value = explode("-", $array);

        $value = array_map('trim', $value);

        return [
            "driver" => $value[1] ?? $value[0],
            "notes" => $value[0] ?? "......"
        ];
    }

    private function prepareDeliveryItems($deliveryID, $products, $saleID)
    {
        $data = [];

        foreach ($products as $product) {
            $saleItemID = $this->getSaleItemID($product->sku, $saleID);
            $items = $this->getSaleAndDeliveryItems($saleID, $product->sku);

            if ($saleItemID) {
                $data[] = [
                    "delivery_id" => $deliveryID,
                    "sale_item_id" => $saleItemID['sale_item_id'],
                    "quantity" => $product->qty
                ];
            }

            if ($product->qty > $items['sale_quantity']) {
                return false;
            } else {
                $sumQty = $items['sale_quantity'] - $items['delivery_quantity'];

                if ($product->qty > $sumQty) {
                    return false;
                }
            }
        }

        $this->deliveryItemModel->insertBatch($data);
        $this->updateDeliveryStatus($saleID);

        return true;
    }

    private function getSaleItemID($sku, $saleID)
    {
        $saleItem = $this->saleItemModel
            ->select(["sale_items.id", "products.sku_number"])
            ->join('sales', "sale_items.sale_id = sales.id", "left")
            ->join("products", "sale_items.product_id = products.id", "left")
            ->where('products.sku_number', $sku)
            ->where("sales.id", $saleID)
            ->first();

        if ($saleItem) {
            return [
                "sale_item_id" => $saleItem->id,
                "sku" => $saleItem->sku_number
            ];
        }

        return null;
    }

    private function getSaleAndDeliveryItems($salesID, $sku)
    {
        $product = $this->productModel->select(["id"])->where('sku_number', $sku)->first();

        $sale = $this->saleModel
            ->select(['SUM(sale_items.quantity) as saleQty'])
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->where('sales.id', $salesID)
            ->where('sale_items.product_id', $product->id)
            ->first();

        $delivery = $this->saleModel
            ->select(['SUM(delivery_items.quantity) as deliveryQty'])
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->join('delivery_items', 'sale_items.id = delivery_items.sale_item_id', 'left')
            ->where('sales.id', $salesID)
            ->where('sale_items.product_id', $product->id)
            ->first();

        return [
            "sale_quantity" => $sale->saleQty,
            "delivery_quantity" => $delivery->deliveryQty
        ];
    }

    private function getOrderedAndDeliveredQuantity($saleID)
    {
        $sale = $this->saleModel
            ->select(["SUM(sale_items.quantity) as sale_quantity"])
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->where('sales.id', $saleID)
            ->first();

        $delivery = $this->saleModel
            ->select(["SUM(delivery_items.quantity) as delivered_quantity"])
            ->join('sale_items', 'sales.id = sale_items.sale_id')
            ->join('delivery_items', 'sale_items.id = delivery_items.sale_item_id', 'left')
            ->where('sales.id', $saleID)
            ->first();

        return [
            "sale_quantity" => $sale->sale_quantity,
            "delivered_quantity" => $delivery->delivered_quantity ?? 0
        ];
    }

    private function updateDeliveryStatus($saleID)
    {
        $items = $this->getOrderedAndDeliveredQuantity($saleID);

        if ($items["delivered_quantity"] < $items["sale_quantity"]) {
            return $this->saleModel->where('id', $saleID)->set(["status" => 4])->update();
        } else {
            return $this->saleModel->where('id', $saleID)->set(["status" => 5])->update();
        }
    }
}
