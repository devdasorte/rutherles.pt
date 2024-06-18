<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
$stat_arr = ['Pending Orders', 'Packed Orders', 'Our for Delivery', 'Completed Order'];
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : '';
$order_number = ( '');
$customer_name = isset($_GET['customer_name']) ? $_GET['customer_name'] : '';
$tod = '';
if ($product_id) {
    $qry = $conn->query("SELECT type_of_draw FROM `product_list` WHERE id = $product_id");
    if ($qry->num_rows > 0) {
        $row = $qry->fetch_assoc();
        $tod = $row['type_of_draw'];
    }
}
function strcasecmp_utf8($str1, $str2)
{
    return strcasecmp(mb_strtolower($str1, 'UTF-8'), mb_strtolower($str2, 'UTF-8'));
}
?>

<main class="h-full pb-16 overflow-y-auto">
<style>
 
 td.px-4.py-3.text-sm {
     max-width: 240px;
     text-wrap: pretty;
 }

 .order_numbers {
     white-space: normal;
 }

 tr.text-gray-700.dark\:text-gray-400 {
     vertical-align: text-bottom;
 }

 .leowp-tab,
 .leowp-tab * {
     font-family: arial, sans-serif;
     box-sizing: border-box;
 }

 .leowp-tab input {
     display: none;
 }

 .leowp-tab label {
     position: relative;
     /* required for (f2) position:absolute */
     display: block;
     width: 100%;
     cursor: pointer;
 }


 .leowp-tab .leowp-content {
     overflow: hidden;

     max-height: 0;
 }

 .leowp-tab .leowp-content p {
     padding: 10px;
 }

 .leowp-tab input:checked~.leowp-content {
     max-height: 100%;
 }

 .leowp-tab label::after {
     display: block;
     content: "\25BC";
     position: absolute;
     left: 60px;
     top: 0px;
     transition: all 0.4s;
 }

 .exportar-contatos {
    
     display: inline-block;
     margin-bottom: 10px;
 }

 .leowp-tab input:checked~label::after {
     transform: rotate(-180deg);
 }

 @media all and (max-width: 768px) {
     .filtro-busca {
         display: block !important;
     }

 }

 span#approve-payment {
     background: #2271b1;
     padding: 6px;
     display: inline-block;
     margin-top: 6px;
     border-radius: 4px;
     color: #fff;
     cursor: pointer;
 }

 .drope-tab,
 .drope-tab * {
     font-family: arial, sans-serif;
     box-sizing: border-box
 }

 .drope-tab input {
     display: none
 }

 .drope-tab label {
     position: relative;
     display: block;
     width: 100%;
     cursor: pointer
 }

 .drope-tab .drope-content {
     overflow: hidden;

 }

 .drope-tab .drope-content p {
     padding: 10px
 }

 .drope-tab input:checked~.drope-content {
     max-height: 100%
 }

 .drope-tab label::after {
     display: block;
     content: "\25BC";
     position: absolute;
     left: 84px;
     top: 0;
     transition: .4s
 }

 .drope-tab input:checked~label::after {
     transform: rotate(-180deg)
 }

 @media only screen and (max-width: 600px) {
     .fb-2 {
         margin-top: 10px;
         width: 100%;
     }
 }
  .clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
  .to-cyan-400 {
    --tw-gradient-to: #22d3ee;
    }
 .via-cyan-500 {
    --tw-gradient-stops: var(--tw-gradient-from), #06b6d4, var(--tw-gradient-to, rgba(6, 182, 212, 0));
    }
    
    .trigger{
        display: flex; 
padding-top: 0.2rem;
padding-bottom: 0.2rem; 
padding-left: 0.5rem;
padding-right: 0.5rem; 
justify-content: center; 
align-items: center; 
border-radius: 0.25rem; 
font-weight: 600; 
color: #ffffff; 
background-image: linear-gradient(to top left, var(--tw-gradient-stops)); 
background-color: #7e3af2; 
transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
transition-duration: 300ms; 
transition-duration: 300ms; 
transition-timing-function: cubic-bezier(0, 0, 0.2, 1); 
box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); 







 }

    .trigger:hover {
 background-image: linear-gradient(to top right, var(--tw-gradient-stops)); 
transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
transition-duration: 300ms; 
--transform-scale-x: 1.1;
--transform-scale-y: 1.1; 
box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
.openNotify, .openN{
    display: flex; 
position: absolute; 
bottom: 1.25rem; 
left: 2rem; 
margin-top: 0.5rem; 
flex-direction: column; 







} 
span.hidden{
    display: none!important;
}


.transition{transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
transition-duration: 300ms; 

}
.ease-out{transition-timing-function: cubic-bezier(0, 0, 0.2, 1); 

}
.duration-200{transition-duration: 200ms; 
}
.opacity-0{
    opacity: 0;
}
.transform.scale-90{
    --transform-scale-x: .9;
--transform-scale-y: .9; 
}
.bg-gray-200 {
    --tw-bg-opacity: 1;
    background-color: rgb(229 231 235 / var(--tw-bg-opacity));
}
.rounded-full {
    border-radius: 9999px;
}

.justify-center {
    justify-content: center;
}
.items-center {
    align-items: center;
}
.cursor-pointer {
    cursor: pointer;
}
.w-6 {
    width: 1.5rem;
}
.h-6 {
    height: 1.5rem;
}
.flex-shrink-0 {
    flex-shrink: 0;
}
.flex {
    display: flex;
}
.relative {
    position: relative;
}
.space-y-2 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
}
.justify-start {
    justify-content: flex-start;
}
.items-start {
    align-items: flex-start;
}
.object-cover {
    object-fit: cover;
}
.rounded-full {
    border-radius: 9999px;
}
.w-14 {
    width: 3.5rem;
}
.h-14 {
    height: 3.5rem;
}
#open2{
    bottom: 0;
}
#open1, #open2{
    position: absolute;
    z-index: 99999999;
    width: auto;
    
    
}
#open1{
    bottom:-15px
}
img, video {
    max-width: 100%;
    height: auto;
}
.text-indigo-600 {
    --tw-text-opacity: 1;
    color: #7e3af2;
}
.leowp-tab label::after {
  
    left: 70px !important;
   
}
</style>


    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Pedidos <a href="/pedidos-novo" wire:navigate id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Criar novo
                </button></a>
            <button class=" fb-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple exportar-contatos" onclick="export_raffle_contacts();"> Exportar Contatos</button>

        </h2>

        <form action="" id="filter-form" style="margin-bottom:10px" method="GET">
            <div class="flex filtro-busca">

                <select name="product_id" id="product_id" class="mr-2 mt-1 block w-full text-sm pl-3 pr-8  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
                    <option value="">Todos os sorteios</option>
                    <?php
                    $qry = $conn->query("SELECT * FROM `product_list`");
                    while ($row = $qry->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>" <?php if ($product_id == $row['id']) {
                                                                echo 'selected';
                                                            } ?>><?= $row['name'] ?></option>
                    <?php }  ?>
                </select>
                <select name="status_id" id="status_id" class="mr-2 mt-1 block w-full text-sm pl-3 pr-8  dark:text-gray-300 dark:border-gray-600 border-[1px] dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg">
                    <option value="">Todos os status</option>
                    <option value="2" <?php if ($status_id == '2') {
                                            echo 'selected';
                                        } ?>>Pago</option>
                    <option value="1" <?php if ($status_id == '1') {
                                            echo 'selected';
                                        } ?>>Pendente</option>
                    <option value="3" <?php if ($status_id == '3') {
                                            echo 'selected';
                                        } ?>>Cancelado</option>
                </select>
                <input name="order" id="order" class="mr-2 mt-1 pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pedido">
                <input name="order_number" id="order_number" class="mr-2 mt-1 pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Pesquisar por cota">
                <input name="customer_phone" id="customer_phone" class="mr-2 mt-1  pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input" placeholder="Telefone">
                <input name="start_date" id="start_date" type="date" class=" mr-2 mt-1 pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input">
                <input name="end_date" id="end_date" type="date" class=" mr-2 mt-1 pl-3 pr-8 block w-full  text-sm border-[1px]  dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray font-medium leading-5  py-2 rounded-lg form-input">
                <button class="fb-2 px-5 py-2 mt-1 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>
            </div>
        </form>
        <div style="overflow:hidden !important;" class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          
                            <th class="px-4 py-3">Campanha</th>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Afiliado</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php
                        $perPage = 20;
                        $page = isset($_GET['pg']) ? $_GET['pg'] : 1;
                        $offset = ($page - 1) * $perPage;
                        $totalResults = $conn->query('SELECT * FROM order_list')->num_rows;

                        $i = 1;
                        $where = "";
                        if ($product_id) {
                            $where .= " AND o.product_id = '$product_id'";
                        }
                        if ($status_id) {
                            $where .= " AND o.status = '$status_id'";
                        }
                        if ($order_number) {
                            if (ctype_alpha($order_number) && $tod == '3') {
                                $bichos = array(
                                    "00" => "Avestruz",
                                    "01" => "Águia",
                                    "02" => "Burro",
                                    "03" => "Borboleta",
                                    "04" => "Cachorro",
                                    "05" => "Cabra",
                                    "06" => "Carneiro",
                                    "07" => "Camelo",
                                    "08" => "Cobra",
                                    "09" => "Coelho",
                                    "10" => "Cavalo",
                                    "11" => "Elefante",
                                    "12" => "Galo",
                                    "13" => "Gato",
                                    "14" => "Jacaré",
                                    "15" => "Leão",
                                    "16" => "Macaco",
                                    "17" => "Porco",
                                    "18" => "Pavão",
                                    "19" => "Peru",
                                    "20" => "Touro",
                                    "21" => "Tigre",
                                    "22" => "Urso",
                                    "23" => "Veado",
                                    "24" => "Vaca"
                                );
                                $foundNumber = null;
                                foreach ($bichos as $number => $animal) {
                                    if (strcasecmp_utf8($order_number, $animal) === 0) {
                                        $foundNumber = $number;
                                        break;
                                    }
                                }
                                if ($foundNumber !== null) {
                                    $order_number = $foundNumber;
                                }
                            } elseif (ctype_alpha($order_number) && $tod == '4') {
                                $bichos = array(
                                    "00" => "Avestruz M1",
                                    "01" => "Avestruz M2",
                                    "02" => "Águia M1",
                                    "03" => "Águia M2",
                                    "04" => "Burro M1",
                                    "05" => "Burro M2",
                                    "06" => "Borboleta M1",
                                    "07" => "Borboleta M2",
                                    "08" => "Cachorro M1",
                                    "09" => "Cachorro M2",
                                    "10" => "Cabra M1",
                                    "11" => "Cabra M2",
                                    "12" => "Carneiro M1",
                                    "13" => "Carneiro M2",
                                    "14" => "Camelo M1",
                                    "15" => "Camelo M2",
                                    "16" => "Cobra M1",
                                    "17" => "Cobra M2",
                                    "18" => "Coelho M1",
                                    "19" => "Coelho M2",
                                    "20" => "Cavalo M1",
                                    "21" => "Cavalo M2",
                                    "22" => "Elefante M1",
                                    "23" => "Elefante M2",
                                    "24" => "Galo M1",
                                    "25" => "Galo M2",
                                    "26" => "Gato M1",
                                    "27" => "Gato M2",
                                    "28" => "Jacaré M1",
                                    "29" => "Jacaré M2",
                                    "30" => "Leão M1",
                                    "31" => "Leão M2",
                                    "32" => "Macaco M1",
                                    "33" => "Macaco M2",
                                    "34" => "Porco M1",
                                    "35" => "Porco M2",
                                    "36" => "Pavão M1",
                                    "37" => "Pavão M2",
                                    "38" => "Peru M1",
                                    "39" => "Peru M2",
                                    "40" => "Touro M1",
                                    "41" => "Touro M2",
                                    "42" => "Tigre M1",
                                    "43" => "Tigre M2",
                                    "44" => "Urso M1",
                                    "45" => "Urso M2",
                                    "46" => "Veado M1",
                                    "47" => "Veado M2",
                                    "48" => "Vaca M1",
                                    "49" => "Vaca M2"
                                );
                                $foundNumber = null;
                                foreach ($bichos as $number => $animal) {
                                    if (strcasecmp_utf8($order_number, $animal) === 0) {
                                        $foundNumber = $number;
                                        break;
                                    }
                                }
                                if ($foundNumber !== null) {
                                    $order_number = $foundNumber;
                                }
                            }
                            $regex = "(^" . $order_number . ",|," . $order_number . ",|," . $order_number . "$|^" . $order_number . "$)";
                            $where .= " AND o.order_numbers REGEXP '$regex'";
                        }
                        if ($customer_name) {
                            $subquery = "(SELECT id FROM customer_list WHERE CONCAT(firstname, ' ', lastname) LIKE '%$customer_name%')";
                            $where .= " AND o.customer_id IN $subquery";
                        }

                        if (!empty($where)) {
                            $where = " WHERE " . ltrim($where, ' AND');
                        }

                        $qry = $conn->query("SELECT o.*, CONCAT(c.firstname, ' ', c.lastname) as customer, c.firstname, p.type_of_draw,p.image_path, c.phone, c.avatar,  o.whatsapp_status
				FROM `order_list` o
				INNER JOIN customer_list c ON o.customer_id = c.id
				INNER JOIN product_list p ON o.product_id = p.id 
				$where
				ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC
				LIMIT $perPage OFFSET $offset");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr class="text-gray-700 dark:text-gray-400">

                               

                                <td style="" class="px-4 py-3 text-sm ">
                                     <div style="position:relative; justify-content:flex-start; align-items:flex-start" x-data="{openN: false, open2: false}" class="relative   flex flex-col  ">
  <div>
    <button @click="openN = true,  open2 = true" class="trigger">
        <span style="text-wrap: nowrap;
    text-overflow: ellipsis;">
        <?= $row['product_name'] ?><br></span>
    </button>
  </div>
  <div x-cloak x-show="openN" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="openN">
    <div  id="open2" @click="open2 = !open2"
      x-cloak x-show="open2"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 transform scale-100"
      x-transition:leave-end="opacity-0 transform scale-90"
      class="bg-white cursor-pointer shadow rounded-lg px-3 py-2 w-64 space-y-2">

      <!-- Header -->
      <div  class="flex justify-between items-center w-full">
      </div>
      <!-- Content -->
      <div class="flex justify-start items-start space-x-4">
        <div  class="relative flex flex-shrink-1 ">
            
<img style="min-width: 3.5rem;" src="<?= BASE_URL . 'public/'.$row['image_path'] ?>" alt="Meow" class="w-14 h-14 rounded-full object-cover">
        </div>
        
        <div class="flex flex-col h-20 overflow-hidden; ">
               <div style="text-wrap: nowrap; text-overflow:ellipsis" class="font-semibold text-sm">
           <?= $row['product_name'] ?>
        </div>
       
          <div class="overflow-ellipsis overflow-hidden text-sm">
            <div class="clamp-3 leading-tight "style="text-wrap: nowrap;
    text-overflow: ellipsis;">
               <?= date("d-m-Y", strtotime($row['date_created'])) ?>
            </div>
          </div>
          
          <a href="/campanha-<?php echo $row['product_id'] ?>" class=" text-xs leading-loose mt-1 "  wire:navigate>
          <span class="text-blue-600 text-xs leading-loose mt-1" style="color:#7e3af2">
 Ver detalhes
        </span>
        </a>
        
        </div>
      </div>
    </div>

    
   </div>
    
  
</div>
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <div style="position:relative" x-data="{openNotify: false, open1: false}" class="relative   flex flex-col justify-center  items-start">
  <div>
    <button @click="openNotify = true, open1 = true" class="trigger">
        <?= $row['firstname'] ?><br>
    </button>
  </div>
  <div x-cloak x-show="openNotify" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="openNotify">
    <div  id="open1" @click="open1 = !open1"
      x-cloak x-show="open1"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 transform scale-100"
      x-transition:leave-end="opacity-0 transform scale-90"
      class="bg-white cursor-pointer shadow rounded-lg px-3 py-2 w-64 space-y-2">

      <!-- Header -->
      <div  class="flex justify-between items-center w-full">
     
      </div>
      <!-- Content -->
      <div class="flex justify-start items-start space-x-4">
        <div class="relative flex flex-shrink-1">
            
 <img style="min-width: 3.5rem;"  src="<?= validate_image($row['avatar']) ?>" alt="Meow" class="w-14 h-14 rounded-full object-cover">
       
        </div>
        
        <div class="flex flex-col h-20 overflow-hidden">
               <div style="text-wrap: nowrap; text-overflow:ellipsis" class="font-semibold text-sm ">
           <?= $row['customer'] ?>
        </div>
       
          <div class="overflow-ellipsis overflow-hidden text-sm">
            <div style="text-wrap: nowrap; text-overflow:ellipsis" class="clamp-3 leading-tight ">
              <?= formatPhoneNumber($row['phone']); ?>
            </div>
          </div>
          <div style="text-wrap: nowrap; text-overflow:ellipsis" class="text-blue-600 text-xs leading-loose mt-1" style="color:#7e3af2">
              <?php
                                        $nCollection = explode(',', $row['order_numbers']);
                                        $qty_nums = count($nCollection);
                                        
                                        echo $qty_nums . ' '  ?> Cotas reservadas 
          </div>
        </div>
      </div>
    </div>

    
   
    
  </div>
  
</div>
                                 
                                    
                                </td>

                                

                               


                                <td class="px-4 py-3 text-sm !text-nowrap">
                                    R$ <?= format_num($row['total_amount'], 2) ?>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if ($row['referral_id']) { ?>
                                        <?= ($row['referral_id']) ?>
                                    <?php } else { ?>
                                        ...
                                    <?php } ?>

                                </td>

                                <td  style="position:relative" class="px-4 py-3 text-sm">
                                <?php if($row['status'] == '1'){?>
    <span class="hidden" style="position:absolute; top:-4px; padding:4px"  onclick="update_order_status(<?=$row['id']; ?> ,  2)" id="approve-payment">Aprovar</span>
   <?php 
}
        ?>    
                                    <?php
                                    switch ($row['status']) {
                                        case 1:
                                            echo '<div id="pending" class="flex items-center"><i class="fas fa-circle mr-2 text-info"></i>';
                                            if ($row['payment_method']) {
                                                echo  'Pendente' . '</div>';
                                            } else {
                                                echo  'Pendente' . '</div>';
                                            }

                                            break;
                                        case 2:
                                            echo '<div class="flex items-center"><i class="fas fa-circle mr-2 text-success"></i>';
                                            if (!$row['payment_method']) {
                                                echo   'Manual</div>';
                                            } else {
                                                echo  $row['payment_method'] . '</div>';
                                            }

                                            break;
                                        case 3:
                                            echo '<div class="flex items-center"><i class="fas fa-circle mr-2 text-danger"></i>';
                                            if ($row['payment_method']) {
                                                echo  'Cancelado' . '</div>';
                                            } else {
                                                echo  'Cancelado' . '</div>';
                                            }

                                            break;
                                    }
                                    ?>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center  space-x-4 text-sm">
                                    
                                        <a href="/pedidos-<?php echo $row['id'] ?>" wire:navigate>
                                            <button class="trigger" style="height:30px" aria-label="View">
                                                Detalhes
                                            </button>
                                        </a>

                                        <a class="delete_pedido" href="javascript:void(0)" @click="openModal" data-id="<?= $row['id'] ?>">
                                            <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </a>
                                       
                                        <?php echo drope_send_whatsapp($row['id'], $row['code'], $row['status'], $row['customer'], $row['phone'], $row['product_name'], $row['quantity'], $row['quantity'], format_num($row['total_amount'], 2), $row['whatsapp_status'], $row['type_of_draw']); ?>
                                        
                        </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                </span>
                <span class="col-span-2"></span>


                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <ul class="inline-flex items-center">
                            <?php
                            $totalPages = ceil($totalResults / $perPage);
                            ?>
                            <?php if ($page > 1) { ?>
                                <a href='/pedidos?pg=<?php echo $page - 1 ?>'>
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
                                <a href="/pedidos?pg=1">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li>
                                </a>
                                <li class="dots">...</li>
                            <?php } ?>

                            <?php if ($page - 2 > 0) { ?>
                                <a href="/pedidos?pg=<?php echo $page - 2 ?>">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page - 2 ?></button></li>
                                </a>
                            <?php } ?>

                            <?php if ($page - 1 > 0) { ?>
                                <a href="/pedidos?pg=<?php echo $page - 1 ?>">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page - 1 ?></button></li>
                                </a>
                            <?php } ?>

                            <a href="/pedidos?pg=<?php echo $page; ?>">
                                <li>
                                    <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page; ?></button>
                                </li>
                            </a>
                            <?php if ($page + 1 < $totalPages + 1) { ?>
                                <a href="/pedidos?pg=<?php echo $page + 1 ?>">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page + 1 ?></button></li>
                                </a>
                            <?php } ?>

                            <?php if ($page + 2 < $totalPages + 1) { ?>
                                <a href="/pedidos?pg=<?php echo $page + 2 ?>">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page + 2 ?></button></li>
                                </a>
                            <?php } ?>

                            <?php if ($page < $totalPages - 2) : ?>
                                <li class="dots">...</li>
                                <a href="/pedidos?pg=<?php echo $totalPages ?>">
                                    <li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $totalPages ?></button></li>
                                </a>
                            <?php endif; ?>


                            <?php if ($page < $totalPages) { ?>
                                <a href="/pedidos?pg=<?php echo $page + 1 ?>">
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


            </div>
        </div>
    </div>

    <div id="numbers" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div style="background-color: #000000a1;" class="fixed inset-0 bg-gray-800 bg-opacity-50 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div style="min-height:-webkit-fill-available; " class="flex min-h-full items-end justify-center p-2 text-center sm:items-center sm:p-0">

            <div style="max-width:33%;max-height:50%; border-radius:0.75rem !important; overflow-x:hidden;overflow-y:auto" class="relative transform  rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg ">
                <div style="border-radius:0.75rem !important" class="bg-white px-2 pb-2 pt-2 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">

                        <div style="text-align:left !important" id="numbers_content" class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">



                        </div>
                    </div>
                </div>
                <div style="border-radius:0.75rem !important" class="bg-gray-50 px-2 py-2 sm:flex sm:flex-row-reverse sm:px-6">

                    <button id="close" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    </div>

<!-- Modal Delete -->
<!-- Modal Delete -->
<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">
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
                Você realmente deseja excluir esse pedido?
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
</main>


<!-- End Modal Delete -->
<script>
    $('#pending').click(function() {
        $('#approve-payment').toggleClass('hidden');
    })
 
    $(document).ready(function() {
        $('.leowp-tab input').click(function() {
            var numbers1 = $('.leowp-content').html();

            $("#numbers").toggleClass('hidden');
            $('#numbers_content').html(numbers1);

        })
        $('#close').click(function() {
            $("#numbers").toggleClass('hidden');
        })
    })


    $(document).ready(function() {
        $('.delete_pedido').click(function() {
            var id = $(this).attr('data-id');
            $('.delete_data').attr('data-id', id);
        })
        $('.delete_data').click(function() {
            var id = $(this).attr('data-id');
            delete_order(id)
        })
        $('.send-whatsapp').click(function() {
            var id = $(this).attr('data-post-id');
            update_whatsapp_status(id);
        })


    })

    function delete_order($id) {

        $.ajax({
            url: _base_url_ + "class/Main.php?action=delete_order",
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
                    $('#modal').hide();
                    show_toastr('Parabéns!','Pedido atualizado com sucesso!','success' )
                    location.reload();
                } else {
                    alert("An error occured.");

                }
            }
        })
    }
    function update_whatsapp_status($id) {

        $.ajax({
            url: _base_url_ + "class/Main.php?action=update_whatsapp_status",
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
                    location.reload();
                } else {
                    alert("An error occured.");

                }
            }
        })
    }

    function export_raffle_contacts() {

        // Montar a URL do download
        var downloadURL = _base_url_ + "class/Main.php?action=export_raffle_contacts&raffle=&status=";
     
        // Redirecionar o navegador para a URL de download
        
        window.open(downloadURL);


    }

    function update_order_status(id, status) {
        $.ajax({
            url: _base_url_ + "class/Main.php?action=update_order_status_sys",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            data: {
                id: id,
                status: status
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert("An error occured.");
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                                             show_toastr('Parabéns!','Pedido atualizado com sucesso!','success' )

                    Livewire.navigate('/pedidos')
                } else {
                    alert("An error occured.");
                }
            }
        })
    }

    $(function() {
        $('#filter-form').submit(function(e) {
            e.preventDefault()
            location.href = '/pedidos?' + $(this).serialize()
        })


    })
</script>