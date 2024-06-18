<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$plano = $_settings->userdata('planos');
$user_plano = $_settings->userdata('plan_id');
$planos = false;


if ($plano) {
	$planos = $plano;
}


?>
  <script src="https://cdn.tailwindcss.com"></script>
<script>
$(document).ready(function() {
    fetch(_base_domain_ + 'plano')
        .then(response => response.json())
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error('Error:', error)

        });
});
</script>
<?php if ($planos) { ?>


<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">

        <div class="bg-white dark:bg-gray-800 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-4xl sm:text-center">
                    <h2 class="text-base font-semibold leading-7 text-gray-600 dark:text-gray-200 ">Pricing</h2>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-5xl">
                        Choose the right plan for&nbsp;you</p>
                </div>
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-200 sm:text-center">
                    Distinctio et nulla eum soluta et neque labore quibusdam. Saepe et quasi iusto modi velit ut non
                    voluptas in. Explicabo id ut laborum.</p>
                <div class="mt-20 flow-root">
                    <div
                        class="isolate -mt-16 grid max-w-sm grid-cols-1 gap-y-16 divide-y divide-gray-100 sm:mx-auto lg:-mx-8 lg:mt-0 lg:max-w-none lg:grid-cols-3 lg:divide-x lg:divide-y-0 xl:-mx-4">

                        <?php


							$array_planos = json_decode($planos, true);

							if ($array_planos) {
								foreach ($array_planos as $key => $item) {

									if ($item['active_status'] == 1) {

							?>
                        <div class="pt-16 lg:px-8 lg:pt-0 xl:px-14">
                            <h3 id="tier-basic"
                                class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">
                                <?= $item['name'] ?></h3>
                            <p class="mt-6 flex items-baseline gap-x-1">
                                <span class="text-5xl font-bold tracking-tight text-gray-900 dark:text-gray-100">R$
                                    <?= $item['price'] ?></span>
                                <span
                                    class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-200">/<?= $item['durationtype'] ?></span>
                            </p>
                            <p class="mt-3 text-sm leading-6 text-gray-500">$12 per month if paid annually</p>
                         <?php if($item['id'] == $user_plano){
                                
                                 ?> 
                                 
                                    <a href="#" aria-describedby="tier-basic"
                                class="mt-10 disable block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm ">Seu Plano</a>
                                 
                                 
                                 <?}else{?> 
                                    <a href="#" aria-describedby="tier-basic"
                                class="mt-10 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Upgrade</a>  <?php }?>
                            <p class="mt-10 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">
                                <?= $item['description'] ?></p>
                            <ul role="list" class="mt-6 space-y-3 text-sm leading-6 text-gray-600 dark:text-gray-200">
                                <li class="flex gap-x-3">
                                    <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200 " viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Rifas <?= $item['max_users'] ?>
                                </li>

                                <li class="flex gap-x-3">
                                    <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200 " viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Gerador de Sorteios <?= $item['max_roles'] ?>
                                </li>

                                <li class="flex gap-x-3">
                                    <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200 " viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Servidor <?= $item['max_blogs'] ?>
                                </li>

                                <li class="flex gap-x-3">
                                    <svg class="h-6 w-5 flex-none text-gray-600 dark:text-gray-200 " viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Painel <?= $item['max_blogs'] ?>
                                </li>


                            </ul>
                        </div>
                        <?php }
								}
							} ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php } ?>