
<?php
include app_path('Includes/settings.php');
?>

<link rel="stylesheet" href="{{ asset('assets/admin/css/tailwind.output.css') }}" id="main-style-link">

  
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Dashboard</h2>

        <!--Busca Ganhador x Ranking -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <!-- Card -->
            <div class="items-center  p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="w-full" id="searchganhadores">
                    <p class=" text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">BUSCAR GANHADOR</p>
                    <form action="" id="buscar-ganhador" style="margin-bottom:10px">
                        <div class="flex items-end gap-2">
                            <div class="w-5/12 mr-2" style="align-items: center;">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Campanha</p>
                                <select name="raffle" id="raffle"
                                    class=" block w-full text-sm pl-3 pr-8  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">

                                    <option selected value="">Selecione a campanha </option>
                                    <?php
                                    $qry = $conn->query("SELECT * FROM `product_list`");
                                    while ($row = $qry->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?php if ($raffle == $row['id']) {
                                        echo 'selected';
                                    } ?>><?= $row['name'] ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                            <div class="w-5/12 mr-2" style="align-items: center;">
                                <p class=" text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Número</p>
                                <input type="text" id="number" name="number"
                                    class="form-input  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg"
                                    placeholder="12345">
                            </div>
                            <span id="get-ganhador"
                                class="px-45 py-2 pointer-events-auto cursor-pointer	 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar">Buscar</span>
                        </div>
                        @csrf
                    </form>
                    <p>
                        <span id="error" class="text-sm text-red-600"></span>

                    </p>
                    <p id="winner_info" class="text-gray-700 dark:text-gray-200 winner-info hidden">
                        <span class="text-sm" id="order"></span>
                        <span class="text-sm" id="name"></span>
                        <span class="text-sm" id="phone"></span>
                        <span class="text-sm" id="campanha_name"></span>
                        <span class="text-sm" id="pedido"></span>
                        <span class="text-sm" id="date"></span>
                        <span class="text-sm" id="quantity"></span>
                        <span class="text-sm" id="value"></span>
                        <span class="text-sm" id="payment_status"></span>



                        <span class="text-sm" id="cota" style="max-width:80%"></span>




                        
                        <span class="winner"></span>
                        <input type="hidden" id="winner_id" name="winner_id">
                        <input type="hidden" id="raffle_id" name="raffle_id">
                        <input type="hidden" id="winner_phone" name="winner_phone">
                        <input type="hidden" id="winner_number" name="winner_number">


                    <div class="span-whats hidden" id="span-whats">
                        <a target="_blank" id="btn-whats"
                            href="https://api.whatsapp.com/send?phone=5587988553793&amp;text=Olá, , você foi o ganhador da campanha Golf GTI 2.0 TSI GTI com o número ! Parabéns!"
                            class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple ">
                            <svg fill="#ffffff" height="54" width="54" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 308.00 308.00" xml:space="preserve" stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                    stroke="#CCCCCC" stroke-width="9.856"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="XMLID_468_">
                                        <path
                                            d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156 c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687 c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887 c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153 c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348 c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802 c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922 c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0 c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458 C233.168,179.508,230.845,178.393,227.904,176.981z">
                                        </path>
                                        <path
                                            d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716 c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396 c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188 l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677 c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867 C276.546,215.678,222.799,268.994,156.734,268.994z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            Contato
                        </a>
                        @csrf

                        <button id="btn-vencedor"
                            class="px-45 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple ">
                            Salvar ganhador</button>
                        <button id="btn-vencedor-clean"
                            class="px-45 py-2 hidden font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple ">
                            Buscar Novamente</button>
                    </div>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="items-center  p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">

                <div class="w-full" id="rankingcompradores">
                    <p class=" text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                        RANKING DE COMPRADORES
                    </p>
                    <form action="" id="filter-form" style="margin-bottom:10px">
                        <div class="flex items-end  gap-2">
                            <div class="w-5/12 mr-2">
                                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Campanha</p>
                                <select name="raffle" id="raffle"
                                    class=" block w-full text-sm  pl-3 pr-8  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">xxx
                                    <option value="">Selecione a campanha </option>
                                    <?php
                                    $qry = $conn->query("SELECT * FROM `product_list`");
                                    while ($row = $qry->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?php if ($raffle == $row['id']) {
                                        echo 'selected';
                                    } ?>><?= $row['name'] ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                            <div class="w-5/12 mr-2">
                                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Quantidade</p>
                                <select name="top" id="top"
                                    class=" block w-full text-sm  pl-3 pr-8  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
                                    <option value="1" <?php if ($top == 1) {
                                        echo 'selected';
                                    } ?>>1</option>
                                    <option value="2" <?php if ($top == 2) {
                                        echo 'selected';
                                    } ?>>2</option>
                                    <option value="3" <?php if ($top == 3) {
                                        echo 'selected';
                                    } ?>>3</option>
                                    <option value="4" <?php if ($top == 4) {
                                        echo 'selected';
                                    } ?>>4</option>
                                    <option value="5" <?php if ($top == 5) {
                                        echo 'selected';
                                    } ?>>5</option>
                                    <option value="6" <?php if ($top == 6) {
                                        echo 'selected';
                                    } ?>>6</option>
                                    <option value="7" <?php if ($top == 7) {
                                        echo 'selected';
                                    } ?>>7</option>
                                    <option value="8" <?php if ($top == 8) {
                                        echo 'selected';
                                    } ?>>8</option>
                                    <option value="9" <?php if ($top == 9) {
                                        echo 'selected';
                                    } ?>>9</option>
                                    <option value="10" <?php if ($top == 10) {
                                        echo 'selected';
                                    } ?>>10</option>
                                </select>
                            </div>

                            <button
                                class="px-45 py-2 font-medium leading-5 text-nowrap text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar">
                                Gerar lista</button>
                        </div>
                        @csrf
                    </form>
                    <?php
                    $g_total = 0;
                    $i = 1;
                    if ($raffle && $top) {
                        $requests = $conn->query("
                SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
                o.code, CONCAT(' ', o.product_name) AS product
                FROM order_list o   
                INNER JOIN customer_list c ON o.customer_id = c.id
                WHERE o.product_id = {$raffle} AND o.status = 2   
                GROUP BY o.customer_id 
                ORDER BY total_quantity DESC
                LIMIT {$top}       
                ");


                        while ($row = $requests->fetch_assoc()) {

                    ?>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                        style="border:1px solid #eee;margin-bottom:10px;padding:10px;">
                        Nome: <?= $row['firstname'] ?> <?= $row['lastname'] ?><br>
                        Telefone: <?= formatPhoneNumber($row['phone']) ?><br>
                        Rifa: <?= $row['product'] ?><br>
                        Qtd. Cotas: <?= $row['total_quantity'] ?><br>
                        Total: R$ <?= format_num($row['total_amount'], 2) ?>
                    </p>

                    <?php } ?>




                    <?php } ?>
                </div>
            </div>


        </div>


        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-megaphone" viewBox="0 0 16 16">
                        <path
                            d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49a68.14 68.14 0 0 0-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 74.663 74.663 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199V2.5zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0zm-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233c.18.01.359.022.537.036 2.568.189 5.093.744 7.463 1.993V3.85zm-9 6.215v-4.13a95.09 95.09 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A60.49 60.49 0 0 1 4 10.065zm-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68.019 68.019 0 0 0-1.722-.082z">
                        </path>
                    </svg>
                </div>
                <div>
                    <?php
                    
                    $qry = $conn->query('SELECT * from `product_list` ');
                    $length = $qry->num_rows;
                    
                    ?>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Campanhas
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $length ?>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <?php
                    
                    $qry = $conn->query('SELECT * from `customer_list` ');
                    $length = $qry->num_rows;
                    
                    ?>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Clientes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $length ?>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-bag-check" viewBox="0 0 16 16">
                        <path
                            d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z">
                        </path>
                        <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <?php
                    
                    $qry = $conn->query('SELECT * from `order_list` ');
                    $length = $qry->num_rows;
                    
                    ?>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pedidos
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?= $length ?>
                    </p>





                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path
                            d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Faturamento
                    </p>
                    <div style="display: flex;">
                        <div id="hide-view" style="display:none; margin-right:5px;">
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                <?php
                                $qry = $conn->query('SELECT * from `order_list` ');
                                $total = 0;
                                while ($list = $qry->fetch_assoc()) {
                                    $sub = $list['total_amount'];
                                    $sub = floatval($sub);
                                    $total += $sub;
                                }
                                echo 'R$ ' . $total;
                                ?>


                            </p>
                        </div>








                        <div id="hided" style="display:block; margin-right:5px;">
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                R$ --


                            </p>
                        </div>
                        <button onclick="hideView()" class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z">
                                </path>
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div><br>
            <!-- Fim Card -->
        </div>








