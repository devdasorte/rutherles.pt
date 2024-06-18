<?php



if ($_settings->info('dealer_active') == 1) {
	if ($_settings->info('dealer_deactive_site') == 1) {
		echo '<center><br><p>Houve um problema ao tentar carregar essa página.</p>';
		exit();
	}
}

echo '         <div class="container app-main">' . "\r\n" . '            <div class="row">' . "\r\n" . '               <div class="col-12">' . "\r\n" . '                  <div class="app-title">' . "\r\n" . '                     <h1>⚡ Campanhas</h1>' . "\r\n" . '                     <div class="app-title-desc">Escolha sua sorte</div>' . "\r\n" . '                  </div>' . "\r\n" . '               </div>' . "\r\n" . '               ';
$qry = $conn->query('SELECT * FROM `product_list` WHERE status_display <> \'4\' AND featured_draw = \'1\' ORDER BY RAND() LIMIT 1');

while ($row = $qry->fetch_assoc()) {
	echo '                  <div class="col-12 mb-2">' . "\r\n" . '                     <a href="/campanha/';
	echo $row['slug'];
	echo '" class="SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">' . "\r\n" . '                        <div class="custom-badge-display">' . "\r\n" . '                           ';

	if ($row['status_display'] == 1) {
		echo '                              <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>' . "\r\n" . '                           ';
	}

	echo '                           ';

	if ($row['status_display'] == 2) {
		echo '                              <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>' . "\r\n" . '                           ';
	}

	echo '                           ';

	if ($row['status_display'] == 3) {
		echo '                              <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>' . "\r\n" . '                           ';
	}

	echo '                           ';

	if ($row['status_display'] == 4) {
		echo '                              <span class="badge bg-dark font-xsss">Concluído</span>' . "\r\n" . '                              ';
		$date_of_draw = strtotime($row['date_of_draw']);
		$date_of_draw = date('d/m', $date_of_draw);
		echo '                              <div class="SorteioTpl_dtSorteio__2mfSc custom-calendar-display"><i class="bi bi-calendar2-check"></i> ';
		echo $date_of_draw;
		echo '</div>' . "\r\n" . '                           ';
	}

	echo '                           ';

	if ($row['status_display'] == 5) {
		echo '                              <span class="badge bg-dark font-xsss">Em breve!</span>' . "\r\n" . '                           ';
	}

	echo '                           ';

	if ($row['status_display'] == 6) {
		echo '                              <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>' . "\r\n" . '                           ';
	}

	echo '                        </div>' . "\r\n" . '                        <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">' . "\r\n" . '                           <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">' . "\r\n" . '                              <div class="carousel-inner">' . "\r\n" . '                                 <div class="carousel-item active" style="width:100%;height:350px">' . "\r\n" . '                                    <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">' . "\r\n" . '                                       <img alt="';
	echo $row['name'];
	echo '" src="';
	echo validate_image($row['image_path']);
	echo '" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">' . "\r\n" . '                                       <noscript><img alt="';
	echo $row['name'];
	echo '" src="';
	echo validate_image($row['image_path']);
	echo '" decoding="async" data-nimg="fill" style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy"/></noscript>' . "\r\n" . '                                    </div>' . "\r\n" . '                                 </div>' . "\r\n" . '                              </div>' . "\r\n" . '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div class="SorteioTpl_info__t1BZr custom-content-wrapper">' . "\r\n" . '                           <h1 class="SorteioTpl_title__3RLtu">';
	echo $row['name'];
	echo '</h1>' . "\r\n" . '                           <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">';
	echo (isset($row['subtitle']) ? $row['subtitle'] : '');
	echo '</p>' . "\r\n" . '                        </div>' . "\r\n" . '                     </a>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '               ';
}

echo "\r\n" . '               ';
$qry = $conn->query('SELECT * FROM `product_list` WHERE featured_draw = \'0\' AND private_draw = \'0\' ORDER BY id DESC LIMIT 10');

