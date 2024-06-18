 <?php
    $product_id = isset($product_id) ? $product_id : '';
    $active = ''
    ?>

 <main class="h-full pb-16 overflow-y-auto">
     <div class="container px-6 mx-auto grid">
         <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
             Novo pedido <a href="/pedidos" wire:navigate><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                     Voltar
                 </button></a>
         </h2>


         <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <?php 
    $qry = $conn->query("SELECT * FROM product_list ");
    ?>

    <form action="" name="manage-order" id="manage-order" autocomplete="off">
        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">Campanha</span>
            <select 
                onchange="changeProduct(
                    '<?php echo isset($row['id']) && $row['id'] == $product_id ? $row['id'] : '' ?>', 
                    '<?php echo isset($row['qty_numbers']) && $row['id'] == $product_id ? $row['qty_numbers'] : '' ?>'
                )" 
                name="product_id" 
                id="product_id" 
                class="mr-2 mb-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
            >
           
            <?php 
            while ($row = $qry->fetch_assoc()) : ?>
                <option value="<?php echo $row['id'] ?>" <?php echo $product_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
            <?php endwhile; ?>

            </select>
        </label>
                 <label class="block text-sm mb-2">
                     <span class="text-gray-700 dark:text-gray-400">Cliente</span>
                     <select <?php if (isset($_GET['customer_id'])) {
                                    echo '';
                                } ?> name="phone" id="phone" class="pl-3 pr-8  mt-1 mr-2 block w-full  text-sm  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select  focus:border-purple-400 focus:outline-0   font-medium leading-5  py-2 rounded-lg">




                         <?php

                            $qry = $conn->query("SELECT * FROM `customer_list`");
                            while ($row = $qry->fetch_assoc()) { ?>
                             <option value="<?= $row['phone'] ?>" <?php
                                                                $customer_id =  (isset($_GET['customer_id']) ? $_GET['customer_id'] : '');
                                                                if ($customer_id == $row['id']) {
                                                                    echo 'selected';
                                                                } ?>><?= $row['firstname'] . ' ' . $row['lastname'] ?></option>


                         <?php }  ?>
                         <option value="0" <?php
                                            if (isset($_GET['customer_id']) == '' || $qry->num_rows < 1) {
                                                echo 'selected';
                                            } ?>>
                             <?php
                                if ($qry->num_rows < 1) {
                                    echo 'Nenhum cliente disponível';
                                } else {
                                    echo 'Selecione o cliente';
                                }
                                ?>
                         </option>
                     </select>
                 </label>

                 <label class="block text-sm mb-2">
                     <span class="text-gray-700 dark:text-gray-400">Quantidade</span>
                     <input name="quantity" id="quantity" type="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Números">
                 </label>

                 <label class="block text-sm mb-2">
                     <span class="text-gray-700 dark:text-gray-400">Números</span>
                     <p style="font-size:13px;color: orange;font-style:italic;"><strong>ATENÇÃO! </strong>Adicione os números com a quantidade correta de dígitos separados com vírgula e sem espaços, ex.: <strong>12345,54321,11111,22222</strong></p>
                     <input name="order_numbers" id="order_numbers" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Números">
                 </label>

                 <label class="block mt-4 text-sm">
                     <span class="text-gray-700 dark:text-gray-400">Valor</span>
                     <input name="total_amount" id="total_amount" type="number" step="0.01" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="10,00">
                 </label>

                 <label class="block mt-4 text-sm">
                     <span class="text-gray-700 dark:text-gray-400">
                         Status
                     </span>
                     <select name="status" id="status" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                         <option value="">Selecione</option>
                         <option value="1">Pendente</option>
                         <option value="2">Aprovado</option>
                     </select>
                 </label>
             </form>

         </div>

         <div class="mt-2">
             <button form="manage-order" class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                 Salvar
             </button>
         </div>

     </div>
 </main>

 <script>
     $(document).ready(function() {
         $('#manage-order').submit(function(e) {
             e.preventDefault()

             $.ajax({
                 url: _base_url_ + "class/Main.php?action=create_order",
                                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                 data: new FormData($(this)[0]),
                 cache: false,
                 contentType: false,
                 processData: false,
                 method: 'POST',
                 type: 'POST',
                 dataType: 'json',
                 error: err => {
                     console.error(err)
                 },
                 success: function(resp) {
                     console.log(resp)
                     if (resp.status === 'success') {
                         show_toastr('Parabéns!','Pedido criado com sucesso!','success' )

                         Livewire.navigate('/pedidos')
                     } else {
                         alert('Falha ao criar o pedido: ' + resp.err);
                     }
                 }
             })
         })


     })

     function changeProduct(price, qty_numbers) {
         $('#total_amount').val(price)
         $('#quantity').attr('max', qty_numbers)


     }



     $('#order_numbers').on('blur', function() {
         let qty = parseInt($('#quantity').val(), 10);
         let value = $(this).val();
         if (value.slice(-1) === ',') {
             value = value.slice(0, -1); // remove the last comma
         }
         let order_numbers = value.split(',').length;

         console.log(order_numbers);
         let max = parseInt($('#quantity').attr('max'), 10);
         if (order_numbers > qty) {
             alert('Quantidade de números excedida');
             return;
         } else if (order_numbers < qty) {
             alert('Quantidade de números insuficiente');
             return;
         }
     });
 </script>