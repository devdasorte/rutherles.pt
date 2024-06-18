<?php
// Decodded
include app_path('Includes/settings.php');
if (!$_settings->info('license')) {
	exit();
}

echo '<style>' . "\n" . '    td.px-4.py-3 {' . "\n" . '    max-width: 240px;' . "\n" . '    text-wrap: pretty;' . "\n" . '}' . "\n" . '    </style>' . "\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\n" . '    <div class="container grid px-6 mx-auto">' . "\n" . '        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Afiliados' . "\n" . '        <a href="afiliados/novo" id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\n\t\t\t" . 'Cadastrar afiliado' . "\n\t\t" . '</button></a>' . "\n" . '        <a href="/afiliados/pagamento" id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\n\t\t\t" . 'Cadastrar pagamento' . "\n\t\t" . '</button></a>' . "\n" . '        </h2>' . "\n\n" . '        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3 mb-4">' . "\n" . '        <!-- Card -->' . "\n" . '        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\n" . '            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">' . "\n" . '            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">' . "\n" . '                <path' . "\n" . '                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">' . "\n" . '                </path>' . "\n" . '            </svg>' . "\n" . '            </div>' . "\n" . '            <div>' . "\n" . '            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\n" . '                Afiliados ativos' . "\n" . '            </p>' . "\n" . '            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\n" . '            ';
$productsQuery = $conn->query('SELECT COUNT(id) FROM referral WHERE status = 1');
$row = $productsQuery->fetch_assoc();
echo ($row['COUNT(id)'] ? $row['COUNT(id)'] : '0');
echo '            </p>' . "\n" . '            </div>' . "\n" . '        </div>' . "\n" . '        <!-- Card -->' . "\n" . '        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">' . "\n" . '            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">' . "\n" . '            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">' . "\n" . '            <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>' . "\n" . '            </svg>' . "\n" . '            </div>' . "\n" . '            <div>' . "\n" . '            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' . "\n" . '                Faturamento de afiliados' . "\n" . '            </p>' . "\n" . '            <div style="display: flex;">' . "\n" . '                <div id="hide-view" style="display:none; margin-right:5px;">' . "\n" . '                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\n" . '                ';
$queryFaturamento = $conn->query('SELECT SUM(total_amount) as total FROM order_list WHERE status = 2 AND referral_id IS NOT NULL');
$row = $queryFaturamento->fetch_assoc();
echo 'R$' . number_format(($row['total'] ? $row['total'] : 0), 2, ',', '.');
echo '                </p>' . "\n" . '                </div>' . "\n" . '                <button onclick="hideView()" class="text-lg font-semibold text-gray-700 dark:text-gray-200">' . "\n" . '                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">' . "\n" . '                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>' . "\n" . '                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>' . "\n" . '                </svg>' . "\n" . '                </button>' . "\n" . '            </div>' . "\n" . '            </div>' . "\n" . '        </div>' . "\n" . '        <!-- Fim Card -->' . "\n" . '        </div>' . "\n\n" . '    <div class="w-full overflow-hidden rounded-lg shadow-xs">' . "\n" . '        <div class="w-full overflow-x-auto">' . "\n" . '            <table class="w-full whitespace-no-wrap">' . "\n" . '                <thead>' . "\n" . '                    <tr' . "\n" . '                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"' . "\n" . '                    >               ' . "\n" . '                    <th class="px-4 py-3">Nome</th>' . "\n" . '                    <th class="px-4 py-3">Telefone</th>' . "\n" . '                    <th class="px-4 py-3">Valor pago</th>' . "\n" . '                    <th class="px-4 py-3">Valor pendente</th>' . "\n" . '                    <th class="px-4 py-3">Porcentagem</th>' . "\n" . '                    <th class="px-4 py-3">Status</th>' . "\n" . '                    <th class="px-4 py-3">Ação</th>' . "\n" . '                </tr>' . "\n" . '            </thead>' . "\n" . '            <tbody' . "\n" . '            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">' . "\n" . '            ';
$where = '';
$perPage = 20;
$page = (isset($_GET['pg']) ? $_GET['pg'] : 1);
$offset = $perPage * ($page - 1);
$totalResults = $conn->query('SELECT r.* FROM referral r ' . $where)->num_rows;
$totalPages = ceil($totalResults / $perPage);
$g_total = 0;
$i = 1;
$requests = $conn->query("\n" . '                SELECT r.id, c.firstname, c.lastname, c.phone, r.amount_pending, r.amount_paid, r.status, r.percentage' . "\n" . '                FROM referral r' . "\n" . '                INNER JOIN customer_list c ON r.customer_id = c.id' . "\n" . '                ' . $where . "\n" . '                GROUP BY r.customer_id' . "\n" . '                ORDER BY r.id DESC' . "\n" . '                LIMIT ' . $perPage . ' OFFSET ' . $offset . "\n" . '                ');