if (0 < $qry->num_rows) {
	while ($row = $qry->fetch_assoc()) {
		echo '                     <div class="col-12 mb-2">' . "\r\n" . '                      <a href="/campanha/';
		echo $row['slug'];
		echo '"> ' . "\r\n" . '                         <div class="SorteioTpl_sorteioTpl__2s2Wu   pointer">' . "\r\n" . '                           <div class="SorteioTpl_imagemContainer__2-pl4 col-auto ">' . "\r\n" . '                              <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">' . "\r\n" . '                                 <img alt="1.500,00 com apenas 0,03 centavos" src="';
		echo validate_image($row['image_path']);
		echo '" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">' . "\r\n" . '                                 <noscript><img alt="1.500,00 com apenas 0,03 centavos" src="';
		echo validate_image($row['image_path']);
		echo '" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy"/></noscript>' . "\r\n" . '                              </div>' . "\r\n" . '                           </div>' . "\r\n" . '                           <div class="SorteioTpl_info__t1BZr">' . "\r\n" . '                              <h1 class="SorteioTpl_title__3RLtu">';
		echo $row['name'];
		echo '</h1>' . "\r\n" . '                              <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">';
		echo (isset($row['subtitle']) ? $row['subtitle'] : '');
		echo '</p>' . "\r\n" . '                              ';

		if ($row['status_display'] == 1) {
			echo '                                 <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>' . "\r\n" . '                              ';
		}

		echo '                              ';

		if ($row['status_display'] == 2) {
			echo '                                 <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>' . "\r\n" . '                              ';
		}

		echo '                              ';

		if ($row['status_display'] == 3) {
			echo '                                 <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>' . "\r\n" . '                              ';
		}

		echo '                              ';

		if ($row['status_display'] == 4) {
			echo '                                 <span class="badge bg-dark font-xsss">Concluído</span>' . "\r\n" . '                                 ';
			$date_of_draw = strtotime($row['date_of_draw']);
			$date_of_draw = date('d/m', $date_of_draw);
			echo '                                 <div class="SorteioTpl_dtSorteio__2mfSc"><i class="bi bi-calendar2-check"></i> ';
			echo $date_of_draw;
			echo '</div>' . "\r\n" . '                              ';
		}

		echo '                              ';

		if ($row['status_display'] == 5) {
			echo '                                 <span class="badge bg-dark font-xsss">Em breve!</span>' . "\r\n" . '                              ';
		}

		echo '                              ';

		if ($row['status_display'] == 6) {
			echo '                                 <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>' . "\r\n" . '                              ';
		}

		echo '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                     </a>' . "\r\n" . '                  </div>' . "\r\n" . '               ';
	}

	echo '            ';
}

echo "\r\n" . '            <div class="col-12">' . "\r\n" . '               <div class="app-helpers mb-2">' . "\r\n" . '                  <div class="row">' . "\r\n" . '                     <div class="col col-contato-display">' . "\r\n" . '                        <div class="d-flex align-items-center w-100 justify-content-center font-xs bg-white bg-opacity-25 box-shadow-08 p-2 rounded-10">' . "\r\n" . '                           <div class="icone font-lg bg-dark rounded p-2 me-2 bg-opacity-10">🤷</div>' . "\r\n" . '                           ';

if (CONTACT_TYPE == '1') {
	echo '                              <a href="/contato">' . "\r\n" . '                           ';
}
else {
	echo '                              <a href="';
	echo 'https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone');
	echo '">' . "\r\n" . '                           ';
}

echo '                              <div class="txt">' . "\r\n" . '                                    <h3 class="mb-0 font-md">Dúvidas</h3>' . "\r\n" . '                                    <p class="mb-0 font-xs">Fale conosco</p>' . "\r\n" . '                                 </div>' . "\r\n" . '                              </a>' . "\r\n" . '                           </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '               </div>' . "\r\n" . '            </div>' . "\r\n" . '            ';
$sql = "\r\n" . '            SELECT name AS product_name, draw_number, draw_winner, image_path, slug, date_of_draw' . "\r\n" . '            FROM product_list' . "\r\n" . '            WHERE draw_number <> \'\' ORDER BY date_of_draw DESC LIMIT 5';
$products = $conn->query($sql);

