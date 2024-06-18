<?php
// Decodded
include app_path('Includes/settings.php');

if (isset($_GET['id']) && 0 < $_GET['id']) {
    $qry = $conn->query('SELECT r.*, c.* FROM referral r INNER JOIN customer_list c ON c.id = r.customer_id WHERE r.id = \'' . $_GET['id'] . '\' ');

    if (0 < $qry->num_rows) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}

echo '<style>' . "\r\n\t" . '#cimg{max-width:100%;max-height:25em;object-fit:scale-down;object-position:center center;}' . "\r\n" . '</style>' . "\r\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\r\n\t" . '<div class="container px-6 mx-auto grid">' . "\r\n\t\t" . '<h2' . "\r\n\t\t" . 'class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"' . "\r\n\t\t" . '>' . "\r\n\t\t";
echo (isset($id) ? 'Editar afiliado' : 'Novo afiliado');
echo ' <a href="./?page=affiliates"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\r\n\t\t\t" . 'Voltar' . "\r\n\t\t" . '</button></a>' . "\r\n\t" . '</h2>' . "\r\n\r\n\t" . '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' . "\r\n\t\t" . '<form action="" id="manage-order" autocomplete="off">' . "\t\r\n\r\n\t\t\t";

if ($id) {
    echo "\t\t\t\t" . '<label class="block text-sm mb-2">' . "\r\n\t\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Nome</span>' . "\r\n\t\t\t\t\t" . '<input name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t\t" . 'placeholder="Informe o telefone do afiliado" disabled value="';
    echo (isset($firstname) ? $firstname . ' ' . $lastname : '');
    echo '"/>' . "\r\n\t\t\t\t" . '</label>' . "\r\n\t\t\t";
}

echo "\r\n" . '            <label class="block text-sm mb-2">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Telefone</span>' . "\r\n\t\t\t\t" . '<input name="customer" id="customer" type="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . 'placeholder="Informe o telefone do afiliado" value="';
echo (isset($phone) ? $phone : '');
echo '"/>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n" . '            <label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Comissão</span>' . "\r\n\t\t\t\t" . '<input name="percentage" id="percentage" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . 'placeholder="10" value="';
echo (isset($percentage) ? $percentage : '');
echo '"/>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n\t\t\t" . '<label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Status</span>' . "\r\n\t\t\t\t" . '<select name="status" id="status" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">' . "\r\n\t\t\t\t\t" . '<option value="1" ';
echo (isset($status) && $qty_numbers == '1' ? 'selected' : '');
echo '>Ativo</option>' . "\r\n\t\t\t\t\t" . '<option value="0" ';
echo (isset($status) && $status == '0' ? 'selected' : '');
echo '>Inativo</option>' . "\r\n\t\t\t\t" . '</select>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n\t\t" . '</form>' . "\r\n\r\n\t" . '</div>' . "\r\n\r\n\t" . '<div class="mt-2">' . "\r\n\t\t" . '<button form="manage-order" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\r\n\t\t\t";
echo ($id ? 'Atualizar' : 'Cadastrar');
echo "\t\t" . '</button>' . "\r\n\t" . '</div>' . "\r\n" . '</main>' . "\r\n" . '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>' . "\r\n" . '<script>' . "\r\n\t\t\t" . '$(\'#manage-order\').submit(function(e){' . "\r\n\t\t\t\t" . 'e.preventDefault();' . "\r\n\t\t\t\t" . '$.ajax({' . "\r\n\t\t\t\t\t" . 'url:_base_url_+\'class/Main.php?action=create_affiliate\',' . "\r\n\t\t\t\t\t" . 'data: new FormData($(this)[0]),' . "\r\n\t\t\t\t\t" . 'cache: false,' . "\r\n\t\t\t\t\t" . 'contentType: false,' . "\r\n\t\t\t\t\t" . 'processData: false,' . "\r\n\t\t\t\t\t" . 'method: \'POST\',' . "\r\n\t\t\t\t\t" . 'type: \'POST\',' . "\r\n\t\t\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t\t\t" . 'var returnedData = JSON.parse(resp);' . "\r\n\t\t\t\t\t\t" . 'if(returnedData.status == \'success\'){' . "\r\n\t\t\t\t\t\t\t" . '//alert(\'Afiliado cadastrado com sucesso!\');' . "\r\n\t\t\t\t\t\t\t" . 'alert(returnedData.msg);' . "\r\n\t\t\t\t\t\t\t" . 'location.href=\'./?page=affiliates\';' . "\r\n\t\t\t\t\t\t" . '} else if(returnedData.status == \'failed\'){' . "\r\n\t\t\t\t\t\t\t" . '//alert(returnedData.msg);' . "\r\n\t\t\t\t\t\t\t" . 'alert(returnedData.msg);' . "\r\n\t\t\t\t\t\t" . '} else {' . "\r\n\t\t\t\t\t\t\t" . 'console.log(resp)' . "\r\n\t\t\t\t\t\t\t" . 'alert("[CP01] - Erro ao cadastrar pagamento");' . "\t\t\t\t\t\t\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . '}' . "\r\n\t\t\t\t" . '})' . "\r\n\t\t\t" . '})' . "\r\n" . '</script>';