while ($row = $requests->fetch_assoc()) {
	echo '                <tr class="text-gray-700 dark:text-gray-400">' . "\n" . '                    <td class="px-4 py-3">';
	echo $row['firstname'];
	echo ' ';
	echo $row['lastname'];
	echo '</td>' . "\n" . '                    <td class="px-4 py-3">';
	echo formatPhoneNumber($row['phone']);
	echo '</td>' . "\n" . '                    <td class="px-4 py-3">R$ ';
	echo format_num($row['amount_paid'], 2);
	echo '</td>' . "\n" . '                    <td class="px-4 py-3">R$ ';
	echo format_num($row['amount_pending'], 2);
	echo '</td>' . "\n" . '                    <td class="px-4 py-3">';
	echo $row['percentage'] . '%';
	echo '</td>' . "\n" . '                    <td class="px-4 py-3">';

	switch ($row['status']) {
	case 1:
		echo 'Ativo';
		break;
	case 0:
		echo 'Inativo';
		break;
	}

	echo '</td>' . "\n" . '                    <td class="px-4 py-3">' . "\n" . '                        <div class="flex items-center space-x-2 text-sm">' . "\n" . '                            <a href="/afiliados/';
	echo $row['id'];
	echo '">' . "\n" . '                                <button title="Editar" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">' . "\n" . '                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' . "\n" . '                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>' . "\n" . '                                    </svg>' . "\n" . '                                </button>' . "\n" . '                            </a>' . "\n" . '                            <a class="delete_affiliate" href="javascript:void(0)" @click="openModal" data-id="';
	echo $row['id'];
	echo '">' . "\n" . '                                <button title="Deletar" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">' . "\n" . '                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">' . "\n" . '                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>' . "\n" . '                                </svg>' . "\n" . '                                </button>' . "\n" . '                            </a>' . "\n" . '                        </div>    ' . "\n" . '                    </td>' . "\n" . '                </tr>' . "\n" . '            ';
}

echo '        </tbody>' . "\n\n" . '    </table>' . "\n\n" . '</div>' . "\n" . '<div' . "\n" . 'class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"' . "\n" . '>' . "\n" . '<span class="flex items-center col-span-3">' . "\n" . '</span>' . "\n" . '<span class="col-span-2"></span>' . "\n\n" . '<!-- Pagination -->' . "\n";

if (0 < $totalPages) {
	echo '    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">' . "\n" . '        <nav aria-label="Table navigation">' . "\n" . '            <ul class="inline-flex items-center">' . "\n\n" . '                ';

	if (1 < $page) {
		echo '                    <a href=\'./?page=ranking&pg=';
		echo $page - 1;
		echo '\'><li>' . "\n" . '                        <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">' . "\n" . '                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">' . "\n" . '                        <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>' . "\n" . '                    </svg>' . "\n" . '                </button>' . "\n" . '            </li></a>' . "\n" . '        ';
	}

	echo "\n" . '        ';

	if (3 < $page) {
		echo '            <a href="/afiliados?&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>' . "\n" . '            <li class="dots">...</li>' . "\n" . '        ';
	}

	echo "\n" . '        ';

	if (0 < ($page - 2)) {
		echo '            <a href="/afiliados?&pg=';
		echo $page - 2;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page - 2;
		echo '</button></li></a>' . "\n" . '        ';
	}

	echo "\n" . '        ';

	if (0 < ($page - 1)) {
		echo '            <a href="/afiliados?&pg=';
		echo $page - 1;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page - 1;
		echo '</button></li></a>' . "\n" . '        ';
	}

	echo "\n" . '        <a href="/afiliados?&pg=';
	echo $page;
	echo '">' . "\n" . '            <li>' . "\n" . '                <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page;
	echo '</button>' . "\n" . '            </li>' . "\n" . '        </a>' . "\n" . '        ';

	if (($page + 1) < ($totalPages + 1)) {
		echo '            <a href="/afiliados?&pg=';
		echo $page + 1;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page + 1;
		echo '</button></li></a>   ' . "\n" . '        ';
	}

	echo "\n" . '        ';

	if (($page + 2) < ($totalPages + 1)) {
		echo '            <a href="/afiliados?&pg=';
		echo $page + 2;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page + 2;
		echo '</button></li></a>' . "\n" . '        ';
	}

	echo "\n" . '        ';

	if ($page < ($totalPages - 2)) {
		echo '            <li class="dots">...</li>' . "\n" . '            <a href="/afiliados?&pg=';
		echo $totalPages;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $totalPages;
		echo '</button></li></a>' . "\n" . '        ';
	}

	echo "\n\n" . '        ';

	if ($page < $totalPages) {
		echo '            ' . "\n" . '            <a href="/afiliados?&pg=';
		echo $page + 1;
		echo '"><li>' . "\n" . '                <button' . "\n" . '                class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"' . "\n" . '                aria-label="Next"' . "\n" . '                >' . "\n" . '                <svg' . "\n" . '                class="w-4 h-4 fill-current"' . "\n" . '                aria-hidden="true"' . "\n" . '                viewBox="0 0 20 20"' . "\n" . '                >' . "\n" . '                <path' . "\n" . '                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"' . "\n" . '                clip-rule="evenodd"' . "\n" . '                fill-rule="evenodd"' . "\n" . '                ></path>' . "\n" . '            </svg>' . "\n" . '        </button>' . "\n" . '    </li>' . "\n" . '</a>' . "\n";
	}

	echo "\n" . '</ul>' . "\n" . '</nav>' . "\n" . '</span>' . "\n" . '<!-- End pagination -->' . "\n";
}