if (0 < $products->num_rows) {
	echo '            <div class="app-ganhadores mb-2 ">' . "\r\n" . '               <div class="col-12">' . "\r\n" . '                  <div class="app-title">' . "\r\n" . '                     <h1>🎉 Ganhadores</h1>' . "\r\n" . '                     <div class="app-title-desc">sortudos</div>' . "\r\n" . '                  </div>' . "\r\n" . '               </div>  ' . "\r\n\r\n" . '               <div class="col-12">' . "\r\n" . '                  <div class="row">' . "\r\n" . '                     ';

	while ($row = $products->fetch_assoc()) {
		$product_name = $row['product_name'];
		$draw_number = $row['draw_number'];
		$draw_name = $row['draw_winner'];
		$draw_number_arr = json_decode(json_encode($draw_number));
		$draw_winner_arr = json_decode(json_encode($draw_name));
		$draw_number = $draw_number_arr[0];
		$draw_name = $draw_winner_arr[0];
		$date_of_draw = strtotime($row['date_of_draw']);
		$date_of_draw = date('d/m/y', $date_of_draw);
		$image_path = validate_image($row['image_path']);

		if (!empty($draw_number_arr)) {
			$draw_number_arr = (isset($draw_number_arr) ? $draw_number_arr : '');

			if ($draw_number_arr) {
				$draw_winner_arr = json_decode($draw_winner_arr, true);
				$draw_number_arr = json_decode($draw_number_arr, true);
				$winners = [];

				foreach ($draw_winner_arr as $qty_index => $name) {
					foreach ($draw_number_arr as $amount_index => $number) {
						$query = $conn->query('SELECT CONCAT(firstname, \' \', lastname) as name, avatar FROM customer_list WHERE phone = \'' . $name . '\'');
						$rowCustomer = $query->fetch_assoc();

						if ($qty_index === $amount_index) {
							$winners[$qty_index] = ['name' => $rowCustomer['name'], 'number' => $number, 'product' => $product_name, 'date' => $date_of_draw, 'image' => ($rowCustomer['avatar'] ? validate_image($rowCustomer['avatar']) : BASE_URL . 'assets/img/avatar.png')];
						}
					}
				}
			}

			foreach ($winners as $winner) {
				echo '                           <a href="/campanha/';
				echo $row['slug'];
				echo '">' . "\r\n" . '                              <div class="ganhadorItem_ganhadorContainer__1Sbxm mb-2">' . "\r\n" . '                                 <div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">' . "\r\n" . '                                    <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">' . "\r\n" . '                                       <img alt="';
				echo $winner['product'];
				echo ' ganhador do prêmio ';
				echo $winner['product'];
				echo '" src="';
				echo $winner['image'];
				echo '" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">' . "\r\n" . '                                       <noscript><img alt="';
				echo $draw_name;
				echo ' ganhador do prêmio ';
				echo $winner['product'];
				echo '" src="';
				echo $winner['image'];
				echo '" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" loading="lazy" /></noscript>' . "\r\n" . '                                    </div>' . "\r\n" . '                                 </div>' . "\r\n" . '                                 <div class="undefined w-100">' . "\r\n" . '                                    <h3 class="ganhadorItem_ganhadorNome__2j_J-" style="text-transform: uppercase;">';
				echo $winner['name'];
				echo '</h3>' . "\r\n" . '                                    <div class="ganhadorItem_ganhadorDescricao__Z4kO2">' . "\r\n" . '                                       <p class="mb-0" style="text-transform:uppercase;"><b>';
				echo $winner['product'];
				echo '</b></p>' . "\r\n" . '                                       <p class="mb-0">Número da sorte <b> ';
				echo $winner['number'];
				echo ' </b></p>' . "\r\n" . '                                       <p class="mb-0">Data da premiação <b> ';
				echo $winner['date'];
				echo ' </b></p>' . "\r\n" . '                                    </div>' . "\r\n" . '                                 </div>' . "\r\n" . '                              </div>' . "\r\n" . '                           </a>' . "\r\n" . '                        ';
			}

			echo '                     ';
		}

		echo '                  ';
	}

	echo '               </div>' . "\r\n" . '            </div>' . "\r\n" . '         </div>' . "\r\n" . '      ';
}

