<?php

if (isset($id) && 0 < $id) {
    $qry = $conn->query('SELECT * from `product_list` where id = \'' . $id . '\' ');

    if (0 < $qry->num_rows) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
} ?>

<style>
    input:checked+.slider {
        background-color: #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .status_cotas {
        display: flex;
        justify-content: flex-start !important;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .active-tab {
        border-bottom: none !important;
    }

    .desconto {
        border: 1px solid #e2e8f0;
        padding: 10px;
        margin-bottom: 20px;
    }

    div#descontos {
        display: flex;
        flex-wrap: wrap;
    }

    .grupo-desconto {
        margin-right: 20px;
    }

    .ganhador {
        border: 1px solid #e2e8f0;
        padding: 10px;
        margin-bottom: 20px;
    }

    div#ganhadores {}

    .grupo-ganhador {
        margin-right: 20px;
    }

    .add_field,
    .add_field_ {
        margin-bottom: 20px;
    }

    span.discount-number {
        display: inline-block;
        border: 1px solid #e2e8f0;
        border-radius: 100%;
        width: 25px;
        height: 25px;
        text-align: center;
    }

    .can-toggle {
        position: relative;
        margin-bottom: 20px;
    }

    .can-toggle *,
    .can-toggle *:before,
    .can-toggle *:after {
        box-sizing: border-box;
    }

    .can-toggle input[type=checkbox] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
        content: attr(data-unchecked);
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        content: attr(data-checked);
    }

    .can-toggle label {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        display: flex;
        align-items: center;
    }

    .can-toggle label .can-toggle__switch {
        position: relative;
    }

    .can-toggle label .can-toggle__switch:before {
        content: attr(data-checked);
        position: absolute;
        top: 0;
        text-transform: uppercase;
        text-align: center;
    }

    .can-toggle label .can-toggle__switch:after {
        content: attr(data-unchecked);
        position: absolute;
        z-index: 5;
        text-transform: uppercase;
        text-align: center;
        background: white;
        transform: translate3d(0, 0, 0);
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
        background-color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        color: #5e5e5e;
    }

    .can-toggle input[type=checkbox]:hover~label {
        color: #6a6a6a;
    }

    .can-toggle input[type=checkbox]:checked~label:hover {
        color: #55bc49;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
        background-color: #70c767;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        color: #4fb743;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
        background-color: #5fc054;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        color: #47a43d;
    }

    .can-toggle label .can-toggle__switch {
        transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
        background: #848484;
    }

    .can-toggle label .can-toggle__switch:before {
        color: rgba(255, 255, 255, 0.5);
    }

    .can-toggle label .can-toggle__switch:after {
        transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        transform: translate3d(65px, 0, 0);
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle label {
        font-size: 14px;
    }

    .can-toggle label .can-toggle__switch {
        height: 40px;
        flex: 0 0 134px;
        border-radius: 4px;
    }

    .can-toggle label .can-toggle__switch:before {
        left: 67px;
        font-size: 12px;
        line-height: 40px;
        width: 67px;
        padding: 0 12px;
    }

    .can-toggle label .can-toggle__switch:after {
        top: 2px;
        left: 2px;
        border-radius: 2px;
        width: 65px;
        line-height: 36px;
        font-size: 12px;
    }

    .can-toggle label .can-toggle__switch:hover:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    svg#view-email,
    svg#view-phone {
        display: inline-block;
        margin-left: 10px;
        cursor: pointer;
    }

    /*Imagens sorteio */
    img#loadlogo {
        max-width: 96%;
        max-height: 12em;
        object-fit: scale-down;
        object-position: center center;
        border-radius: 6%;
    }

    .imagens-sorteio>label {
        margin: 24px 0;
        line-height: initial !important;
    }




    .imagens-sorteio input[type="file"] {
        display: block;
    }

    .imagens-sorteio .imageThumb {
        max-height: 75px;
        border: 2px solid #9027b0;
        padding: 1px;
        cursor: pointer;
    }

    .imagens-sorteio .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .imagens-sorteio .remove {
        display: block;
        text-align: center;
        cursor: pointer;
        margin-top: -20px;
    }

    .imagens-sorteio .remove svg {
        display: inline-block !important;
    }

    span.add_image img {
        width: 150px;
        cursor: pointer;
    }

    span.remove-logo {
        display: block;
        cursor: pointer;
        width: 35px;
        margin-top: 10px;
    }

    .image-container__box {
        background-color: #fff;
        border: 1px dashed #9027b0;
        border-radius: 2px;
        cursor: pointer;
        height: 122px;
        margin-bottom: 6px;
        margin-right: 12px;
        margin-top: 6px;
        text-align: center;
        width: 160px;
    }

    .box__icon {
        float: left;
        height: 30px;
        margin-top: 24px;
        width: 100%;
    }

    .box__main-text {
        color: #9027b0;
        float: left;
        font-size: 16px;
        margin-top: 5px;
        width: 100%;
    }

    .box__info-text {
        color: #9027b0;
        font-size: 11px;
        line-height: 2;
        margin-top: 1px;
        width: 100%;
    }

    #tabs li a {
        text-wrap: nowrap;
    }


    /*fim imagens sorteio */

    @media all and (max-width: 1023px) {
        #tabs {
            flex-wrap: wrap;
        }

        #tabs .mr-1 {
            margin-bottom: 15px;
        }

        #descontos {
            display: block;
        }

        .grupo-desconto {
            margin-right: 0px;
        }

        #ganhadores {
            display: block;
        }

        .grupo-ganhador {
            margin-right: 0px;
        }


    }
</style>
<style>
    .tag {
        background-color: #7e3af2 !important;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        display: inline-block;
        margin: 0.25rem;
        color: #fff;
    }

    .tag .remove-tag {
        margin-left: 0.5rem;
        cursor: pointer;
    }

    .tag .remove-premio {
        margin-left: 0.5rem;
        cursor: pointer;
    }
