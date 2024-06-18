<?php
function cleanHTMLPHPCode($code) {
    // Remove os echos e espaços desnecessários
    $code = preg_replace('/echo\s*\(\s*(["\'])(?:\\\\.|[^\\\\])*?\\1\s*\)\s*;/', '', $code);

    // Remove caracteres de espaço em branco, tabulações e quebras de linha desnecessárias
    $code = preg_replace('/[\t\r\n]+/', ' ', $code);

    // Retorna o código limpo
    return $code;
}

// Exemplo de uso da função
$code = <<<HTML
'<div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400 hidden">' .
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
echo isset('777') && 8==1 ? "checked" : "";
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
HTML;
$cleanedCode = cleanHTMLPHPCode($code);
echo $cleanedCode;