echo '         <!-- Perguntas frequentes -->' . "\r\n" . '         <div class="app-perguntas">' . "\r\n" . '            <div class="app-title">' . "\r\n" . '               <h1>🙋🏼 Perguntas frequentes</h1>' . "\r\n" . '            </div>' . "\r\n" . '            <div id="perguntas-box">' . "\r\n" . '               ';
if (!!$_settings->info('question1') && !!$_settings->info('answer1')) {
	echo "\r\n" . '                  <div class="mb-2">' . "\r\n" . '                     <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">' . "\r\n" . '                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d4b6bd40368220230114" aria-expanded="false" aria-controls="pergunta-63c30d4b6bd40368220230114"><i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i> <span>' . $_settings->info('question1') . '</span></div>' . "\r\n" . '                        <div class="d-block">' . "\r\n" . '                           <div class="pergunta-item--resp mt-1 collapse" id="pergunta-63c30d4b6bd40368220230114" data-bs-parent="#perguntas-box" style="">' . "\r\n" . '                              <p class="mb-0">' . $_settings->info('answer1') . '</p>' . "\r\n" . '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '                  ';
}
if (!!$_settings->info('question2') && !!$_settings->info('answer2')) {
	echo "\r\n" . '                  <div class="mb-2">' . "\r\n" . '                     <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">' . "\r\n" . '                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-1" aria-expanded="false" aria-controls="pergunta-1"><i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i> <span>' . $_settings->info('question2') . '</span></div>' . "\r\n" . '                        <div class="d-block">' . "\r\n" . '                           <div class="pergunta-item--resp mt-1 collapse" id="pergunta-1" data-bs-parent="#perguntas-box" style="">' . "\r\n" . '                              <p class="mb-0">' . $_settings->info('answer2') . '</p>' . "\r\n" . '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '                  ';
}
if (!!$_settings->info('question3') && !!$_settings->info('answer3')) {
	echo "\r\n" . '                  <div class="mb-2">' . "\r\n" . '                     <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">' . "\r\n" . '                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-2" aria-expanded="false" aria-controls="pergunta-2"><i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i> <span>' . $_settings->info('question3') . '</span></div>' . "\r\n" . '                        <div class="d-block">' . "\r\n" . '                           <div class="pergunta-item--resp mt-1 collapse" id="pergunta-2" data-bs-parent="#perguntas-box" style="">' . "\r\n" . '                              <p class="mb-0">' . $_settings->info('answer3') . '</p>' . "\r\n" . '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '                  ';
}
if (!!$_settings->info('question4') && !!$_settings->info('answer4')) {
	echo "\r\n" . '                  <div class="mb-2">' . "\r\n" . '                     <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">' . "\r\n" . '                        <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-3" aria-expanded="false" aria-controls="pergunta-3"><i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i> <span>' . $_settings->info('question4') . '</span></div>' . "\r\n" . '                        <div class="d-block">' . "\r\n" . '                           <div class="pergunta-item--resp mt-1 collapse" id="pergunta-3" data-bs-parent="#perguntas-box" style="">' . "\r\n" . '                              <p class="mb-0">' . $_settings->info('answer4') . '</p>' . "\r\n" . '                           </div>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '                  ';
}

echo '               ';
global $enable_password;

if ($enable_password == 1) {
	echo '               <div class="mb-2">' . "\r\n" . '                  <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">' . "\r\n" . '                     <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-4" aria-expanded="false" aria-controls="pergunta-4"><i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i> <span>Esqueci minha senha, como faço?</span></div>' . "\r\n" . '                     <div class="d-block">' . "\r\n" . '                        <div class="pergunta-item--resp mt-1 collapse" id="pergunta-4" data-bs-parent="#perguntas-box" style="">' . "\r\n" . '                           <p class="mb-0">Você consegue recuperar sua senha indo no menu do site, depois em "Entrar" e logo a baixo tem "Esqueci&nbsp;minha senha".</p>' . "\r\n" . '                        </div>' . "\r\n" . '                     </div>' . "\r\n" . '                  </div>' . "\r\n" . '               </div>' . "\r\n" . '            ';
}

echo '            </div>' . "\r\n" . '         </div>' . "\r\n" . '         <!--Fim perguntas frequentes -->' . "\r\n" . '      </div>' . "\r\n" . '   </div>' . "\r\n" . '</div>';

?>