</style>
<div>
    <link id="tw-1" rel="stylesheet" href="{{ asset('assets/build/assets/app-CLXaZiM_.css') }}">

    <main class="h-full pb-16 overflow-y-auto ">


        <div class="container px-6 mx-auto grid ">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <?= isset($id)
                ? 'Atualizar campanha <a href="/campanha-nova" wire:navigate id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
  Criar nova
  </button></a>'
                : 'Nova campanha' ?>
            </h2>




            <div class="w-full overflow-hidden rounded-lg shadow-xs ">
                <ul class="flex" id="tabs">
                    <li class="mr-1">
                        <a href="#tab1"
                            class="bg-white dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">Dados</a>
                    </li>
                    <li class="mr-1">
                        <a href="#tab2"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Imagens</a>
                    </li>

                    <li class="mr-1">
                        <a href="#tab3"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Descontos</a>
                    </li>

                    <li class="mr-1">
                        <a href="#tab4"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Ranking
                            de compradores</a>
                    </li>

                    <li class="mr-1">
                        <a href="#tab5"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Barra
                            de progresso</a>
                    </li>

                    <li class="mr-1">
                        <a href="#tab6"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Ganhador</a>
                    </li>
                    <li id="tab7_get" class="mr-1">
                        <a href="#tab7"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Cota
                            Premiada</a>
                    </li>

                </ul>
            </div>



            <form action="" id="product-form">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">

                <div class="mt-4">
                    <div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-2 mt-4">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Título</span>
                                <input name="name" id="name"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Nome da campanha" value="<?php echo isset($name) ? $name : ''; ?>" />
                            </label>

                            <label class="block  text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Subtítulo</span>
                                <input name="subtitle" id="subtitle"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="ex: Campanha 24H" value="<?php echo isset($subtitle) ? $subtitle : ''; ?>" />
                            </label>
                        </div>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Descrição</span>
                            <p style="font-size:13px;color: orange;font-style:italic;">Você pode utilizar tags html na
                                descrição para uma melhor formatação</p>
                            @php
                                $config = [
                                    'spellChecker' => true,
                                    'toolbar' => ['heading', 'bold', 'italic', '|', 'upload-image', 'preview'],
                                    'maxHeight' => '200px',
                                ];
                            @endphp



                            <textarea name="description" id="description"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                rows="6" placeholder="Descrição da campanha"><?php echo isset($description) ? $description : ''; ?></textarea>
                        </label>

                        <div class="grid gap-6  mt-4 md:grid-cols-3 xl:grid-cols-6 ">

                            <label class="block mt-4 text-sm lg:col-span-4">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Tipo da campanha
                                </span>
                                <select name="type_of_draw" id="type_of_draw"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="1"
                                        <?= isset($type_of_draw) && $type_of_draw == '1' ? 'selected' : '' ?>>Automático
                                    </option>
                                    <option value="2"
                                        <?= isset($type_of_draw) && $type_of_draw == '2' ? 'selected' : '' ?>>Números
                                    </option>
                                    <option value="3"
                                        <?= isset($type_of_draw) && $type_of_draw == '3' ? 'selected' : '' ?>>Fazendinha
                                    </option>
                                    <option value="4"
                                        <?= isset($type_of_draw) && $type_of_draw == '4' ? 'selected' : '' ?>>Fazendinha
                                        metade</option>
                                </select>
                            </label>
                            <label class="block mt-4 text-sm md:mx-auto">
                                <span class="text-gray-700 dark:text-gray-400">Campanha privada?</span>
                                <div class="can-toggle">
                                    <input type="checkbox" name="private_draw" id="private_draw"
                                        <?= isset($private_draw) && $private_draw == 1 ? 'checked' : '' ?>>
                                    <label for="private_draw">
                                        <div class="can-toggle__switch mt-1 h-full " data-checked="Sim"
                                            data-unchecked="Não"></div>
                                    </label>
                                </div>
                            </label>
                            <label class="block mt-4 text-sm md:mx-auto">
                                <span style="text-wrap:nowrap" class="text-gray-700 dark:text-gray-400">Campanha em
                                    destaque?</span>
                                <div class="can-toggle">
                                    <input type="checkbox" name="featured_draw" id="featured_draw"
                                        <?= isset($featured_draw) && $featured_draw == 1 ? 'checked' : '' ?>>
                                    <label for="featured_draw">
                                        <div class="can-toggle__switch mt-1 h-full" data-checked="Sim"
                                            data-unchecked="Não"></div>
                                    </label>
                                </div>
                            </label>
                        </div>
                        <div class="grid gap-6 md:grid-cols-3 xl:grid-cols-6 mt-4 qtd-select">

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 1
                                    </p>
                                    <input name="qty_select_1" id="qty_select_1" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="10" value="10">
                                </div>
                            </div>

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 2
                                    </p>
                                    <input name="qty_select_2" id="qty_select_2" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="20" value="20">
                                </div>
                            </div>

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 3
                                    </p>
                                    <input name="qty_select_3" id="qty_select_3" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="50" value="50">
                                </div>
                            </div>

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 4
                                    </p>
                                    <input name="qty_select_4" id="qty_select_4" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="100" value="100">
                                </div>
                            </div>

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 5
                                    </p>
                                    <input name="qty_select_5" id="qty_select_5" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="200" value="200">
                                </div>
                            </div>

                            <div class="flex items-center  bg-white rounded-lg shadow-xs dark:bg-gray-800">
                                <div class="w-full">
                                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Valor opção 6
                                    </p>
                                    <input name="qty_select_6" id="qty_select_6" type="number"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="300" value="300">
                                </div>
                            </div>

                        </div>

                        <div class="grid gap-6 md:grid-cols-3 xl:grid-cols-3 ">
                            <label class="block mt-4 text-sm qtd-numeros">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Quantidade de números
                                </span>
                                <select name="qty_numbers" id="qty_numbers"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="100"
                                        <?= isset($qty_numbers) && $qty_numbers == '100' ? 'selected' : '' ?>>100
                                    </option>
                                    <option value="200"
                                        <?= isset($qty_numbers) && $qty_numbers == '200' ? 'selected' : '' ?>>200
                                    </option>
                                    <option value="300"
                                        <?= isset($qty_numbers) && $qty_numbers == '300' ? 'selected' : '' ?>>300
                                    </option>
                                    <option value="400"
                                        <?= isset($qty_numbers) && $qty_numbers == '400' ? 'selected' : '' ?>>400
                                    </option>
                                    <option value="500"
                                        <?= isset($qty_numbers) && $qty_numbers == '500' ? 'selected' : '' ?>>500
                                    </option>
                                    <option value="600"
                                        <?= isset($qty_numbers) && $qty_numbers == '600' ? 'selected' : '' ?>>600
                                    </option>
                                    <option value="700"
                                        <?= isset($qty_numbers) && $qty_numbers == '700' ? 'selected' : '' ?>>700
                                    </option>
                                    <option value="800"
                                        <?= isset($qty_numbers) && $qty_numbers == '800' ? 'selected' : '' ?>>800
                                    </option>
                                    <option value="900"
                                        <?= isset($qty_numbers) && $qty_numbers == '900' ? 'selected' : '' ?>>900
                                    </option>
                                    <option value="1000"
                                        <?= isset($qty_numbers) && $qty_numbers == '1000' ? 'selected' : '' ?>>1.000
                                    </option>
                                    <option value="2000"
                                        <?= isset($qty_numbers) && $qty_numbers == '2000' ? 'selected' : '' ?>>2.000
                                    </option>
                                    <option value="3000"
                                        <?= isset($qty_numbers) && $qty_numbers == '3000' ? 'selected' : '' ?>>3.000
                                    </option>
                                    <option value="4000"
                                        <?= isset($qty_numbers) && $qty_numbers == '4000' ? 'selected' : '' ?>>4.000
                                    </option>
                                    <option value="5000"
                                        <?= isset($qty_numbers) && $qty_numbers == '5000' ? 'selected' : '' ?>>5.000
                                    </option>
                                    <option value="6000"
                                        <?= isset($qty_numbers) && $qty_numbers == '6000' ? 'selected' : '' ?>>6.000
                                    </option>
                                    <option value="7000"
                                        <?= isset($qty_numbers) && $qty_numbers == '7000' ? 'selected' : '' ?>>7.000
                                    </option>
                                    <option value="8000"
                                        <?= isset($qty_numbers) && $qty_numbers == '8000' ? 'selected' : '' ?>>8.000
                                    </option>
                                    <option value="9000"
                                        <?= isset($qty_numbers) && $qty_numbers == '9000' ? 'selected' : '' ?>>9.000
                                    </option>
                                    <option value="10000"
                                        <?= isset($qty_numbers) && $qty_numbers == '10000' ? 'selected' : '' ?>>10.000
                                    </option>
                                    <option value="20000"
                                        <?= isset($qty_numbers) && $qty_numbers == '20000' ? 'selected' : '' ?>>20.000
                                    </option>
                                    <option value="30000"
                                        <?= isset($qty_numbers) && $qty_numbers == '30000' ? 'selected' : '' ?>>30.000
                                    </option>
                                    <option value="40000"
                                        <?= isset($qty_numbers) && $qty_numbers == '40000' ? 'selected' : '' ?>>40.000
                                    </option>
                                    <option value="50000"
                                        <?= isset($qty_numbers) && $qty_numbers == '50000' ? 'selected' : '' ?>>50.000
                                    </option>
                                    <option value="60000"
                                        <?= isset($qty_numbers) && $qty_numbers == '60000' ? 'selected' : '' ?>>60.000
                                    </option>
                                    <option value="70000"
                                        <?= isset($qty_numbers) && $qty_numbers == '70000' ? 'selected' : '' ?>>70.000
                                    </option>
                                    <option value="80000"
                                        <?= isset($qty_numbers) && $qty_numbers == '80000' ? 'selected' : '' ?>>80.000
                                    </option>
                                    <option value="90000"
                                        <?= isset($qty_numbers) && $qty_numbers == '90000' ? 'selected' : '' ?>>90.000
                                    </option>
                                    <option value="100000"
                                        <?= isset($qty_numbers) && $qty_numbers == '100000' ? 'selected' : '' ?>>100.000
                                    </option>
                                    <option value="200000"
                                        <?= isset($qty_numbers) && $qty_numbers == '200000' ? 'selected' : '' ?>>200.000
                                    </option>
                                    <option value="300000"
                                        <?= isset($qty_numbers) && $qty_numbers == '300000' ? 'selected' : '' ?>>300.000
                                    </option>
                                    <option value="400000"
                                        <?= isset($qty_numbers) && $qty_numbers == '400000' ? 'selected' : '' ?>>400.000
                                    </option>
                                    <option value="500000"
                                        <?= isset($qty_numbers) && $qty_numbers == '500000' ? 'selected' : '' ?>>500.000
                                    </option>
                                    <option value="600000"
                                        <?= isset($qty_numbers) && $qty_numbers == '600000' ? 'selected' : '' ?>>600.000
                                    </option>
                                    <option value="700000"
                                        <?= isset($qty_numbers) && $qty_numbers == '700000' ? 'selected' : '' ?>>700.000
                                    </option>
                                    <option value="800000"
                                        <?= isset($qty_numbers) && $qty_numbers == '800000' ? 'selected' : '' ?>>800.000
                                    </option>
                                    <option value="900000"
                                        <?= isset($qty_numbers) && $qty_numbers == '900000' ? 'selected' : '' ?>>900.000
                                    </option>
                                    <option value="1000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '1000000' ? 'selected' : '' ?>>
                                        1.000.000</option>
                                    <option value="2000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '2000000' ? 'selected' : '' ?>>
                                        2.000.000</option>
                                    <option value="3000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '3000000' ? 'selected' : '' ?>>
                                        3.000.000</option>
                                    <option value="4000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '4000000' ? 'selected' : '' ?>>
                                        4.000.000</option>
                                    <option value="5000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '5000000' ? 'selected' : '' ?>>
                                        5.000.000</option>
                                    <option value="6000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '6000000' ? 'selected' : '' ?>>
                                        6.000.000</option>
                                    <option value="7000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '7000000' ? 'selected' : '' ?>>
                                        7.000.000</option>
                                    <option value="8000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '8000000' ? 'selected' : '' ?>>
                                        8.000.000</option>
                                    <option value="9000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '9000000' ? 'selected' : '' ?>>
                                        9.000.000</option>
                                    <option value="10000000"
                                        <?= isset($qty_numbers) && $qty_numbers == '10000000' ? 'selected' : '' ?>>
                                        10.000.000</option>

                                </select>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Valor por cota</span>
                                <input name="price" id="price"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="0,50" value="<?php echo isset($price) ? $price : '0.00'; ?>" />
                            </label>

                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Tempo para pagamento *

                                </span>
                                <select name="limit_order_remove" id="limit_order_remove"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="">Selecione</option>
                                    <option value="0"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 0 ? 'selected' : '' ?>>
                                        Sem limite</option>
                                    <option value="15"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 15 ? 'selected' : '' ?>>
                                        15 minutos</option>
                                    <option value="30"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 30 ? 'selected' : '' ?>>
                                        30 minutos</option>
                                    <option value="45"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 45 ? 'selected' : '' ?>>
                                        45 minutos</option>
                                    <option value="60"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 60 ? 'selected' : '' ?>>
                                        60 minutos</option>
                                    <option value="120"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 120 ? 'selected' : '' ?>>
                                        2 horas</option>
                                    <option value="180"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 180 ? 'selected' : '' ?>>
                                        3 horas</option>
                                    <option value="240"
                                        <?= isset($limit_order_remove) && $limit_order_remove == 240 ? 'selected' : '' ?>>
                                        4 horas</option>
                                </select>
                            </label>
                        </div>
                        <div class="grid gap-6 md:grid-cols-3 xl:grid-cols-3 ">
                            <label class="block mt-4 text-sm qtd-minima">
                                <span class="text-gray-700 dark:text-gray-400">Quantidade mínima de números comprados
                                    por vez</span>
                                <input name="min_purchase" id="min_purchase"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="1" value="<?php echo isset($min_purchase) ? $min_purchase : '1'; ?>" />
                            </label>

                            <label class="block mt-4 text-sm qtd-maxima">
                                <span class="text-gray-700 dark:text-gray-400">Quantidade máxima de números comprados
                                    por vez</span>
                                <input name="max_purchase" id="max_purchase"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="100" value="<?php echo isset($max_purchase) ? $max_purchase : 500; ?>" />
                            </label>
                            <label class="block mt-4 text-sm qtd-minima">
                                <span class="text-gray-700 dark:text-gray-400">Quantidade limite de compras por
                                    usuário</span>
                                <input name="limit_orders" id="limit_orders"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="1" value="<?php echo isset($limit_orders) ? $limit_orders : 500; ?>">
                            </label>

                        </div>
                        <div class="grid gap-6 md:grid-cols-3 xl:grid-cols-3 ">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Status de exibição
                                </span>
                                <select name="status_display" id="status_display"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="1"
                                        <?= isset($status_display) && $status_display == 1 ? 'selected' : '' ?>>Adquira
                                        já!</option>
                                    <option value="2"
                                        <?= isset($status_display) && $status_display == 2 ? 'selected' : '' ?>>Corre
                                        que está acabando!</option>
                                    <option value="3"
                                        <?= isset($status_display) && $status_display == 3 ? 'selected' : '' ?>>Aguarde
                                        a campanha!</option>
                                    <option value="4"
                                        <?= isset($status_display) && $status_display == 4 ? 'selected' : '' ?>>
                                        Concluído</option>
                                    <option value="5"
                                        <?= isset($status_display) && $status_display == 5 ? 'selected' : '' ?>>Em
                                        breve!</option>
                                </select>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Status da campanha
                                </span>
                                <select name="status" id="status"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>
                                        Ativo</option>
                                    <option value="2" <?= isset($status) && $status == 2 ? 'selected' : '' ?>>
                                        Pausado</option>
                                    <option value="3" <?= isset($status) && $status == 3 ? 'selected' : '' ?>>
                                        Finalizado</option>
                                </select>
                            </label>

                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Data e hora da campanha</span>
                                <input type="datetime-local" name="date_of_draw" id="date_of_draw"
                                    class="w-full block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    value="<?php echo isset($date_of_draw) ? $date_of_draw : ''; ?>" />
                            </label>

                        </div>

                    </div>

                    <div id="tab2" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                        <div class="imagens-sorteio">
                            <!-- Imagem principal -->
                            <label class="pure-material-textfield-outlined">
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Imagem principal</span>
                                </label>
                                <div class="image-container__box dark:bg-gray-800 add-logo">
                                    <svg width="35" height="30" viewBox="0 0 35 30"
                                        xmlns="http://www.w3.org/2000/svg" class="box__icon">
                                        <path
                                            d="M3.502 3.4h5.11L12.02.09h10.222l3.407 3.31h5.111c1.882 0 3.408 1.481 3.408 3.309v19.856c0 1.828-1.526 3.31-3.408 3.31H3.502c-1.882 0-3.408-1.482-3.408-3.31V6.709c0-1.828 1.526-3.31 3.408-3.31zM17.13 8.364c-4.705 0-8.518 3.704-8.518 8.273 0 4.57 3.813 8.273 8.518 8.273 4.704 0 8.518-3.704 8.518-8.273 0-4.57-3.814-8.273-8.518-8.273zm0 3.309c2.823 0 5.11 2.222 5.11 4.964 0 2.741-2.287 4.964-5.11 4.964-2.823 0-5.111-2.223-5.111-4.964 0-2.742 2.288-4.964 5.11-4.964z"
                                            fill="#9027B0" fill-rule="evenodd"></path>
                                    </svg>
                                    <span class="box__main-text">Adicionar Imagem</span>
                                    <span class="box__info-text"> JPG, GIF e PNG somente </span>
                                </div>
                                <input id="customFile1" accept=".gif, .jpg, .jpeg, .png" type="file"
                                    name="img" style="display:none;">
                                <div class="show_logo" style="display:inline-block;">
                                    <img id="loadlogo" src="<?php echo validate_image(isset($image_path) ? $image_path : ''); ?>" width="150" alt="Logo" />
                                    <span class="remove-logo">
                                        <svg width='25' height='25' viewBox='0 0 25 25'
                                            xmlns='http://www.w3.org/2000/svg' class='s'>
                                            <g transform='translate(.317)' fill='none' fill-rule='evenodd'>
                                                <rect fill='#323232' opacity='.99' width='24.503' height='24.33'
                                                    rx='12.165'></rect>
                                                <path
                                                    d='M12.266 11.134L7.992 6.86c-.301-.3-.783-.3-1.054 0-.3.299-.3.777 0 1.046l4.275 4.274-4.305 4.244c-.3.3-.3.778 0 1.047.301.298.783.298 1.054 0l4.304-4.245 4.275 4.245c.3.298.782.298 1.053 0 .271-.3.301-.778 0-1.047L13.32 12.18l4.274-4.244c.301-.3.301-.777 0-1.046-.27-.3-.752-.3-1.053-.03l-4.275 4.274z'
                                                    fill='#FFF'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </label>

                            <!-- Fim imagem principal -->

                            <!-- galeria -->
                            <div class="galeria-imagens">
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Galeria de imagens</span>
                                </label>
                                <label class="pure-material-textfield-outlined"
                                    style="margin-top:5px;display:inline-block;">
                                    <span class="add_image">
                                        <div class="image-container__box dark:bg-gray-800">
                                            <svg width="35" height="30" viewBox="0 0 35 30"
                                                xmlns="http://www.w3.org/2000/svg" class="box__icon">
                                                <path
                                                    d="M3.502 3.4h5.11L12.02.09h10.222l3.407 3.31h5.111c1.882 0 3.408 1.481 3.408 3.309v19.856c0 1.828-1.526 3.31-3.408 3.31H3.502c-1.882 0-3.408-1.482-3.408-3.31V6.709c0-1.828 1.526-3.31 3.408-3.31zM17.13 8.364c-4.705 0-8.518 3.704-8.518 8.273 0 4.57 3.813 8.273 8.518 8.273 4.704 0 8.518-3.704 8.518-8.273 0-4.57-3.814-8.273-8.518-8.273zm0 3.309c2.823 0 5.11 2.222 5.11 4.964 0 2.741-2.287 4.964-5.11 4.964-2.823 0-5.111-2.223-5.111-4.964 0-2.742 2.288-4.964 5.11-4.964z"
                                                    fill="#9027B0" fill-rule="evenodd"></path>
                                            </svg>
                                            <span class="box__main-text">Adicionar fotos</span>
                                            <span class="box__info-text"> JPG, GIF e PNG somente </span>
                                        </div>
                                        <input style="display:none;" type="file" accept=".gif, .jpg, .jpeg, .png"
                                            id="image_gallery" name="image_gallery[]" multiple />
                                    </span>
                                    <div class="leowp-files">
                                        <?php
                                        $image_gallery = isset($image_gallery)
                                            ? $image_gallery
                                            : "";
                                        if ($image_gallery) {
                                            $image_gallery = json_decode(
                                                $image_gallery,
                                                true
                                            ); ?>

                                        <?php foreach (
                                            $image_gallery
                                            as $image
                                        ) { ?>
                                        <span class="pip">
                                            <img class="imageThumb" src="<?php
                                            echo base_url;
                                            $image;
                                            ?>" title="" />
                                            <input type="hidden" name="on-gallery[]" value="<?= $image ?>">
                                            <br />
                                            <span class="remove">
                                                <svg width='25' height='25' viewBox='0 0 25 25'
                                                    xmlns='http://www.w3.org/2000/svg' class='s'>
                                                    <g transform='translate(.317)' fill='none'
                                                        fill-rule='evenodd'>
                                                        <rect fill='#323232' opacity='.99' width='24.503'
                                                            height='24.33' rx='12.165'></rect>
                                                        <path
                                                            d='M12.266 11.134L7.992 6.86c-.301-.3-.783-.3-1.054 0-.3.299-.3.777 0 1.046l4.275 4.274-4.305 4.244c-.3.3-.3.778 0 1.047.301.298.783.298 1.054 0l4.304-4.245 4.275 4.245c.3.298.782.298 1.053 0 .271-.3.301-.778 0-1.047L13.32 12.18l4.274-4.244c.301-.3.301-.777 0-1.046-.27-.3-.752-.3-1.053-.03l-4.275 4.274z'
                                                            fill='#FFF'></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <?php } ?>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </label>
                            </div>
                            <!-- end galeria -->
                        </div>
                    </div>


                    <div id="tab3" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Utilizar descontos nessa campanha?</span>
                        </label>
                        <div class="can-toggle">
                            <input type="checkbox" name="enable_discount" id="enable_discount"
                                <?= isset($enable_discount) && $enable_discount == 1 ? 'checked' : '' ?>>
                            <label for="enable_discount">
                                <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                            </label>
                        </div>
                        <div class="enable_cumulative_discount">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Habilitar desconto acumulativo?</span>
                            </label>
                            <div class="can-toggle">
                                <input type="checkbox" name="enable_cumulative_discount"
                                    id="enable_cumulative_discount"
                                    <?= isset($enable_cumulative_discount) && $enable_cumulative_discount == 1 ? 'checked' : '' ?>>
                                <label for="enable_cumulative_discount">
                                    <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                                </label>
                            </div>
                        </div>

                        <label class="add_field block mt-4 text-sm" style="display:inline-block;">
                            <span
                                class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Adicionar
                                desconto</span>
                        </label>

                        <!-- Descontos -->
                        <div id="descontos" class="descontos">
                            <?php
                            $discount_qty = isset($discount_qty)
                                ? $discount_qty
                                : "";
                            $discount_amount = isset($discount_amount)
                                ? $discount_amount
                                : "";

                            if ($discount_qty && $discount_amount) {

                                $discount_qty = json_decode(
                                    $discount_qty,
                                    true
                                );
                                $discount_amount = json_decode(
                                    $discount_amount,
                                    true
                                );
                                $discounts = [];
                                foreach ($discount_qty as $qty_index => $qty) {
                                    foreach (
                                        $discount_amount
                                        as $amount_index => $amount
                                    ) {
                                        if ($qty_index === $amount_index) {
                                            $discounts[$qty_index] = [
                                                "qty" => $qty,
                                                "amount" => $amount,
                                            ];
                                        }
                                    }
                                }
                                ?>
                            <?php
                            $count = 0;
                            foreach ($discounts as $discount) {
                                $count++; ?>
                            <div class="grupo-desconto">
                                <div class="desconto dark:border-gray-600 text-gray-700 dark:text-gray-400">
                                    <span class="discount-number"><?= $count ?></span> Desconto
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400"> Quantidade de números:</span>
                                        <input type="text" name="discount_qty[]"
                                            class="discount_qty block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="10" value="<?= $discount['qty'] ?>">
                                    </label>

                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Valor do desconto:</span>
                                        <input type="text" name="discount_amount[]"
                                            class="discount_price block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="1.00" value="<?= $discount['amount'] ?>">
                                    </label>
                                </div>
                                <?php if ($count > 1) { ?>
                                <label class="remove_field block mt-4 text-sm" style="margin-block:20px;">
                                    <span
                                        class="bg-red-500 px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Remover
                                        desconto</button></label>
                                <?php } ?>

                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            } else {
                                 ?>
                            <div class="grupo-desconto">
                                <div class="desconto dark:border-gray-600 text-gray-700 dark:text-gray-400">
                                    <span class="discount-number">1</span> Desconto
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400"> Quantidade de números:</span>
                                        <input type="text" name="discount_qty[]"
                                            class="discount_qty block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="10">
                                    </label>

                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Valor do desconto:</span>
                                        <input type="text" name="discount_amount[]"
                                            class="discount_price block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="1.00">
                                    </label>
                                </div>

                            </div>

                            <?php
                            }
                            ?>
                        </div>

                    </div>


                    <div id="tab4" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Habilitar ranking?</span>
                        </label>
                        <div class="can-toggle">
                            <input type="checkbox" name="enable_ranking" id="enable_ranking"
                                <?= isset($enable_ranking) && $enable_ranking == 1 ? 'checked' : '' ?>>
                            <label for="enable_ranking">
                                <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                            </label>
                        </div>
                        <div class="ranking_qty">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Mostrar a quantidade de bilhetes
                                    comprados?</span>
                            </label>
                            <div class="can-toggle">
                                <input type="checkbox" name="enable_ranking_show" id="enable_ranking_show"
                                    <?= isset($enable_ranking_show) && $enable_ranking_show == 1 ? 'checked' : '' ?>>
                                <label for="enable_ranking_show">
                                    <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                                </label>
                            </div>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Tipo de Ranking
                                </span>
                                <select name="ranking_type" id="ranking_type"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    value="<?php echo isset($ranking_type) ? $ranking_type : '1'; ?>">
                                    <option value="1"
                                        <?= isset($ranking_type) && $ranking_type == 1 ? 'selected' : '' ?>>Total
                                    </option>
                                    <option value="2"
                                        <?= isset($ranking_type) && $ranking_type == 2 ? 'selected' : '' ?>>Diário
                                    </option>
                                </select>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Deseja mostrar quantos
                                    compradores?</span>
                                <select name="ranking_qty" id="ranking_qty"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                    <option value="1"
                                        <?= isset($ranking_qty) && $ranking_qty == 1 ? 'selected' : '' ?>>1</option>
                                    <option value="2"
                                        <?= isset($ranking_qty) && $ranking_qty == 2 ? 'selected' : '' ?>>2</option>
                                    <option value="3"
                                        <?= isset($ranking_qty) && $ranking_qty == 3 ? 'selected' : '' ?>>3</option>
                                    <option value="4"
                                        <?= isset($ranking_qty) && $ranking_qty == 4 ? 'selected' : '' ?>>4</option>
                                    <option value="5"
                                        <?= isset($ranking_qty) && $ranking_qty == 5 ? 'selected' : '' ?>>5</option>
                                </select>

                            </label>

                            <label id="premios" class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Premiações do ranking *</span>
                                @php

                                    $ranking_prizes =
                                        $ranking_1 .
                                        ',' .
                                        $ranking_2 .
                                        ',' .
                                        $ranking_3 .
                                        ',' .
                                        $ranking_4 .
                                        ',' .
                                        $ranking_5;
                                    $ranking_prizes = explode(',', $ranking_prizes);

                                @endphp

                                @foreach ($ranking_prizes as $key => $prize)
                                    @if ($key + 1 <= $ranking_qty)
                                        <div class="input-group input-group-md mb-3">
                                            <span class="input-group-text"
                                                id="inputGroup-sizing-sm">{{ $key + 1 }}° Lugar</span>
                                            <input type="text" class="form-control"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-sm" value="{{ $prize }}"
                                                id="ranking_{{ $key + 1 }}"
                                                name="ranking_{{ $ranking_ . $key + 1 }}">


                                        </div>
                                    @endif
                                @endforeach
                            </label>
                        </div>

                    </div>

                    <div id="tab5" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Exibir barra de progresso?</span>
                        </label>
                        <div class="can-toggle">
                            <input type="checkbox" name="enable_progress_bar" id="enable_progress_bar"
                                <?= isset($enable_progress_bar) && $enable_progress_bar == 1 ? 'checked' : '' ?>>
                            <label for="enable_progress_bar">
                                <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                            </label>
                        </div>
                    </div>

                    <div id="tab6" class="tabcontent text-gray-700 dark:text-gray-400 hidden">


                        <label class="add_field_ block mt-4 text-sm" style="display:inline-block;">
                            <span
                                class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Adicionar
                                ganhador</span>
                        </label>

                        <!-- Descontos -->
                        <div id="ganhadores" class="ganhadores">
                            <?php
                            $winners_qty = 5;
                            $draw_number = isset($draw_number)
                                ? $draw_number
                                : "";

                            if ($winners_qty && $draw_number) {

                                $draw_winner = json_decode($draw_winner, true);
                                $draw_number = json_decode($draw_number, true);
                                $winners = [];
                                foreach ($draw_winner as $qty_index => $name) {
                                    foreach (
                                        $draw_number
                                        as $amount_index => $number
                                    ) {
                                        if ($qty_index === $amount_index) {
                                            $winners[$qty_index] = [
                                                "name" => $name,
                                                "number" => $number,
                                            ];
                                        }
                                    }
                                }
                                ?>
                            <?php
                            $count = 0;
                            foreach ($winners as $winner) {
                                $count++; ?>
                            <div class="grupo-ganhador">
                                <div class="ganhador dark:border-gray-600 text-gray-700 dark:text-gray-400">
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Telefone ganhador -
                                            <?= $count ?>º prêmio</span>
                                        <input type="number" name="draw_name[]"
                                            class="draw_name block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="Telefone do ganhador" value="<?= $winner['name'] ?>">
                                    </label>

                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Número/grupo sorteado -
                                            <?= $count ?>º prêmio</span>
                                        <input type="text" name="draw_number[]"
                                            class="draw_number block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="Número ou grupo sorteado" value="<?= $winner['number'] ?>">
                                    </label>
                                </div>
                                <?php if ($count > 1) { ?>
                                <label class="remove_field_ block mt-4 text-sm" style="margin-block:20px;">
                                    <span
                                        class="bg-red-500 px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Remover
                                        ganhador</button></label>
                                <?php } ?>

                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            } else {
                                 ?>
                            <div class="grupo-ganhador">
                                <div class="ganhador dark:border-gray-600 text-gray-700 dark:text-gray-400"> <label
                                        class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400"> Telefone ganhador - 1º
                                            prêmio</span>
                                        <input type="number" name="draw_name[]"
                                            class="draw_name block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="Telefone do ganhador">
                                    </label>

                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Número/grupo sorteado - 1º
                                            prêmio:</span>
                                        <input type="text" name="draw_number[]"
                                            class="draw_number block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            placeholder="Número ou grupo sorteado">
                                    </label>
                                </div>

                            </div>

                            <?php
                            }
                            ?>
                        </div>


                    </div>


                    <div id="tab7" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">
                                Cotas Premiadas
                                <p style="font-size: 13px; color: orange;">
                                    Digite o número da cota e pressione enter para adicionar
                                </p>
                            </span>
                            <input type="text" id="tags-input"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                placeholder="Pressione Enter para adicionar uma cota">
                            <div id="tags-container" class="mt-2">
                                <?php
                                if (isset($cotas_premiadas)) {
                                    $cotas_premiadas = explode(',', $cotas_premiadas);
                                    $premios = explode(',', $cotas_premiadas_premios);
                                
                                    foreach ($cotas_premiadas as $cota) {
                                        $premio = array_shift($premios);
                                        $premio = explode(':', $premio);
                                        $premio = $premio[1];
                                
                                        if ($cota != '') {
                                            echo "<div id='$cota' data-premio='$premio'  class='tag'>$cota <span class='remove-tag'>x</span></div>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <input type="hidden" name="cotas_premiadas" id="cotas_premiadas"
                                value="<?= isset($cotas_premiadas) ? $cotas_premiadas : '' ?>">
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">
                                Premiações

                            </span>
                            <input type="hidden" name="cotas_premiadas_premios" id="cotas_premiadas_premios"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                value="<?= isset($cotas_premiadas_premios) ? $cotas_premiadas_premios : '' ?>"
                                placeholder="012345:Pix no valor R$1000" />
                            <div id="premios-container" class="mt-2">
                                <?php
                                if (isset($cotas_premiadas_premios)) {
                                    $cotas_premiadas_premios = explode(',', $cotas_premiadas_premios);
                                    foreach ($cotas_premiadas_premios as $cota) {
                                        $id = explode(':', $cota);
                                        $id = $id[0];
                                        if ($cota != '') {
                                            echo "<div id='p$id' class='tag'>$cota <span class='remove-premio'>x</span></div>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </label>

                        <label class="block mt-4 text-sm qtd-minima">
                            <span class="text-gray-700 dark:text-gray-400">Descrição</span>
                            <input name="cotas_premiadas_descricao" id="cotas_premiadas__descricao"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?php echo isset($cotas_premiadas_descricao) ? $cotas_premiadas_descricao : ''; ?>"
                                placeholder="Além do prêmio principal, temos cotas premiadas esperando por você. " />
                        </label>

                        <div class="w-full overflow-hidden mt-4 rounded-lg shadow-xs">
                            @php
                                $isActive = $plan['gerar_sorteio'] == 'on';
                            @endphp
                        
                            @if ($isActive)
                                <div class="status_cotas mt-4 mb-4">
                                    <label class="switch">
                                        <input 
                                            type="checkbox" 
                                            id="status_auto_cota" 
                                            name="status_auto_cota"
                                            @if(isset($status_auto_cota) && $status_auto_cota == 1) 
                                                checked 
                                            @endif
                                            @if(isset($status_auto_cota) && $status_auto_cota !== null) 
                                                disabled 
                                            @endif
                                        >
                                        <span class="slider round"></span>
                                    </label>
                                    <span id="mensagem" class="text-gray-700 dark:text-gray-400">
                                        Não é possível alterar o valor depois de criado o sorteio
                                    </span>

                                    <div class="block glass mt-4 text-sm status_cotas">
                                        <p id="mensagem_porcentagem" class="italic text-orange-500 text-xs">
                                            Libere as cotas premidas de acordo com a porcentagem de cotas vendidas
                                        </p>
                                        <span id="label_porcentagem" class="text-gray-700 dark:text-gray-400">
                                            O valor definido será convertido em %
                                        </span>
                                        <select 
                                            name="valor_base_auto" 
                                            id="valor_base_auto" 
                                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                            @if($id > 0) 
                                                disabled 
                                            @endif
                                        >
                                            <option value="5" @if(isset($valor_base_auto) && $valor_base_auto == '5') selected @endif>5</option>
                                            <option value="15" @if(isset($valor_base_auto) && $valor_base_auto == '15') selected @endif>15</option>
                                            <option value="25" @if(isset($valor_base_auto) && $valor_base_auto == '25') selected @endif>25</option>
                                            <option value="50" @if(isset($valor_base_auto) && $valor_base_auto == '50') selected @endif>50</option>
                                            <option value="75" @if(isset($valor_base_auto) && $valor_base_auto == '75') selected @endif>75</option>
                                        </select>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4">
                                    <span>
                                        Atualize para usar esse recurso 
                                        <span class="badge " style="background-color: blueviolet;">
                                            Plus
                                        </span>
                                    </span>
                                </div>
                        
                                <div style="filter: blur(1px)" class="block glass mt-4 text-sm touch-none relative pointer-events-none !blur-2xl opacity-35">
                                    <div class="absolute top-0 bottom-0 left-0 right-0 blur-lg glass"></div>
                                    <div class="status_cotas glass blur-lg pointer-events-none opacity-5">
                                        <label class="switch">
                                            <input 
                                                type="checkbox" 
                                                id="status_auto_cota" 
                                                name="status_auto_cota"
                                                @if(isset($status_auto_cota) && $status_auto_cota == 1) 
                                                    checked 
                                                @endif
                                                @if(isset($status_auto_cota) && $status_auto_cota !== null) 
                                                    disabled 
                                                @endif
                                            >
                                            <span class="slider round"></span>
                                        </label>
                                        <span id="mensagem" class="text-gray-700 dark:text-gray-400">
                                            Não é possível alterar o valor depois de criado o sorteio
                                        </span>
                                    </div>
                                </div>
                        
                                <div  style="filter: blur(1px)" class="block glass mt-4 text-sm status_cotas blur-lg pointer-events-none opacity-5">
                                    <p id="mensagem_porcentagem" class="italic text-gray-200 text-xs">
                                        Libere as cotas premidas de acordo com a porcentagem de cotas vendidas
                                    </p>
                                    <span id="label_porcentagem" class="text-gray-700 dark:text-gray-400">
                                        O valor definido será convertido em %
                                    </span>
                                    <select 
                                        name="valor_base_auto" 
                                        id="valor_base_auto" 
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        @if($id > 0) 
                                            disabled 
                                        @endif
                                    >
                                        <option value="5" @if(isset($valor_base_auto) && $valor_base_auto == '5') selected @endif>5</option>
                                        <option value="15" @if(isset($valor_base_auto) && $valor_base_auto == '15') selected @endif>15</option>
                                        <option value="25" @if(isset($valor_base_auto) && $valor_base_auto == '25') selected @endif>25</option>
                                        <option value="50" @if(isset($valor_base_auto) && $valor_base_auto == '50') selected @endif>50</option>
                                        <option value="75" @if(isset($valor_base_auto) && $valor_base_auto == '75') selected @endif>75</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        

                    </div>
                </div>




                <div style="margin-top:20px;">
                    <button form="product-form"
                        class="px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Salvar
                    </button>
                </div>

                @csrf
            </form>




        </div>
    </main>


    <span id="openModal" href="javascript:void(0)" @click="openModal"></span>

    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        style="display: none;">

    </div>


    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog" id="modal" style="display: none;">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700 closeM"
                aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <div class="mt-4 mb-6">
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                Parabéns!
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-400">
                Alterações salvas com sucesso!
            </p>
        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        function updateHiddenInput() {
            var tags = [];
            var premios = [];
            $('#tags-container .tag').each(function() {
                var tagText = $(this).text().slice(0, -1); // Remove 'x' from the end
                tags.push(tagText);
                premios.push(tagText + ':' + $(this).attr('data-premio'));
            });
            $('#cotas_premiadas').val(tags.join(','));
            $('#cotas_premiadas_premios').val(premios.join(','));
            console.log($('#cotas_premiadas').val());
            console.log($('#cotas_premiadas_premios').val());
        }

        $('#tags-input').on('keypress', function(e) {
            if (e.which === 13) { // Enter key pressed
                e.preventDefault();
                var tagText = $(this).val().trim();
                var premioText = prompt('Digite o prêmio para a tag "' + tagText + '":');
                if (premioText === null) {
                    return;
                }
                var isDuplicate = false;

                // Check for duplicate tags
                $('#tags-container .tag').each(function() {
                    if ($(this).text().slice(0, -1) === tagText) {
                        isDuplicate = true;
                        return false; // Exit loop if duplicate is found
                    }
                });

                if (tagText !== '' && !isDuplicate) {
                    $('#tags-container').append('<span id="' + tagText + '" class="tag" data-premio="' +
                        premioText + '">' + tagText + '<span class="remove-tag">x</span></span>');
                    $('#premios-container').append('<span id="p' + tagText + '" class="tag">' +
                        tagText + ':' + premioText + '<span class="remove-premio">x</span></span>');
                    $(this).val('');
                    updateHiddenInput();
                } else if (isDuplicate) {
                    alert('Tag duplicada não pode ser adicionada.');
                }
            }
        });

        $(document).on('click', '.remove-tag, .remove-premio', function() {
            var tagText = $(this).parent().text().slice(0, -1); // Remove 'x' from the end
            if (tagText.includes(':')) {
                tagText = tagText.split(':')[0];
            }
            $('#' + tagText).remove(); // Remove corresponding tag from tags-container
            $(this).parent().remove();

            $('#p' + tagText).remove(); // Remove corresponding tag from tags-container













            // Remove corresponding values from hidden inputs
            var tags = [];
            var premios = [];
            $('#tags-container .tag').each(function() {
                var tagText = $(this).text().slice(0, -1); // Remove 'x' from the end
                tags.push(tagText);

                premios.push(tagText + ':' + $(this).attr('data-premio'))
            })
            $('#cotas_premiadas').val(tags.join(','));
            $('#cotas_premiadas_premios').val(premios.join(','));
            console.log($('#cotas_premiadas').val());
            console.log($('#cotas_premiadas_premios').val());
        })
    })
    var pageToken = 'manage_product';
    $("#tabs a").click(function() {
        var selectedTab = $(this).attr("href");
        $("#tabs a").removeClass("active-tab");
        $(this).addClass("active-tab");
        $(".tabcontent").hide();
        $(selectedTab).show();
        localStorage.setItem('selectedTab_' + pageToken, pageToken + '_' + selectedTab);
        return false;
    });

    $(document).on('input', '.discount_price', function() {
        $(this).mask("#.##0,00", {
            reverse: true
        });
    });
    $(document).on('input', '.discount_qty', function() {
        $('.discount_qty').keypress(function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
        });
    });

    $(document).ready(function() {
        if ($('#type_of_draw').val() > 1) {
            if ($('#type_of_draw').val() == 2) {
                $('.qtd-numeros').show();
            } else {
                $('.qtd-numeros').hide();
            }
            $('.qtd-minima').hide();
            $('.qtd-maxima').hide();
            $('.qtd-select').hide();
            $('#tab7_get').hide();
        } else {
            $('.qtd-numeros').show();
            $('.qtd-minima').show();
            $('.qtd-maxima').show();
            $('.qtd-select').show();
            $('#tab7_get').show();
        }


        $('#limit_orders, #min_purchase, #max_purchase, .discount_qty, #sale_qty, #ranking_qty, #draw_number')
            .keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });


        $('.view-email').each(function() {
            var originalText = $(this).text();
            $(this).data('original-text', originalText);
            $(this).text('**********');
        });

        $('.view-phone').each(function() {
            var originalText = $(this).text();
            $(this).data('original-text', originalText);
            $(this).text('**********');
        });

        $('#view-email').click(function() {
            $('.view-email').each(function() {
                var originalText = $(this).data('original-text');
                if ($(this).text() === '**********') {
                    $(this).text(originalText);
                } else {
                    $(this).text('**********');
                }
            });
        });

        $('#view-phone').click(function() {
            $('.view-phone').each(function() {
                var originalText = $(this).data('original-text');
                if ($(this).text() === '**********') {
                    $(this).text(originalText);
                } else {
                    $(this).text('**********');
                }
            });
        });

        var storedTab = localStorage.getItem('selectedTab_' + pageToken);
        if (storedTab) {
            var selectedTab = storedTab.substring(pageToken.length + 1);
            $("#tabs a").removeClass("active-tab");
            $(selectedTab).addClass("active-tab");
            $(".tabcontent").hide();
            $(selectedTab).show();
        }


        //End tabs	

        // Descontos
        var max_fields = 4; // Maximum allowed input pairs
        var wrapper = $("#descontos"); // Container for input pairs
        var add_button = $(".add_field"); // Add button ID
        var discounts = $('.grupo-desconto').length;
        if (discounts > 3) {
            $(".add_field").hide();
        }
        var x = discounts; // Initial counter for input pairs
        $('#status_auto_cota').on('change', function() {
            console.log($(this).is(':checked'));

            if ($(this).is(':checked')) {
                $('#status_auto_cota').val(1);
            } else {
                $('#status_auto_cota').val(0);

            }
        });



        // Add input pairs on click
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;

                $(wrapper).append(
                    '<div class="grupo-desconto"><div class="desconto dark:border-gray-600 text-gray-700 dark:text-gray-400"><span class="discount-number">' +
                    x +
                    '</span> Desconto <label class="block mt-4 text-sm"> <span class="text-gray-700 dark:text-gray-400">Quantidade de números:</span> <input type="text" name="discount_qty[]" class="discount_qty block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="' +
                    x +
                    '0"> </label> <label class="block mt-4 text-sm"> <span class="text-gray-700 dark:text-gray-400">Valor do desconto:</span> <input type="text" name="discount_amount[]" class="discount_price block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="' +
                    x +
                    '.00"> </label><label class="remove_field block mt-4 text-sm"><span class="bg-red-500 px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Remover desconto</span></label><br></div></div>'
                );

            }
            if (x == max_fields) {
                $('.add_field').hide();
            }
        });

        // Remove input pair on click
        $(wrapper).on("click", ".remove_field", function(e) {
            $('.add_field').show();
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        if ($('#enable_discount').is(":checked")) {
            $('.descontos, .add_field').show();
            $('.enable_cumulative_discount').show();

        } else {
            $('.descontos, .add_field').hide();
            $('.enable_cumulative_discount').hide();
        }
        $('#enable_discount').change(function() {
            console.log((":checked"))
            if ($('#enable_discount').is(":checked")) {
                $('.descontos, .add_field').show();
                $('.enable_cumulative_discount').show();
            } else {
                $('.descontos, .add_field').hide();
                $('.enable_cumulative_discount').hide();
            }
        });
        // Fim descontos

        //Ganhadores
        var max_fields_ = 5; // Maximum allowed input pairs
        var wrapper_ = $("#ganhadores"); // Container for input pairs
        var add_button_ = $(".add_field_"); // Add button ID
        var winners = $('.grupo-ganhador').length;
        if (winners > 3) {
            $(".add_field_").hide();
        }
        var x = winners; // Initial counter for input pairs

        // Add input pairs on click
        $(add_button_).click(function(e) {
            e.preventDefault();
            if (x < max_fields_) {
                x++;

                $(wrapper_).append(
                    '<div class="grupo-ganhador"><div class="ganhador dark:border-gray-600 text-gray-700 dark:text-gray-400"> <label class="block mt-4 text-sm"> <span class="text-gray-700 dark:text-gray-400">Ganhador - ' +
                    x +
                    'º prêmio:</span> <input type="text" name="draw_name[]" class="draw_name block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nome do ganhador"> </label> <label class="block mt-4 text-sm"> <span class="text-gray-700 dark:text-gray-400">Número/grupo sorteado - ' +
                    x +
                    'º prêmio:</span> <input type="text" name="draw_number[]" class="draw_number block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Número ou grupo sorteado"> </label><label class="remove_field_ block mt-4 text-sm"><span class="bg-red-500 px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Remover ganhador</span></label><br></div></div>'
                );

            }
            if (x == max_fields_) {
                $('.add_field_').hide();
            }
        });

        // Remove input pair on click
        $(wrapper_).on("click", ".remove_field_", function(e) {
            $('.add_field_').show();
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });


        //Ganhadores


        if ($('#enable_ranking').is(":checked")) {
            $('.ranking_qty').show();
        } else {
            $('.ranking_qty').hide();
        }
        $('#enable_ranking').change(function() {
            if ($('#enable_ranking').is(":checked")) {
                $('.ranking_qty').show();
            } else {
                $('.ranking_qty').hide();
            }
        });
        if ($('#enable_sale').is(":checked")) {
            $('.sale_qty').show();
        } else {
            $('.sale_qty').hide();
        }
        $('#enable_sale').change(function() {
            if ($('#enable_sale').is(":checked")) {
                $('.sale_qty').show();
            } else {
                $('.sale_qty').hide();
            }
        });



        $('#ranking_qty').change(function() {
            var current_qty = $('.input-group')
            .length; // Assuming you have a container with class 'input-group' that contains the ranking inputs
            var qty = parseInt($('#ranking_qty').val(),
            10); // Assuming you get the desired quantity from an input

            if (qty < current_qty) {
                for (var i = current_qty; i > qty; i--) {
                    $('#ranking_' + i).closest('.input-group').remove();
                }
                return;
            }

            for (var i = current_qty + 1; i <= qty; i++) {
                var rankingValue = '';
                <?php
                // Create a PHP array to store the ranking values
                $ranking_values = [
                    1 => isset($ranking_1) ? $ranking_1 : 0,
                    2 => isset($ranking_2) ? $ranking_2 : 0,
                    3 => isset($ranking_3) ? $ranking_3 : 0,
                    4 => isset($ranking_4) ? $ranking_4 : 0,
                    5 => isset($ranking_5) ? $ranking_5 : 0,
                ];
                ?>

                var rankingValues = <?= json_encode($ranking_values) ?>;
                if (rankingValues.hasOwnProperty(i)) {
                    rankingValue = rankingValues[i];
                } else {
                    rankingValue = 0; // default value if no ranking value is set for `i`
                }

                $('#premios').append(
                    '<div class="input-group input-group-md mb-3">' +
                    '<span class="input-group-text" id="inputGroup-sizing-sm">' + i +
                    '° Lugar</span>' +
                    '<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="' +
                    rankingValue + '" id="ranking_' + i + '" name="ranking_' + i + '">' +
                    '</div>'


                );
            }
        });

        // Fim ranking

        $('#type_of_draw').change(function() {
            if ($('#type_of_draw').val() > 1) {
                if ($('#type_of_draw').val() == 2) {
                    $('.qtd-numeros').show();
                } else {
                    $('.qtd-numeros').hide();
                }
                $('.qtd-minima').hide();
                $('.qtd-maxima').hide();
                $('.qtd-select').hide();
                $('#tab7_get').hide();

            } else {
                $('.qtd-numeros').show();
                $('.qtd-minima').show();
                $('.qtd-maxima').show();
                $('.qtd-select').show();
                $('#tab7_get').show();

            }
        });

        if ($('#private_draw').is(":checked")) {
            $('#featured_draw').prop('checked', false);
        }
        $('#private_draw').change(function() {
            if ($('#private_draw').is(":checked")) {
                $('#featured_draw').prop('checked', false);
            }
        });
        if ($('#featured_draw').is(":checked")) {
            $('#private_draw').prop('checked', false);
        }
        $('#featured_draw').change(function() {
            if ($('#featured_draw').is(":checked")) {
                $('#private_draw').prop('checked', false);
            }
        });

        //Imagem e galeria
        $('.show_logo').hide();
        <?php if (!empty($image_path)) { ?>
        $('.show_logo').show();
        $('.add-logo').hide();
        <?php } ?>
        customFile1.onchange = evt => {
            const [file] = customFile1.files
            if (file) {
                loadlogo.src = URL.createObjectURL(file);
                $('.show_logo').show();
                $('.add-logo').hide();
            }
        }

        $(".remove-logo").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            $('.show_logo').hide();
            $('.add-logo').show();
            $('#customFile1').val('');

        });

        $(".remove").click(function(e) {
            $(this).parent(".pip").remove();
            $(".add_image").show();
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        });

        if ($(".pip").length > 5) {
            $(".add_image").hide();
        }

        if (window.File && window.FileList && window.FileReader) {
            $("#image_gallery").on("change", function(e) {
                let files = e.target.files;
                filesLength = files.length;
                var maxImages = 6;
                var pipLength = $(".pip").length;
                var remainingImages = maxImages - pipLength;
                var maxFiles = Math.min(remainingImages, filesLength);

                var filesInput = document.getElementById("image_gallery");
                var filesList = filesInput.files;


                var newFilesList = new DataTransfer();

                for (var i = 0; i < maxFiles; i++) {
                    newFilesList.items.add(filesList[i]);
                }
                filesInput.files = newFilesList.files;


                /*
                  		if (totalFiles > maxFiles) {
                  			alert('Você pode enviar apenas ' + maxFiles + ' imagens.');
                  			$(this).val('');
                  		} */


                for (var i = 0; i < maxFiles; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;

                        $('.leowp-files').append("<span class=\"pip\">" +
                            "<img class=\"imageThumb\" src=\"" + e.target.result +
                            "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\"><svg width='25' height='25' viewBox='0 0 25 25' xmlns='http://www.w3.org/2000/svg' class='s'><g transform='translate(.317)' fill='none' fill-rule='evenodd'><rect fill='#323232' opacity='.99' width='24.503' height='24.33' rx='12.165'></rect><path d='M12.266 11.134L7.992 6.86c-.301-.3-.783-.3-1.054 0-.3.299-.3.777 0 1.046l4.275 4.274-4.305 4.244c-.3.3-.3.778 0 1.047.301.298.783.298 1.054 0l4.304-4.245 4.275 4.245c.3.298.782.298 1.053 0 .271-.3.301-.778 0-1.047L13.32 12.18l4.274-4.244c.301-.3.301-.777 0-1.046-.27-.3-.752-.3-1.053-.03l-4.275 4.274z' fill='#FFF'></path></g></svg></span>" +
                            "</span>");

                        if ($(".pip").length == 6) {
                            $(".add_image").hide();
                            //$('#image_gallery').prop('disabled', true);
                        }

                        $(".remove").click(function(e) {
                            $(this).parent(".pip").remove();
                            $(".add_image").show();
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                        });

                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }

        //Fim imagem e galeria


        //Save products
        $('#product-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();

            $.ajax({
                url: _base_url_ + "class/Main.php?action=save_product",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert("An error occured");

                },
                success: function(resp) {


                    if (typeof resp == 'object' && resp.status == 'success' && resp
                        .feedback) {


                        show_toastr('Parabéns!', `campanha ${resp.feedback} com sucesso!`,
                            'success');

                        setTimeout(function() {
                            localStorage.removeItem('selectedTab_' + pageToken);
                            Livewire.navigate('/campanha')

                        }, 1000);
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-dark err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").scrollTop(0);

                    } else {
                        console.log(resp)
                    }
                }
            })
        })
        //End save products

    });
</script>
