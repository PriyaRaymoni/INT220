<?php
include 'config.php';

if (isset($_POST['list-orders'])) {
    $orders = listOrders();
    $output = '';
    if (count($orders) > 0) {
        foreach ($orders as $order) {
            $output .= "
            <div class=\"rounded-xl border px-4 py-2 bg-[#f2f2f2] hover:bg-[#f0f4f9]\">
                <div class=\"flex gap-2\">
                    <div class=\"flex flex-col items-start gap-1\">
                    <p class=\"text-xl\">{$order['name']}</p>
                    <p class=\"text-lg\">AED. {$order['total']}</p>
                    </div>
                </div>
                <button onclick=\"viewOrder({$order['id']})\" class=\"my-2 bg-red-500 hover:bg-red-200 hover:text-red-700 hover:font-semibold rounded-xl px-4 py-2 text-white \">
                    View Orders
                </button>
            </div>
            <div id=\"order-pannel{$order['id']}\" class=\"hidden fixed top-0 bottom-0 left-0 right-0 bg-[#0e0d0dad] flex items-center justify-center\">
                <div class=\"bg-white p-4 rounded-xl flex flex-col\">
                    <div class=\"flex flex-row items-center justify-between\">
                        <p class=\"text-2xl font-semibold mb-2\">Order</p>
                        <Button onclick=\"viewOrder({$order['id']})\"><span class=\"material-symbols-outlined\">close</span></Button>
                    </div>
                    <div class=\"flex flex-row gap-2\">
                        <div id=\"order-items\" class=\"flex flex-col gap-2 px-2 border-r\">
                            <p class=\"text-xl font-semibold\">Items</p>
                            <table>
                                <thead class=\"bg-gray-200 text-gray-600 text-sm uppercase font-semibold rounded-xl\">
                                    <tr class=\"text-left border-b border-gray-300 py-2\">
                                        <th class=\"ps-1 pe-4 py-2\">Item</th>
                                        <th class=\"pe-4 py-2\">Quantity</th>
                                        <th class=\"pe-4 py-2\">Price</th>
                                    </tr>
                                </thead>
                                <tbody class=\"bg-white text-gray-600 font-semibold border-b border-gray-300\">";
            $x = json_decode($order['items']);
            foreach ($x as $item) {
                $output .= "
                                    <tr class=\"text-left border-b border-gray-300\">
                                        <td class=\"pe-8 py-2\">{$item->name}</td>
                                        <td class=\"pe-8 py-2\">{$item->quantity}</td>
                                        <td class=\"pe-8 py-2\">{$item->price}</td>
                                    </tr>";
            }
            $output .= "
                                </tbody>
                            </table>
                            <div class=\"flex flex-row items-center justify-between\">
                                <p class=\"text-xl font-semibold\">Total</p>
                                <p class=\"text-xl font-semibold\">AED. {$order['total']}</p>
                            </div>
                        </div>
                        <div class\"flex flex-col gap-2 px-2\">
                            <p class=\"text-xl font-semibold\">Order Details</p>
                            <p class=\"text-md\">Order ID: {$order['id']}</p>
                            <p class=\"text-md\">Name: {$order['name']}</p>
                            <p class=\"text-md\">Email: {$order['email']}</p>
                            <p class=\"text-md\">Phone: {$order['phone']}</p>
                            <p class=\"text-md\">Address: {$order['address']}</p>
                            <p class=\"text-md\">Near: {$order['nearby']}</p>
                        </div>
                    </div>
                    <div class=\"flex flex-row mt-4 gap-4 justify-end \">
                        <button onclick=\"cancelOrder({$order['id']})\" class=\"bg-red-500 hover:bg-red-200 hover:text-red-700 font-semibold rounded-xl px-4 py-2 text-white \">
                            Cancel Order
                        </button>
                        <button onclick=\"cancelOrder({$order['id']})\" class=\"bg-green-500 hover:bg-green-200 hover:text-green-700 font-semibold rounded-xl px-4 py-2 text-white \">
                            Confirm Order
                        </button>
                        
                    </div>
                    
                </div>
            </div>";
        }
    } else {
        $output = '
        <div class=" flex flex-col items-center justify-center gap-2 rounded p-4 bg-white rounded-2xl w-full h-[50vh]">
            <span class="material-symbols-outlined text-4xl">search</span>
            <p class="text-xl">No Orders found</p>
            <p class="text-md">Please check back later</p>
        </div>';
    }
    echo $output;
}

if (isset($_POST['cancel-order'])) {
    $id = $_POST['id'];
    $result = cancelOrder($id);
    echo $result;
}

if(isset($_POST['order-num'])) {
    $orders = listOrders();
    $num = count($orders);
    echo $num;
}
?>