echo "\n" . '</div>' . "\n" . '</div>' . "\n" . '</div>' . "\n" . '</main>' . "\n\n" . '<!-- Modal Delete -->' . "\n" . '<div  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">' . "\n\t" . '<!-- Modal -->' . "\n\t" . '<div  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">' . "\n\t\t" . '<!-- Remove header if you don\'t want a close icon. Use modal body to place modal tile. -->' . "\n\t\t" . '<header class="flex justify-end">' . "\n\t\t\t" . '<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">' . "\n\t\t\t\t" . '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">' . "\n\t\t\t\t\t" . '<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>' . "\n\t\t\t\t" . '</svg>' . "\n\t\t\t" . '</button>' . "\n\t\t" . '</header>' . "\n\t\t" . '<div class="mt-4 mb-6">' . "\n\t\t\t" . '<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">' . "\n\t\t\t\t" . 'Deseja excluir?' . "\n\t\t\t" . '</p>' . "\n\t\t\t" . '<p class="text-sm text-gray-700 dark:text-gray-400">' . "\n\t\t\t\t" . 'Você realmente deseja excluir esse campanha?' . "\n\t\t\t" . '</p>' . "\n\t\t" . '</div>' . "\n\t\t" . '<footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">' . "\n\t\t\t" . '<button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">' . "\n\t\t\t\t" . 'Não' . "\n\t\t\t" . '</button>' . "\n\t\t\t" . '<button class="delete_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\n\t\t\t\t" . 'Sim' . "\n\t\t\t" . '</button>' . "\n\t\t" . '</footer>' . "\n\t" . '</div>' . "\n" . '</div>' . "\n" . '<!-- End Modal Delete -->' . "\n\n" . '<script>' . "\n" . '    function hideView() {' . "\n" . '        var x = document.getElementById("hide-view");' . "\n" . '        if (x.style.display === "none") {' . "\n" . '        x.style.display = "block";' . "\n" . '        } else {' . "\n" . '        x.style.display = "none";' . "\n" . '        }' . "\n" . '    }' . "\n\n" . '    $(function(){' . "\n" . '        $(\'#filter-form\').submit(function(e){' . "\n" . '            e.preventDefault()' . "\n" . '            location.href = \'./?page=ranking&\'+$(this).serialize()' . "\n" . '        })' . "\n\n\n" . '    })' . "\n\n" . '    $(document).ready(function(){' . "\n\t\t" . '$(\'.delete_affiliate\').click(function(){' . "\n\t\t\t" . 'var id = $(this).attr(\'data-id\');' . "\n\t\t\t" . '$(\'.delete_data\').attr(\'data-id\', id);' . "\t\n\t\t" . '})' . "\n\t\t" . '$(\'.delete_data\').click(function(){' . "\n\t\t\t" . 'var id = $(this).attr(\'data-id\');' . "\n\t\t\t" . 'delete_affiliate(id)' . "\t\n\t\t" . '})' . "\n\n\t" . '})' . "\n\n" . '    function delete_affiliate($id){' . "\n\t\t" . '$.ajax({' . "\n\t\t\t" . 'url:_base_url_+"classes/Master.php?f=delete_affiliate",' . "\n\t\t\t" . 'method:"POST",' . "\n\t\t\t" . 'data:{id: $id},' . "\n\t\t\t" . 'dataType:"json",' . "\n\t\t\t" . 'error:err=>{' . "\n\t\t\t\t" . 'console.log(err)' . "\n\t\t\t\t" . 'alert("[AP01] - An error occured.");' . "\n\t\t\t" . '},' . "\n\t\t\t" . 'success:function(resp){' . "\n\t\t\t\t" . 'if(typeof resp== \'object\' && resp.status == \'success\'){' . "\n\t\t\t\t\t" . 'location.reload();' . "\n\t\t\t\t" . '}else{' . "\n\t\t\t\t\t" . 'alert("[AP02] - An error occured.");' . "\n\t\t\t\t" . '}' . "\n\t\t\t" . '}' . "\n\t\t" . '})' . "\n\t" . '}' . "\n" . '</script>';

?>