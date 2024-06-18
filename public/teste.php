<?php
function clean($string) {
    $string = str_replace(' ', '-', $string); 
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
    $string = preg_replace('/[\t\r\n]+/', ' ', $string);
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 }


$code = <<<PHP

            "<div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400 hidden">' .
         "\r\n\r\n\t\t\t\t\t" .
         '<label class="block mt-4 text-sm">' .
    "\r\n\t\t\t\t\t\t" .
    '<span class="text-gray-700 dark:text-gray-400">Habilitar MercadoPago?</span>' .
    "\t\r\n\t\t\t\t\t" .
    "</label>" .
    "\r\n\t\t\t\t\t" .
    '<div class="can-toggle">' .
    "\r\n\t\t\t\t\t\t" .
    '<input type="checkbox" name="mercadopago" id="mercadopago" ';
echo isset($mercadopago) && $mercadopago == 1 ? "checked" : "";
echo ">" .
    "\r\n\t\t\t\t\t\t" .
    '<label for="mercadopago">' .
    "\r\n\t\t\t\t\t\t\t" .
    '<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>' .
    "\r\n\t\t\t\t\t\t" .
    "</label>" .
    "\r\n\t\t\t\t\t" .
    "</div>" .
    "\r\n\t\t\t\t" .
    "</div>" .
    "\r\n\r\n\t\t\t\t" .
    "</div>" .
    "\r\n\r\n\t\t\t" .
    "</div>" .
    "\r\n\r\n\r\n" .
    "</div>" .
    "\r\n" .
    "</div>" 
`
PHP;
$res =clean($code);
echo $res;
print_r($res);
