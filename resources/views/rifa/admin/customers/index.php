 <?php isset($_GET['customer_name']) ? $customer_name = $_GET['customer_name'] : $customer_name = ''; ?>
 <?php isset($_GET['customer_phone']) ? $customer_phone = $_GET['customer_phone'] : $customer_phone = ''; ?>
 <?php isset($_GET['customer_cpf']) ? $customer_cpf = $_GET['customer_cpf'] : $customer_cpf = ''; ?>
 <?php isset($_GET['customer_email']) ? $customer_email = $_GET['customer_email'] : $customer_email = ''; ?>
<?php include app_path('Includes/settings.php');
?>

 <style>
     @media (max-width: 40em) {
         .filtro-busca {
             display: block !important;
         }
     }

     @media only screen and (max-width: 600px) {
         .fb-2 {
             margin-top: 10px;
             width: 100%;
         }
     }

     @media only screen and (max-width: 600px) {
         .fb-2 {
             margin-top: 10px;
             width: 100%;
         }
     }

     .exportar-contatos {
         display: inline-block;
         margin-bottom: 10px;
     }
 </style>
 <main class="h-full pb-16 overflow-y-auto">
     <div class="container grid px-6 mx-auto">
         <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
             Clientes <a href="/clientes-novo" wire:navigate id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                     Cadastrar novo
                 </button></a>

         </h2>
         <form action="" id="filter-form" style="margin-bottom:10px" method="GET">
             <div class="flex filtro-busca">
                 <input name="customer_name" id="customer_name" value="" class="mt-1 mr-2 pl-3 pr-3 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pesquisar por nome">
                 <input name="customer_phone" id="customer_phone" value="" class="mt-1 mr-2 pl-3 pr-3 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pesquisar por telefone">
                 <input name="customer_cpf" id="customer_cpf" value="" class="mt-1 mr-2 pl-3 pr-3 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pesquisar por CPF" maxlength="14">
                 <input name="customer_email" id="customer_email" value="" class="mt-1 mr-2 pl-3 pr-3 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pesquisar por email">
                 <button class="fb-2 px-5 py-2 font-medium leading-5 text-white transition-colors mt-1 duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>
             </div>
         </form>
         <button onclick="export_customers()" class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple exportar-contatos"> Exportar Clientes</button>

         <div style="overflow:hidden !important" class="w-full overflow-hidden rounded-lg shadow-xs">
             <div class="w-full overflow-x-auto pb-1">
                 <table class="w-full whitespace-no-wrap">
                     <thead>
                         <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                             <th class="px-4 py-3">Foto</th>
                             <th class="px-4 py-3">Nome</th>
                             <th class="px-4 py-3">E-mail</th>
                             <th class="px-4 py-3">Telefone</th>
                             <th class="px-4 py-3">Data de cadastro</th>
                             <th class="px-4 py-3">Ação</th>
                         </tr>
                     </thead>
                     <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                         <?php
                            $perPage = 20;
                            $page = isset($_GET['pg']) ? $_GET['pg'] : 1;
                            $offset = ($page - 1) * $perPage;
                            $totalResults = $conn->query('SELECT * FROM customer_list')->num_rows;
                            $totalPages = ceil($totalResults / $perPage);
                            $i = 1;
                            $qry = $conn->query("SELECT *  from `customer_list` order by `firstname` asc LIMIT {$perPage} OFFSET {$offset}");

                            while ($row = $qry->fetch_assoc()) :
                                if (
                                    (!empty($customer_name) && $row['firstname'] != null  && strpos(strtolower($row['firstname'] . $row['lastname']), strtolower($customer_name)) !== false) ||
                                    (!empty($customer_email) && $row['email'] != null  && strpos(strtolower($row['email']), strtolower($customer_email)) !== false) ||
                                    (!empty($customer_phone) && $row['phone'] != null && strpos(strtolower($row['phone']), strtolower($customer_phone)) !== false) ||
                                    (!empty($customer_cpf) && $row['cpf'] != null && strpos(strtolower($row['cpf']), strtolower($customer_cpf)) !== false) ||
                                    (empty($customer_name) && empty($customer_email) && empty($customer_phone) && empty($customer_cpf))
                                ) :






                            ?>
                                 <tr class="text-gray-700 dark:text-gray-400">
                                     <td class="px-4 py-3 text-sm">
                                         <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                             <img class="object-cover w-full h-full rounded-full" src="<?= validate_image($row['avatar']) ?>" alt="" loading="lazy">
                                             <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                         </div>
                                     </td>
                                     <td class="px-4 py-3">
                                         <?= $row['firstname'] . ' ' . $row['lastname'] ?>
                                     </td>
                                     <td class="px-4 py-3">
                                         <?= $row['email'] ?>
                                     </td>
                                     <td class="px-4 py-3">
                                         <?= formatPhoneNumber($row['phone']) ?>
                                     </td>
                                     <td class="px-4 py-3 text-sm">
                                         <?= date("d-m-Y H:i", strtotime($row['date_created'])) ?>
                                     </td>
                                     <td class="px-4 py-3">
                                         <div class="flex items-center space-x-4 text-sm">
                                             <a href="/clientes/<?= $row['id'] ?>" wire:navigate>
                                                 <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                                     <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                         <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                     </svg>
                                                 </button>
                                             </a>
                                             <a class="delete_customer" href="javascript:void(0)" @click="openModal" data-id="<?= $row['id'] ?>">
                                                 <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                     <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                         <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                     </svg>
                                                 </button>
                                             </a>
                                         </div>
                                     </td>
                                 </tr>
                         <?php
                                endif;
                            endwhile;
                            ?>

                     </tbody>
                 </table>
             </div>
             <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                 <span class="flex items-center col-span-3">
                 </span>
                 <span class="col-span-2"></span>

                 <!-- Pagination -->
                 <?php if ($totalPages > 0) { ?>
                     <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                         <nav aria-label="Table navigation">
                             <ul class="inline-flex items-center">

                                 <?php if ($page > 1) { ?>
                                     <a href='/clientes?pg=<?php echo $page - 1 ?>' wire:navigate>
                                         <li>
                                             <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                                                 <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                                     <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                                 </svg>
                                             </button>
                                         </li>
                                     </a>
                                 <?php } ?>

                                 <?php if ($page > 3) { ?>
                                     <a href="/clientes?pg=1">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li>
                                     </a>
                                     <li class="dots">...</li>
                                 <?php } ?>

                                 <?php if ($page - 2 > 0) { ?>
                                     <a href="/clientes?pg=<?php echo $page - 2 ?>">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page - 2 ?></button></li>
                                     </a>
                                 <?php } ?>

                                 <?php if ($page - 1 > 0) { ?>
                                     <a href="/clientes?pg=<?php echo $page - 1 ?>">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page - 1 ?></button></li>
                                     </a>
                                 <?php } ?>

                                 <a href="/clientes?pg=<?php echo $page; ?>">
                                     <li>
                                         <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page; ?></button>
                                     </li>
                                 </a>
                                 <?php if ($page + 1 < $totalPages + 1) { ?>
                                     <a href="/clientes?pg=<?php echo $page + 1 ?>">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page + 1 ?></button></li>
                                     </a>
                                 <?php } ?>

                                 <?php if ($page + 2 < $totalPages + 1) { ?>
                                     <a href="/clientes?pg=<?php echo $page + 2 ?>">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page + 2 ?></button></li>
                                     </a>
                                 <?php } ?>

                                 <?php if ($page < $totalPages - 2) : ?>
                                     <li class="dots">...</li>
                                     <a href="/clientes?pg=<?php echo $totalPages ?>">
                                         <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $totalPages ?></button></li>
                                     </a>
                                 <?php endif; ?>


                                 <?php if ($page < $totalPages) { ?>
                                     <a href="/clientes?pg=<?php echo $page + 1 ?>">
                                         <li>
                                             <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                                                 <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                                     <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                                 </svg>
                                             </button>
                                         </li>
                                     </a>
                                 <?php } ?>

                             </ul>
                         </nav>
                     </span>
                     <!-- End pagination -->
                 <?php } ?>

             </div>
         </div>
     </div>


 <!-- Modal Delete -->
 <div  x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
     <!-- Modal -->
     <div  x-show="isModalOpen"  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">
         <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
         <header class="flex justify-end">
             <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                 <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                     <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                 </svg>
             </button>
         </header>
         <div class="mt-4 mb-6">
             <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                 Deseja excluir?
             </p>
             <p class="text-sm text-gray-700 dark:text-gray-400">
                 Você realmente deseja excluir esse cliente?
             </p>
         </div>
         <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
             <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                 Não
             </button>
             <button class="delete_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                 Sim
             </button>
         </footer>
     </div>
 </div>

 <!-- End Modal Delete -->
 <script>
     $(document).ready(function() {
         $('.delete_customer').click(function() {
             var id = $(this).attr('data-id');
             $('.delete_data').attr('data-id', id);
         })
         $('.delete_data').click(function() {
             var id = $(this).attr('data-id');
             delete_customer(id);
         })

     })

     function delete_customer($id) {
         $.ajax({
             url: _base_url_ + "customer/Customer.php?action=delete_system_customer",
                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

             method: "POST",
             data: {
                 id: $id
             },
             dataType: "json",
             error: err => {
                 console.log(err)
                 alert("An error occured.");

             },
             success: function(resp) {
                 if (typeof resp == 'object' && resp.status == 'success') {
                    show_toastr('Parabéns!', `Cliente deletado com sucesso!`, 'success');
                     location.reload();
                 } else {
                     alert("An error occured.");

                 }
             }
         })
     }

    function export_customers() {
		var name = $('#customer_name').val();
		var phone = $('#customer_phone').val();
		var email = $('#customer_email').val();
		
		// Montar a URL do download
		var downloadURL = _base_url_ + "class/Main.php?action=export_customers&name=" + name + "&phone=" + phone + "&email=" + email;

		// Redirecionar o navegador para a URL de download
		window.location.href = downloadURL;
	}

     function fMasc(objeto, mascara) {
         obj = objeto
         masc = mascara
         setTimeout("fMascEx()", 1)
     }

     function fMascEx() {
         obj.value = masc(obj.value)
     }

     function mCPF(cpf) {
         cpf = cpf.replace(/\D/g, "")
         cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
         cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
         cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
         return cpf
     }

     function mTel(tel) {
         tel = tel.replace(/\D/g, "")
         tel = tel.replace(/^(\d)/, "($1")
         tel = tel.replace(/(.{3})(\d)/, "$1) $2")
         if (tel.length == 9) {
             tel = tel.replace(/(.{1})$/, "-$1")
         } else if (tel.length == 10) {
             tel = tel.replace(/(.{2})$/, "-$1")
         } else if (tel.length == 11) {
             tel = tel.replace(/(.{3})$/, "-$1")
         } else if (tel.length == 12) {
             tel = tel.replace(/(.{4})$/, "-$1")
         } else if (tel.length > 12) {
             tel = tel.replace(/(.{4})$/, "-$1")
         }
         return tel;
     }
     $('.click').on('click', function() {
         if ($('#customer_name').val() == '' && $('#customer_phone').val() == '' && $('#customer_cpf').val() == '' && $('#customer_email').val() == '') {
             Livewire.navigate('/clientes');
             return;
         }
         $("#filter-form").submit();
     });

     $(function() {
         $('#filter-form').submit(function(e) {

             e.preventDefault()
             location.href = '/clientes?' + $(this).serialize()
         })
     })
 </script>