<?php
use App\Models\OrderItem;


$orderitem = Cache::remember("orderitem_{$id}", 60, function () use ($id) {
    return OrderItem::where('id', $id)->first();
});
$status = $orderitem->status;

$my_numbers = 0;
$my_numbers = $orderitem->order_numbers;
$my_numbers = explode(',', $my_numbers);

// Inicialize a página atual com base no parâmetro da URL ou padrão para 1
$current_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

// Defina o limite de itens por página
$limit = 152;

// Calcule o offset para array_slice
$offset = ($current_page - 1) * $limit;

// Faça o slicing do array com base no offset e limite
$sliced_numbers = array_slice($my_numbers, $offset, $limit);

$status = (isset($status) ? $status : '');

?>

<style>
    .order_numbers {
        padding: 10px;
        max-width: 150px;
        white-space: nowrap;
        overflow: auto;
    }
</style>

<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            #<?php echo (isset($id) ? $id : ''); ?> Detalhes
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pedido:</span>
                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="#<?php echo (isset($id) ? $id : ''); ?>" disabled/>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Status</span>
                <select name="order_status" id="order_status" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Pendente</option>
                    <option value="2" <?php if ($status == 2) echo 'selected'; ?>>Pago</option>
                    <option value="3" <?php if ($status == 3) echo 'selected'; ?>>Cancelado</option>
                </select>
            </label>

            <?php
            $gt = 0;
            $order_items = $conn->query('SELECT oi.*, p.name as product, p.price, p.image_path, p.type_of_draw, ol.quantity as order_quantity, ol.discount_amount FROM `order_items` oi INNER JOIN product_list p ON oi.product_id = p.id INNER JOIN order_list ol ON oi.order_id = ol.id WHERE oi.order_id = \'' . $id . '\'');
            $order_total = $conn->query('SELECT total_amount FROM `order_list` WHERE `id` = \'' . $id . '\'');
            $total = $order_total->fetch_assoc();

            while ($row = $order_items->fetch_assoc()) {
                $gt += $row['price'] * $row['order_quantity'];
            ?>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Campanha</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?php echo $row['product']; ?>" disabled/>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Quantidade de cotas</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?php echo $row['order_quantity']; ?>" disabled/>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Valor da cota</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?php echo format_num($row['price'], 2); ?>" disabled/>
            </label>

            <?php if ($row['discount_amount']) {
                $subtotal = $total['total_amount'] + $row['discount_amount'];
                $subtotal = format_num($subtotal, 2);
            ?>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Subtotal</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?php echo $subtotal; ?>" disabled/>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Desconto</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?php echo format_num($row['discount_amount'], 2); ?>" disabled/>
            </label>

            <?php } ?>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Total</span>
                <input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?php echo format_num($total['total_amount'], 2); ?>" disabled/>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Cotas</span>
                <div style="border:none" class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 form-textarea  focus:shadow-outline-purple " rows="3" placeholder="Descrição da campanha" disabled>
                <div class="result font-xs  row" data-nosnippet="true" style="overflow:hidden;">
                        <?php
        if ($type_of_draw > 1) {
            echo leowp_format_luck_numbers($my_numbers, $row['qty_numbers'], $class = 'alert-success', $opt = true, $type_of_draw);
        }  else {
            echo leowp_format_luck_numbers($sliced_numbers, $limit, $class = 'alert-success', $opt = true, $type_of_draw);

        ?>
                    </div>
                    <div style="margin-top: 16px">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?p<?php echo $current_page - 1; ?>">
                                         <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                // Calcule o número total de páginas
                                $total_pages = ceil(count($my_numbers) / $limit);
                                
                                // Mostre a página anterior, atual e próxima
                                if ($current_page > 1 ) {
                                    echo '<li class="page-item"><a class="page-link" href="?p=' . ($current_page - 1) . '" >' . ($current_page - 1) . '</a></li>';
                                }
                                echo '<li class="page-item active"><a class="page-link" href="?p=' . $current_page . '" >' . $current_page . '</a></li>';
                               if ($total_pages > $current_page){
                                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                               }
                                ?>
                                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?p=<?php echo $current_page + 1; ?>" >
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?php } ?>
                </div>
            </label>

            <?php } ?>

        </div>
    </div>
</main>

<script>
    $(function(){
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this order permanently?","delete_order", ["<?php echo (isset($id) ? $id : ''); ?>"])
        })
        $('#order_status').on('change', function() {
            let status = $('#order_status').val();
            update_order_status('<?php echo (isset($id) ? $id : ''); ?>', status);
        })
    })

    function delete_order($id){
        $.ajax({
            url: _base_url_ + "class/Main.php?action=delete_order",
              headers: {"X-CSRF-TOKEN": $(`meta[name="csrf-token"]`).attr("content")},
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: err => {
                console.log(err)
                alert("[AO11] - An error occured.");
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success'){
                   show_toastr('Sucesso!',`pedido deletado com sucesso!`,'success' );
                      location.reload();
                } else {
                    alert("[AO12] - An error occured.");
                }
            }
        })
    }

    function update_order_status($id, $status){
        $.ajax({
            url: _base_url_ + "class/Main.php?action=update_order_status_sys",
            headers: {"X-CSRF-TOKEN": $(`meta[name="csrf-token"]`).attr("content")},
            method: "POST",
            data: {id: $id, status: $status},
            dataType: "json",
            error: err => {
                console.log(err)
                alert("[AO13] - An error occured.");
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success'){
                    show_toastr('Sucesso!',`Pedido atualizado com sucesso!`,'success' );
                       Livewire.navigate('/pedidos')
                } else {
                    alert("[AO14] - An error occured.");
                }
            }
        })
    }
</script>
