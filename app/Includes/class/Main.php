
<?php
include app_path('Includes/settings.php');
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);


if (!class_exists('DBConnection')) {
    require app_path('Includes/settings.php');
    

};
$sysset = new System();





class Main extends DBConnection
{

    public function __construct()
    {
        global $_settings;
        if (!isset($_settings)) {
            $_settings = new System();
        }
        $this->settings = $_settings;
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }

    public function capture_err()
    {
        if (!$this->conn->error) {
            return false;
        } else {
            $resp["status"] = "failed";
            $resp["error"] = $this->conn->error;
            return json_encode($resp);
            exit();
        }
    }
    public function duplicate_product() {
		$id = $_POST['id'];
	
		// Verifica se o ID foi fornecido
		if (empty($id)) {
			echo "ID não fornecido.";
			return;
		}
	
		// Seleciona o registro original do banco de dados
		$qry = $this->conn->query('SELECT * FROM `product_list` WHERE id = \'' . $this->conn->real_escape_string($id) . '\'');
	
		if ($qry->num_rows > 0) {
			$product = $qry->fetch_assoc();
	
			// Prepara os dados para o novo registro
			// Supondo que 'id' é a chave primária e auto-incrementada, então não a incluímos na inserção
			unset($product['id']);
            unset($product['created_at']);
            unset($product['updated_at']);
            unset($product['date_of_draw']);
            $product['paid_numbers'] = 0;
            $product['pending_numbers'] = 0;

            $slug = slugify($product['name']);
        $check_slug = $this->conn->query(
            'SELECT * FROM `product_list` where `slug` LIKE \'' . $slug . '%\''
        )->num_rows;


        if (0 < $check_slug) {
            $check_slug += 1;
            $slug = $slug . "-" . strval($check_slug);
        }
        $product['slug'] = $slug;
	
			$columns = implode(", ", array_keys($product));
			$values  = implode("', '", array_map(array($this->conn, 'real_escape_string'), array_values($product)));
	
			// Insere o novo registro no banco de dados
			$insert_qry = 'INSERT INTO `product_list` (' . $columns . ') VALUES (\'' . $values . '\')';
			if ($this->conn->query($insert_qry) === TRUE) {
				$resp["status"] = "success";
                $resp["msg"] = "Registro duplicado com sucesso.";
                $resp["pid"] = $this->conn->insert_id;

			} else {
				echo "Erro ao duplicar o registro: " . $this->conn->error;
			}
		} else {
			echo "Registro não encontrado.";
		}
        return json_encode($resp);
	}
	
    public function save_product()
    {
       
    

        $id = $_POST["id"];
        $name = $this->conn->real_escape_string(
            filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS)
        );
        $description = $this->conn->real_escape_string(
            filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS)
        );
        $type_of_draw = $this->conn->real_escape_string($_POST["type_of_draw"]);
        $qty_numbers = $this->conn->real_escape_string($_POST["qty_numbers"]);

        if ($type_of_draw == 3) {
            $qty_numbers = 25;
        }

        if ($type_of_draw == 4) {
            $qty_numbers = 50;
        }
        $price = isset($_POST["price"]) ? $_POST["price"] : 0;
        $price = str_replace(",", ".", $price);

        $price = number_format((float) $price, 2, "." , "");
        $limit_orders = isset($_POST["limit_orders"]) ? $_POST['limit_orders'] : 0;
        $min_purchase = $this->conn->real_escape_string($_POST["min_purchase"]);
        $max_purchase = $this->conn->real_escape_string($_POST["max_purchase"]);
        $status = $this->conn->real_escape_string($_POST["status"]);
        $pending_numbers = $this->conn->real_escape_string("0");
        $paid_numbers = $this->conn->real_escape_string("0");
        $discount_qty = json_encode($_POST["discount_qty"]);
        $discount_amount = $_POST["discount_amount"];
        $discount_amount = array_map(function ($value) {
            $value = str_replace(",", ".", $value);
            $value = number_format((float) $value, 2, ".", "");
            return $value;
        }, $discount_amount);
        $discount_amount = json_encode($discount_amount);
        $draw_name_list = filter_var(
            $_POST["draw_name"],
            FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY
        );
        $draw_name_json_str = json_encode($draw_name_list);
        $draw_name_json_escaped = $this->conn->real_escape_string(
            $draw_name_json_str
        );
        $draw_name = $draw_name_json_escaped;
        $draw_number = json_encode($_POST["draw_number"]);

        if ($draw_name == '[""]') {
            $draw_name = "";
        }

        if ($draw_number == '[""]') {
            $draw_number = "";
        }
        $enable_discount = isset($_POST["enable_discount"]) ? 1 : 0;
        $enable_discount = $this->conn->real_escape_string($enable_discount);
        $enable_cumulative_discount = isset(
            $_POST["enable_cumulative_discount"]
        )
            ? 1
            : 0;
        $enable_cumulative_discount = $this->conn->real_escape_string(
            $enable_cumulative_discount
        );
        $ranking_qty = $this->conn->real_escape_string($_POST["ranking_qty"])
            ? $this->conn->real_escape_string($_POST["ranking_qty"])
            : 0;

        $ranking_1 = $this->conn->real_escape_string($_POST["ranking_1"]) ? $this->conn->real_escape_string($_POST["ranking_1"]) : null;
        $ranking_2 = $this->conn->real_escape_string($_POST["ranking_2"]) ? $this->conn->real_escape_string($_POST["ranking_2"]) : null;
        $ranking_3 = $this->conn->real_escape_string($_POST["ranking_3"]) ? $this->conn->real_escape_string($_POST["ranking_3"]) : null;
        $ranking_4 = $this->conn->real_escape_string($_POST["ranking_4"]) ? $this->conn->real_escape_string($_POST["ranking_4"]) : null;
        $ranking_5 = $this->conn->real_escape_string($_POST["ranking_5"]) ? $this->conn->real_escape_string($_POST["ranking_5"]) : null;

        $enable_ranking = isset($_POST["enable_ranking"]) ? 1 : 0;
        $enable_ranking = $this->conn->real_escape_string($enable_ranking);
        $ranking_message = $this->conn->real_escape_string(
            $_POST["ranking_message"]
        );
        $enable_ranking_show = isset($_POST["enable_ranking_show"]) ? 1 : 0;
        $enable_ranking_show = $this->conn->real_escape_string(
            $enable_ranking_show
        );
        $ranking_type = $this->conn->real_escape_string($_POST["ranking_type"]);
        $enable_progress_bar = isset($_POST["enable_progress_bar"]) ? 1 : 0;
        $enable_progress_bar = $this->conn->real_escape_string(
            $enable_progress_bar
        );
        $status_display = $this->conn->real_escape_string(
            $_POST["status_display"]
        );
        $subtitle = $this->conn->real_escape_string($_POST["subtitle"]);
        $cotas_premiadas = $this->conn->real_escape_string(
            $_POST["cotas_premiadas"]
        );
        $cotas_premiadas_descricao = $this->conn->real_escape_string(
            $_POST["cotas_premiadas_descricao"]
        );
        $cotas_premiadas_premios = $this->conn->real_escape_string(
            $_POST["cotas_premiadas_premios"]
        );
        $date_of_draw = $this->conn->real_escape_string($_POST["date_of_draw"]);
        $date_of_draw = $date_of_draw ? '\'' . $date_of_draw . '\'' : "NULL";
        $limit_order_remove = $this->conn->real_escape_string(
            $_POST["limit_order_remove"]
        );
        $qty_select_1 = $this->conn->real_escape_string($_POST["qty_select_1"]);
        $qty_select_2 = $this->conn->real_escape_string($_POST["qty_select_2"]);
        $qty_select_3 = $this->conn->real_escape_string($_POST["qty_select_3"]);
        $qty_select_4 = $this->conn->real_escape_string($_POST["qty_select_4"]);
        $qty_select_5 = $this->conn->real_escape_string($_POST["qty_select_5"]);
        $qty_select_6 = $this->conn->real_escape_string($_POST["qty_select_6"]);
        $enable_sale = isset($_POST["enable_sale"]) ? 1 : 0;
        $enable_sale = $this->conn->real_escape_string($enable_sale);
        $sale_price = $this->conn->real_escape_string(0);
        $sale_qty = 0;
        $sale_price = str_replace(".", "", $sale_price);
        $sale_price = str_replace(",", ".", $sale_price);
        $sale_price = (float) $sale_price;
        $private_draw = isset($_POST["private_draw"]) ? 1 : 0;
        $private_draw = $this->conn->real_escape_string($private_draw);
        $featured_draw = isset($_POST["featured_draw"]) ? 1 : 0;
        $featured_draw = $this->conn->real_escape_string($featured_draw);
        $status_auto_cota = isset($_POST["status_auto_cota"]) == 1 ? 1 : 0;
        $valor_base_auto = intval($_POST["valor_base_auto"]);
        $slug = slugify($name);
        $check_slug = $this->conn->query(
            'SELECT * FROM `product_list` where `slug` LIKE \'' . $slug . '%\''
        )->num_rows;

        if (0 < $check_slug) {
            $check_slug += 1;
            $slug = $slug . "-" . strval($check_slug);
        }



        $sql = "";
          if (empty($id)){
     $resp['feedback'] = 'criada';
 } else {
     $resp['feedback'] = 'atualizada';
 };
        if (empty($id)) {
            $sql =
                'INSERT INTO `product_list` (`name`,`description`,`price`,`status`,`type_of_draw`,`qty_numbers`,`limit_orders`,`min_purchase`,`max_purchase`,`slug`,`pending_numbers`,`paid_numbers`,`ranking_qty`,`ranking_1`,`ranking_2`,`ranking_3`,`ranking_4`,`ranking_5`,`enable_ranking`,`enable_progress_bar`,`draw_number`,`status_display`, `subtitle`, `cotas_premiadas`, `cotas_premiadas_premios`, `cotas_premiadas_descricao`, `date_of_draw`, `limit_order_remove`,`discount_qty`,`discount_amount`,`enable_discount`,`enable_cumulative_discount`,`enable_sale`,`sale_qty`,`sale_price`,`ranking_message`,`enable_ranking_show`,`ranking_type`,`draw_winner`,`private_draw`,`featured_draw`,`qty_select_1`,`qty_select_2`,`qty_select_3`,`qty_select_4`,`qty_select_5`,`qty_select_6`,`status_auto_cota`,`valor_base_auto`) VALUES (\'' .
                $name .
                '\',\'' .
                $description .
                '\',\'' .
                $price .
                '\',\'' .
                $status .
                '\',\'' .
                $type_of_draw .
                '\',\'' .
                $qty_numbers .
                '\',\'' .
                $limit_orders .
                '\',\'' .
                $min_purchase .
                '\',\'' .
                $max_purchase .
                '\',\'' .
                $slug .
                '\',\'' .
                $pending_numbers .
                '\',\'' .
                $paid_numbers .
                '\',\'' .
                $ranking_qty .
                '\', \'' .
                $ranking_1 .
                '\', \'' .
                $ranking_2 .
                '\', \'' .
                $ranking_3 .
                '\', \'' .
                $ranking_4 .
                '\', \'' .
                $ranking_5 .
                '\', \'' .
                $enable_ranking .
                '\', \'' .
                $enable_progress_bar .
                '\', \'' .
                $draw_number .
                '\', \'' .
                $status_display .
                '\', \'' .
                $subtitle .
                '\', \'' .
                $cotas_premiadas .
                '\', \'' .
                $cotas_premiadas_premios .
                '\', \'' .
                $cotas_premiadas_descricao .
                '\', ' .
                $date_of_draw .
                ', \'' .
                $limit_order_remove .
                '\',\'' .
                $discount_qty .
                '\',\'' .
                $discount_amount .
                '\', \'' .
                $enable_discount .
                '\', \'' .
                $enable_cumulative_discount .
                '\', \'' .
                $enable_sale .
                '\', \'' .
                $sale_qty .
                '\', \'' .
                $sale_price .
                '\', \'' .
                $ranking_message .
                '\', \'' .
                $enable_ranking_show .
                '\', \'' .
                $ranking_type .
                '\', \'' .
                $draw_name .
                '\', \'' .
                $private_draw .
                '\', \'' .
                $featured_draw .
                '\', \'' .
                $qty_select_1 .
                '\', \'' .
                $qty_select_2 .
                '\', \'' .
                $qty_select_3 .
                '\', \'' .
                $qty_select_4 .
                '\', \'' .
                $qty_select_5 .
                '\', \'' .
                $qty_select_6 .
                '\' , \'' .
                $status_auto_cota .
                '\', \'' .
                $valor_base_auto .
                '\') ';
        } else {
            $sql =
                "UPDATE `product_list`" .
                "\r\n\t\t\t" .
                'SET `name` = \'' .
                $name .
                '\', `description` = \'' .
                $description .
                '\', `price` = \'' .
                $price .
                '\', `status` = \'' .
                $status .
                '\', `type_of_draw` = \'' .
                $type_of_draw .
                '\', `qty_numbers` = \'' .
                $qty_numbers .
                '\', `limit_orders` = \'' .
                $limit_orders .
                '\', `min_purchase` = \'' .
                $min_purchase .
                '\', `max_purchase` = \'' .
                $max_purchase .
                '\', `slug` = \'' .
                $slug .
                '\', `ranking_qty` = \'' .
                $ranking_qty .
                '\', `ranking_1` = \'' .
                $ranking_1 .
                '\', `ranking_2` = \'' .
                $ranking_2 .
                '\', `ranking_3` = \'' .
                $ranking_3 .
                '\', `ranking_4` = \'' .
                $ranking_4 .
                '\', `ranking_5` = \'' .
                $ranking_5 .
                '\', `enable_ranking` = \'' .
                $enable_ranking .
                '\', `enable_progress_bar` = \'' .
                $enable_progress_bar .
                '\', `draw_number` = \'' .
                $draw_number .
                '\', `status_display` = \'' .
                $status_display .
                '\', `subtitle` = \'' .
                $subtitle .
                '\', `cotas_premiadas` = \'' .
                $cotas_premiadas .
                '\', `cotas_premiadas_premios` = \'' .
                $cotas_premiadas_premios .
                '\', `cotas_premiadas_descricao` = \'' .
                $cotas_premiadas_descricao .
                '\', `date_of_draw` = ' .
                $date_of_draw .
                ', `limit_order_remove` = \'' .
                $limit_order_remove .
                '\', `discount_qty` = \'' .
                $discount_qty .
                '\', `discount_amount` = \'' .
                $discount_amount .
                '\', `enable_discount` = \'' .
                $enable_discount .
                '\', `enable_cumulative_discount` = \'' .
                $enable_cumulative_discount .
                '\', `enable_sale` = \'' .
                $enable_sale .
                '\', `sale_qty` = \'' .
                $sale_qty .
                '\', `sale_price` = \'' .
                $sale_price .
                '\', `ranking_message` = \'' .
                $ranking_message .
                '\', `enable_ranking_show` = \'' .
                $enable_ranking_show .
                '\', `ranking_type` = \'' .
                $ranking_type .
                '\', `draw_winner` = \'' .
                $draw_name .
                '\', `private_draw` = \'' .
                $private_draw .
                '\', `featured_draw` = \'' .
                $featured_draw .
                '\', `qty_select_1` = \'' .
                $qty_select_1 .
                '\', `qty_select_2` = \'' .
                $qty_select_2 .
                '\', `qty_select_3` = \'' .
                $qty_select_3 .
                '\', `qty_select_4` = \'' .
                $qty_select_4 .
                '\', `qty_select_5` = \'' .
                $qty_select_5 .
                '\', `qty_select_6` = \'' .
                $qty_select_6 .
                '\' ,`status_auto_cota` = \'' .
                $status_auto_cota .
                '\',`valor_base_auto` = \'' .
                $valor_base_auto .
                '\' WHERE `id` = ' .
                $id .
                ";";
        }

        $save = $this->conn->query($sql);

        if ($save) {
            $pid = !empty($id) ? $id : $this->conn->insert_id;
            $resp["pid"] = $pid;
            $resp["status"] = "success";


            if (!empty($_FILES["img"]["tmp_name"])) {
                $img_path = public_path('/uploads/campanhas'); // Caminho ajustado
            
                // Criar diretório se não existir
                if (!is_dir($img_path)) {
                    mkdir($img_path, 0755, true); // Garantir que o diretório seja criado com permissões adequadas
                }
            
                $accept = ["image/jpeg", "image/png"];
            
                if (!in_array($_FILES["img"]["type"], $accept)) {
                    $resp["msg"] = "Tipo de arquivo de imagem inválido";
                } else {
                    // Criar recurso de imagem com base no tipo de arquivo
                    $uploadfile = false;
                    if ($_FILES["img"]["type"] == "image/jpeg") {
                        $uploadfile = imagecreatefromjpeg($_FILES["img"]["tmp_name"]);
                    } elseif ($_FILES["img"]["type"] == "image/png") {
                        $uploadfile = imagecreatefrompng($_FILES["img"]["tmp_name"]);
                    }
            
                    if (!$uploadfile) {
                        $resp["msg"] = "Imagem inválida";
                    } else {
                        list($width, $height) = getimagesize($_FILES["img"]["tmp_name"]);
                        $desired_width = 576;
                        $desired_height = 450;
                        $source_aspect_ratio = $width / $height;
                        $desired_aspect_ratio = $desired_width / $desired_height;
            
                        if ($desired_aspect_ratio < $source_aspect_ratio) {
                            $temp_height = $desired_height;
                            $temp_width = (int) ($desired_height * $source_aspect_ratio);
                        } else {
                            $temp_width = $desired_width;
                            $temp_height = (int) ($desired_width / $source_aspect_ratio);
                        }
            
                        // Redimensionar a imagem
                        $temp_resized = imagecreatetruecolor($temp_width, $temp_height);
                        imagecopyresampled($temp_resized, $uploadfile, 0, 0, 0, 0, $temp_width, $temp_height, $width, $height);
            
                        // Recortar a imagem para o tamanho desejado
                        $x = ($temp_width - $desired_width) / 2;
                        $y = ($temp_height - $desired_height) / 2;
                        $temp_cropped = imagecrop($temp_resized, [
                            "x" => $x,
                            "y" => $y,
                            "width" => $desired_width,
                            "height" => $desired_height,
                        ]);
            
                        // Verificar se o nome do arquivo já existe
                        $spath = 'uploads/campanhas/' . $_FILES["img"]["name"];
                        $i = 1;
                        while (is_file(public_path($spath))) {
                            $spath = 'uploads/campanhas/' . $i++ . "_" . $_FILES["img"]["name"];
                        }
            
                        // Salvar a imagem recortada
                        $upload = false;
                        if ($_FILES["img"]["type"] == "image/jpeg") {
                            $upload = imagejpeg($temp_cropped, public_path($spath), 95);
                        } elseif ($_FILES["img"]["type"] == "image/png") {
                            $upload = imagepng($temp_cropped, public_path($spath), 9);
                        }
            
                        if ($upload) {
                            // Assume que $this->conn e $pid estão definidos e são válidos
                            $stmt = $this->conn->prepare('UPDATE product_list SET image_path = CONCAT(?, \'?v=\', UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) WHERE id = ?');
                            $stmt->bind_param('si', $spath, $pid);
                            $stmt->execute();
                            $stmt->close();
                        } 
                        
                        
      
                        imagedestroy($temp_cropped);
                        imagedestroy($temp_resized);
                        imagedestroy($uploadfile);
                    }
                }
            }
             else {
                $resp["msg"] = "No image file uploaded.";
                
            }


            $on_gallery = isset($_POST["on-gallery"]) ? $_POST["on-gallery"] : "";
            $image_gallery = !array_filter($_FILES["image_gallery"]["name"]);
            
            if (!$on_gallery && $image_gallery) {
                $this->conn->query(
                    "UPDATE product_list SET image_gallery = '[]' WHERE id = '$pid'"
                );
            }
            
            if (isset($_FILES["image_gallery"])) {
                $img_path = public_path('/uploads/campanhas');
            
                // Criar diretório se não existir
                if (!is_dir($img_path)) {
                    mkdir($img_path, 0755, true);
                }
            
                $accept = ["image/jpeg", "image/png"];
                $image_paths = [];
            
            
                foreach ($_FILES["image_gallery"]["tmp_name"] as $index => $tmp_name) {
                    if (!in_array($_FILES["image_gallery"]["type"][$index], $accept)) {
                        $resp["msg"] .= "Tipo de arquivo de imagem galeria inválido. ";
                    } else {
                        if ($_FILES["image_gallery"]["type"][$index] == "image/jpeg") {
                            $uploadfile = imagecreatefromjpeg($tmp_name);
                        } elseif ($_FILES["image_gallery"]["type"][$index] == "image/png") {
                            $uploadfile = imagecreatefrompng($tmp_name);
                        }
            
                        if (!$uploadfile) {
                            $resp["msg"] .= "Imagem inválida. ";
                        } else {
                            list($width, $height) = getimagesize($tmp_name);
            
                            if (600 < $width || 600 < $height) {
                                $ratio = $width / $height;
                                $new_width = 600;
                                $new_height = $new_width / $ratio;
            
                                if ($new_height < 600) {
                                    $new_height = 600;
                                    $new_width = $new_height * $ratio;
                                }
            
                                $temp_resized = imagecreatetruecolor($new_width, $new_height);
                                imagecopyresampled($temp_resized, $uploadfile, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                                $x = ($new_width - 600) / 2;
                                $y = ($new_height - 600) / 2;
                                $temp_cropped = imagecrop($temp_resized, [
                                    "x" => $x,
                                    "y" => $y,
                                    "width" => 600,
                                    "height" => 600,
                                ]);
            
                                if ($temp_cropped) {
                                    $spath = $img_path . '/' . $_FILES["image_gallery"]["name"][$index];
                                    $i = 1;
            
                                    while (is_file($spath)) {
                                        $spath = $img_path . '/' . $i++ . "_" . $_FILES["image_gallery"]["name"][$index];
                                    }
            
                                    if ($_FILES["image_gallery"]["type"][$index] == "image/jpeg") {
                                        $upload = imagejpeg($temp_cropped, $spath, 95);
                                    } elseif ($_FILES["image_gallery"]["type"][$index] == "image/png") {
                                        $upload = imagepng($temp_cropped, $spath, 9);
                                    }
            
                                    if ($upload) {
                                        $image_paths[] = str_replace(public_path(), '', $spath);
                                    }
            
                                    imagedestroy($temp_cropped);
                                }
            
                                imagedestroy($temp_resized);
                            } else {
                                $spath = $img_path . '/' . $_FILES["image_gallery"]["name"][$index];
                                $i = 1;
            
                                while (is_file($spath)) {
                                    $spath = $img_path . '/' . $i++ . "_" . $_FILES["image_gallery"]["name"][$index];
                                }
            
                                if ($_FILES["image_gallery"]["type"][$index] == "image/jpeg") {
                                    $upload = imagejpeg($uploadfile, $spath, 95);
                                } elseif ($_FILES["image_gallery"]["type"][$index] == "image/png") {
                                    $upload = imagepng($uploadfile, $spath, 9);
                                }
            
                                if ($upload) {
                                    $image_paths[] = str_replace(public_path(), '', $spath);
                                }
                            }
            
                            imagedestroy($uploadfile);
                        }
                    }
                }
            
                if ($on_gallery) {
                    $on_gallery_arr = [];
            
                    foreach ($on_gallery as $img_gallery) {
                        $on_gallery_arr[] = $img_gallery;
                    }
            
                    $image_paths = json_encode(array_merge($on_gallery_arr, $image_paths));
                } else {
                    $image_paths = json_encode($image_paths, true);
                }
            
                $image_paths_str = $this->conn->real_escape_string($image_paths);
                $this->conn->query(
                    "UPDATE product_list SET image_gallery = '$image_paths_str' WHERE id = '$pid'"
                );
            }
            
        } else {
            $resp["status"] = "failed";
            $resp["err"] = $this->conn->error . ("[" . $sql . "]");
        }
        
       
        if ($resp["status"] == "success" && isset($resp["msg"])) {
            return json_encode($resp);
        }
    }

    public function delete_product()
    {
        
        global $_settings;
        $this->settings = $_settings;
        
        extract($_POST);
        $del = $this->conn->query(
            'DELETE FROM `product_list` where id = \'' . $id . '\''
        );

        if ($del) {
            $resp["status"] = "success";
        } else {
            $resp["status"] = "failed";
            $resp["error"] = $this->conn->error;
        }

        return json_encode($resp);
    }

    public function add_to_card()
    {
        extract($_POST);
        $customer_id = $this->settings->userdata("id");
        $delete = $this->conn->query(
            'DELETE FROM `cart_list` WHERE customer_id = \'' .
                $customer_id .
                '\''
        );

        if ($delete) {
            $check = $this->conn->query(
                'SELECT id FROM `cart_list` WHERE customer_id = \'' .
                    $customer_id .
                    '\' AND product_id = \'' .
                    $product_id .
                    '\''
            )->num_rows;

            if (0 < $check) {
                $update = $this->conn->query(
                    'UPDATE `cart_list` SET quantity = \'' .
                        $qty .
                        '\' WHERE customer_id = \'' .
                        $customer_id .
                        '\' AND product_id = \'' .
                        $product_id .
                        '\''
                );

                if ($update) {
                    $resp["status"] = "success";
                } else {
                    $resp["status"] = "failed";
                    $resp["error"] = $this->conn->error;
                }
            } else {
                $insert = $this->conn->query(
                    'INSERT INTO `cart_list` (`customer_id`, `product_id`, `quantity`) VALUES (\'' .
                        $customer_id .
                        '\', \'' .
                        $product_id .
                        '\', \'' .
                        $qty .
                        '\')'
                );

                if ($insert) {
                    $resp["status"] = "success";
                } else {
                    $resp["status"] = "failed";
                    $resp["error"] = $this->conn->error;
                }
            }
        } else {
            $resp["status"] = "failed";
            $resp["error"] = $this->conn->error;
        }

        if ($resp["status"] == "success") {
        }

        return json_encode($resp);
    }

    public function create_order()
    {
        global $_settings;
        $this->settings = $_settings;
        extract($_POST);
        $pref = date("Ymdhis.u");
        $code = "M-" . uniqidReal();
        $order_token = md5($pref . $code);
        $dateCreated = date("Y-m-d H:i:s");
        $payment_method = "Manual";
        $customer_query = $this->conn
            ->query(
                'SELECT id FROM customer_list WHERE phone = \'' .
                    $phone .
                    '\''
            )
            ->fetch_assoc();
        $customer_id = $customer_query["id"];

        if (!$customer_id) {
            $resp["status"] = "failed";
            $resp["msg"] = "Usuário não localizado.";
            return json_encode($resp);
        }

        $product_info = $this->conn
            ->query(
                'SELECT name, limit_order_remove, paid_numbers, pending_numbers, qty_numbers FROM product_list WHERE id = \'' .
                    $product_id .
                    '\''
            )
            ->fetch_assoc();
        $product_name = $product_info["name"];
        $order_expiration = $product_info["limit_order_remove"];
        $paid_numbers = $product_info["paid_numbers"];
        $pending_numbers = $product_info["pending_numbers"];
        $qty_numbers = $product_info["qty_numbers"];

        if ($qty_numbers < $quantidade + $paid_numbers + $pending_numbers) {
            $resp["status"] = "failed";
            $resp["msg"] = "A quantidade ultrapassa o limite disponível";
            return json_encode($resp);
        }

        $insert = $this->conn->query(
            "INSERT INTO `order_list` " .
                "\r\n\t\t" .
                "(`code`, `customer_id`, `product_name`, `quantity`, `status`, `total_amount`, `order_token`, `order_numbers`, `product_id`, `payment_method`, `order_expiration`, `date_created`, `date_updated`) " .
                "\r\n\t\t" .
                "VALUES " .
                "\r\n\t\t" .
                '(\'' .
                $code .
                '\', \'' .
                $customer_id .
                '\', \'' .
                $product_name .
                '\', \'' .
                $quantity .
                '\', \'' .
                $status .
                '\', \'' .
                $total_amount .
                '\', \'' .
                $order_token .
                '\', \'' .
                $order_numbers .
                '\', \'' .
                $product_id .
                '\', \'' .
                $payment_method .
                '\', \'' .
                $order_expiration .
                '\', \'' .
                $dateCreated .
                '\', \'' .
                $dateCreated .
                '\') '
        );

        if ($insert) {
            $oid = $this->conn->insert_id;
            $insert = $this->conn->query(
                "INSERT INTO `order_items` " .
                    "\r\n\t\t\t" .
                    "(`order_id`, `product_id`, `quantity`, `price`) " .
                    "\r\n\t\t\t" .
                    "VALUES " .
                    "\r\n\t\t\t" .
                    '(\'' .
                    $oid .
                    '\', \'' .
                    $product_id .
                    '\', \'' .
                    $quantity .
                    '\', \'' .
                    $total_amount .
                    '\') '
            );

            if ($status == 1) {
                $this->conn->query(
                    'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` + \'' .
                        $quantity .
                        '\' WHERE `id` = \'' .
                        $product_id .
                        '\''
                );
            } elseif ($status == 2) {
                $this->conn->query(
                    'UPDATE `product_list` SET `paid_numbers` = `paid_numbers` + \'' .
                        $quantity .
                        '\' WHERE `id` = \'' .
                        $product_id .
                        '\''
                );
            }

            $this->correct_stock($raffle);
            $resp["status"] = "success";
            $resp["msg"] = "Pedido criado com sucesso!";
            $user_name = 'success';
            $insert = $this->conn->query(
                'INSERT INTO `logs` (`origin`, `description`) VALUES (\'ORDER\', \'Pedido manual ' .
                    $oid .
                    " criado pelo usuário " .
                    $user_name .
                    '\')'
            );
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = "Erro ao criar pedido manual";
        }

        return json_encode($resp);
    }

    public function create_payment_affiliate()
    {
        global $_settings;
        $this->settings = $_settings;
        if (!$this->settings->userdata("id")) {
            $resp["status"] = "failed";
            $resp["msg"] = "Não autorizado.";
            return json_encode($resp);
        }

        extract($_POST);
        $get_aff = $this->conn->query(
            'SELECT r.referral_code FROM referral r INNER JOIN customer_list c ON c.id = r.customer_id WHERE c.id = \'' .
                $referral_id .
                '\''
        );

        if (0 < $get_aff->num_rows) {
            $row = $get_aff->fetch_assoc();
            $referral_code = $row["referral_code"];
        }

        $insert = $this->conn->query(
            "INSERT INTO referral_transactions (total_amount, referral_id) VALUES (" .
                $price .
                ", " .
                $referral_code .
                ")"
        );
        

        if ($insert) {
            $update = $this->conn->query(
                "UPDATE referral SET amount_paid = amount_paid + " .
                    $price .
                    ' WHERE referral_code = \'' .
                    $referral_code .
                    '\''
            );
            $update = $this->conn->query(
                "UPDATE referral SET amount_pending = amount_pending - " .
                    $price .
                    ' WHERE referral_code = \'' .
                    $referral_code .
                    '\''
            );
            $resp["status"] = "success";
            $resp["msg"] = "Pagamento cadastrado com sucesso!";
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = "Erro ao criar pedido manual";
        }

        return json_encode($resp);
    }

    public function create_affiliate()
    {
      global $_settings;
        $this->settings = $_settings;
        extract($_POST);
        $percentage = str_replace(",", ".", $percentage);
        $user_id = $this->conn->query(
            'SELECT id FROM customer_list WHERE phone = \'' . $customer . '\''
        );

        if (0 < $user_id->num_rows) {
            if (0 < $user_id->num_rows) {
                $row = $user_id->fetch_assoc();
                $user_id = $row["id"];
                $user_verify = $this->conn->query(
                    "SELECT id FROM referral WHERE customer_id = " . $user_id
                );

                if (0 < $user_verify->num_rows) {
                    $update = $this->conn->query(
                        "UPDATE referral SET percentage = " .
                            $percentage .
                            ", status = " .
                            $status .
                            ' WHERE customer_id = \'' .
                            $user_id .
                            '\''
                    );

                    if ($update) {
                        $resp["status"] = "success";
                        $resp["msg"] = "Afiliado atualizado com sucesso";
                    } else {
                        $resp["status"] = "failed";
                        $resp["msg"] = "Erro ao atualizar afiliado";
                    }
                } elseif ($user_id) {
                    $insert = $this->conn->query(
                        "INSERT INTO referral" .
                            "\r\n\t\t\t\t\t\t\t" .
                            "(status, referral_code, percentage, amount_paid, amount_pending, customer_id)" .
                            "\r\n\t\t\t\t\t\t\t" .
                            "VALUES (" .
                            $status .
                            ", " .
                            $user_id .
                            ", " .
                            $percentage .
                            ", 0, 0, " .
                            $user_id .
                            ")"
                    );

                    if ($insert) {
                        $update = $this->conn->query(
                            "UPDATE customer_list SET is_affiliate = " .
                                $status .
                                ' WHERE id = \'' .
                                $user_id .
                                '\''
                        );
                        $resp["status"] = "success";
                        $resp["msg"] = "Afiliado cadastrado com sucesso";
                    } else {
                        $resp["status"] = "failed";
                        $resp["msg"] = "Erro ao criar afiliado";
                    }
                } else {
                    $resp["status"] = "failed";
                    $resp["msg"] = "Usuário não encontrado";
                }
            }
        }

        return json_encode($resp);
    }

    public function delete_affiliate()
    {
        global $_settings;
        $this->settings = $_settings;

        extract($_POST);
        $customer = $this->conn->query(
            'SELECT customer_id FROM referral WHERE id = \'' . $id . '\''
        );

        if (0 < $customer->num_rows) {
            $row = $customer->fetch_assoc();
            $customer_id = $row["customer_id"];
            $update = $this->conn->query(
                'UPDATE customer_list SET is_affiliate = 0 WHERE id = \'' .
                    $customer_id .
                    '\''
            );
        }

        $delete = $this->conn->query(
            'DELETE FROM referral WHERE id = \'' . $id . '\''
        );
        $deleteTransations = $this->conn->query(
            'DELETE FROM referral_transactions WHERE referral_id = \'' .
                $id .
                '\''
        );
        if ($delete && $deleteTransations) {
            $resp["status"] = "success";
            $resp["msg"] = "Afiliado excluído com sucesso";
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = "Erro ao excluir afiliado";
        }

        return json_encode($resp);
    }

    public function deactive_license()
    {
        $license = $this->settings->info("license");

        if (!empty($license)) {
            $update = $this->conn->query(
                'UPDATE system_info SET meta_value = \'\' WHERE meta_field = \'license\''
            );
            $firstname = $this->settings->userdata("firstname");
            $insert = $this->conn->query(
                'INSERT INTO `logs` (`origin`, `description`) VALUES (\'LICENSE\', \'Licença desativada pelo usuário ' .
                    $firstname .
                    '\')'
            );

            if ($update) {
                $url =
                    "https://license.dropestore.com/wp-json/licensor/license/remove_domain";
                $domain = BASE_URL . "admin/";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt(
                    $curl,
                    CURLOPT_POSTFIELDS,
                    "api_key=225A632C-7B598C64-74403549-BDF93958&license_code=" .
                        $license .
                        "&domain=" .
                        $domain
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/x-www-form-urlencoded",
                ]);
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
                $resp["status"] = "success";
                $resp["msg"] = "Licença removida.";
            }
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = "Nenhuma licença encontrada.";
        }

        return json_encode($resp);
    }

    public function place_order_process()
    {
        $lockFile = $_SERVER["DOCUMENT_ROOT"] . "/pedido.lock";
        $lock = fopen($lockFile, "w");

        if (flock($lock, LOCK_EX)) {
            $customer_id = $this->settings->userdata("id");
            $customer_fname = $this->settings->userdata("firstname");
            $customer_lname = $this->settings->userdata("lastname");
            $customer_phone = $this->settings->userdata("phone");
            $customer_email = $this->settings->userdata("email");
            $customer_cpf = $this->settings->userdata("cpf");
            $customer_name = $customer_fname . " " . $customer_lname;
            $dateCreated = date("Y-m-d H:i:s");
            $product_id = $_POST["product_id"];
            $numbers = isset($_POST["numbers"]) ? $_POST["numbers"] : "";
            $pref = date("Ymdhis.u");
            $code = uniqidReal();
            $ref = $_POST["ref"];
            $order_token = md5($pref . $code);

            if ($this->settings->info("pay2m") == 1) {
                if (empty($customer_cpf)) {
                    $resp["status"] = "pay2m";
                    $resp["error"] =
                        "Seu cadastro precisa ser atualizado, por favor, adicione um CPF válido.";
                    $resp["redirect"] = BASE_URL . "user/atualizar-cadastro";
                    flock($lock, LOCK_UN);
                    fclose($lock);
                    return json_encode($resp);
                    exit();
                }
            }

            $multiple = $this->settings->info("enable_multiple_order");

            if ($multiple == 1) {
                $multiple_order = $this->conn->prepare(
                    "SELECT id FROM `order_list` WHERE status = 1 AND customer_id = ?"
                );
                $multiple_order->bind_param("i", $customer_id);
                $multiple_order->execute();
                $customer_order = $multiple_order->get_result();

                if (0 < $customer_order->num_rows) {
                    $resp["status"] = "failed";
                    $resp["error"] =
                        "Faça o pagamento do pedido anterior para criar um novo pedido.";
                    flock($lock, LOCK_UN);
                    fclose($lock);
                    return json_encode($resp);
                    exit();
                }
            }

            $cart_total = $this->conn->query(
                    'SELECT SUM(c.quantity * p.price) FROM `cart_list` c inner join product_list p on c.product_id = p.id where customer_id = \'' .
                        $customer_id .
                        '\' '
                )
                ->fetch_array()[0];
            $stmt_plist = $this->conn->prepare(
                "SELECT name, qty_numbers, limit_order_remove, type_of_draw FROM `product_list` WHERE id = ?"
            );
            $stmt_plist->bind_param("i", $product_id);
            $stmt_plist->execute();
            $product_list = $stmt_plist->get_result();

            if (0 < $product_list->num_rows) {
                $product = $product_list->fetch_assoc();
                $product_name = $product["name"];
                $qty_numbers = $product["qty_numbers"];
                $type_of_draw = $product["type_of_draw"];
                $order_expiration = $product["limit_order_remove"];
            }

            $quantity = $this->conn
                ->query(
                    'SELECT SUM(c.quantity) FROM `cart_list` c inner join product_list p on c.product_id = p.id where customer_id = \'' .
                        $customer_id .
                        '\' '
                )
                ->fetch_array()[0];

            if (!$quantity) {
                $resp["status"] = "failed";
                $resp["error"] = "Erro ao criar pedido.";
                flock($lock, LOCK_UN);
                fclose($lock);
                return json_encode($resp);
                exit();
            }

            $limitOrder = 0;
            $customerOrders = 0;
            $limitOrdersQuery = $this->conn->query(
                'SELECT limit_orders FROM product_list WHERE id = \'' .
                    $product_id .
                    '\''
            );
            if ($limitOrdersQuery && 0 < $limitOrdersQuery->num_rows) {
                $limitOrder = $limitOrdersQuery->fetch_assoc();
                $limitOrder = $limitOrder["limit_orders"];
            }

            $customerOrdersQuery = $this->conn->query(
                'SELECT id FROM order_list WHERE customer_id = \'' .
                    $customer_id .
                    '\' AND product_id = \'' .
                    $product_id .
                    '\''
            );
            if ($customerOrdersQuery && 0 < $customerOrdersQuery->num_rows) {
                $customerOrders = $customerOrdersQuery->num_rows;
            }

            if ($limitOrder != 0) {
                if ($limitOrder <= $customerOrders) {
                    $resp["status"] = "failed";
                    $resp["error"] =
                        "Você atingiu o limite de pedido(s) para essa campanha.";
                    flock($lock, LOCK_UN);
                    fclose($lock);
                    return json_encode($resp);
                    exit();
                }
            }

            $query =
                'SELECT discount_qty, enable_discount, discount_amount, enable_cumulative_discount, enable_sale, sale_qty, sale_price, status, qty_numbers, pending_numbers, paid_numbers, date_of_draw FROM product_list WHERE id = \'' .
                $product_id .
                '\'';
            $result = $this->conn->query($query);
            if ($result && 0 < $result->num_rows) {
                $row = $result->fetch_assoc();
                $pending_numbers = $row["pending_numbers"];
                $discount_qty = $row["discount_qty"];
                $enable_discount = $row["enable_discount"];
                $enable_cumulative_discount =
                    $row["enable_cumulative_discount"];
                $discount_amount = $row["discount_amount"];
                $enable_sale = $row["enable_sale"];
                $sale_qty = $row["sale_qty"];
                $sale_price = $row["sale_price"];
                $status = $row["status"];
                $paid_n = $row["paid_numbers"];
                $pending_n = $row["pending_numbers"];
                $date_of_draw = $row["date_of_draw"];
            }

            $totalSales = $paid_n + $pending_n;

            if (1 < $status) {
                $resp["status"] = "failed";
                $resp["error"] = "Campanha pausada ou finalizada.";
                return json_encode($resp);
                exit();
            }

            if ($qty_numbers <= $totalSales) {
                $this->conn->query(
                    'UPDATE product_list SET status = \'2\', status_display = \'6\' WHERE id = \'' .
                        $product_id .
                        '\''
                );
                $resp["status"] = "failed";
                $resp["error"] = "Camnpanha pausada ou finalizada.";
                flock($lock, LOCK_UN);
                fclose($lock);
                return json_encode($resp);
                exit();
            }

            if ($date_of_draw) {
                $expirationTime = date("Y-m-d H:i:s", strtotime($date_of_draw));
                $currentDateTime = date("Y-m-d H:i:s");

                if ($expirationTime < $currentDateTime) {
                    $resp["status"] = "failed";
                    $resp["error"] =
                        "Compra não permitida. A campanha foi pausada ou finalizada.";
                    flock($lock, LOCK_UN);
                    fclose($lock);
                    return json_encode($resp);
                    exit();
                }
            }

            $total_pending_numbers = $pending_n + $quantity;
            $total_paid_numbers = $paid_n + $quantity;
            $total_amount = 0 < $cart_total ? $cart_total : 0;
            $pay_status = 1;

            if ($total_amount == 0) {
                $pay_status = 2;
                $this->conn->query(
                    'UPDATE product_list SET paid_numbers = \'' .
                        $total_paid_numbers .
                        '\' WHERE id = \'' .
                        $product_id .
                        '\''
                );
            } else {
                $this->conn->query(
                    'UPDATE product_list SET pending_numbers = \'' .
                        $total_pending_numbers .
                        '\' WHERE id = \'' .
                        $product_id .
                        '\''
                );
            }

            $order_discount_amount = "";
            if ($enable_discount && $discount_amount) {
                $discount_qty = json_decode($discount_qty, true);
                $discount_amount = json_decode($discount_amount, true);
                $discounts = [];

                foreach ($discount_qty as $qty_index => $qty) {
                    foreach ($discount_amount as $amount_index => $amount) {
                        if ($qty_index === $amount_index) {
                            $discounts[$qty_index] = [
                                "qty" => $qty,
                                "amount" => $amount,
                            ];
                        }
                    }
                }

                if ($enable_cumulative_discount == 1) {
                    $accumulative_discount = 0;
                    $remaining_quantity = $quantity;
                    usort($discounts, function ($a, $b) {
                        return $b["qty"] - $a["qty"];
                    });

                    foreach ($discounts as $discount) {
                        if ($discount["qty"] <= $remaining_quantity) {
                            $multiples = floor(
                                $remaining_quantity / $discount["qty"]
                            );
                            $discount_amount = $multiples * $discount["amount"];
                            $accumulative_discount += $discount_amount;
                            $remaining_quantity -=
                                $multiples * $discount["qty"];
                        }
                    }

                    if (0 < $accumulative_discount) {
                        $total_amount -= $accumulative_discount;
                        $order_discount_amount = $accumulative_discount;
                    }
                } else {
                    usort($discounts, function ($a, $b) {
                        return $b["qty"] - $a["qty"];
                    });

                    foreach ($discounts as $discount) {
                        if ($discount["qty"] <= $quantity) {
                            $total_amount -= $discount["amount"];
                            $order_discount_amount = $discount["amount"];
                            break;
                        }
                    }
                }
            }

            if (
                $enable_sale == 1 &&
                $enable_discount == 0 &&
                $sale_qty <= $quantity
            ) {
                $order_discount_amount =
                    $total_amount - $quantity * $sale_price;
                $total_amount = $quantity * $sale_price;
            }


            $order_numbers = "";
            $insert = $this->conn->query(
                'INSERT INTO `order_list` (`code`, `customer_id`, `product_name`, `quantity`, `status`, `total_amount`, `order_token`, `order_numbers`, `product_id`, `order_expiration`, `discount_amount`, `date_created`) VALUES (\'' .
                    $code .
                    '\', \'' .
                    $customer_id .
                    '\', \'' .
                    $product_name .
                    '\', \'' .
                    $quantity .
                    '\', \'' .
                    $pay_status .
                    '\', \'' .
                    $total_amount .
                    '\', \'' .
                    $order_token .
                    '\', \'' .
                    $order_numbers .
                    '\', \'' .
                    $product_id .
                    '\', \'' .
                    $order_expiration .
                    '\', \'' .
                    $order_discount_amount .
                    '\', \'' .
                    $dateCreated .
                    '\') '
            );

            if ($insert) {
                $oid = $this->conn->insert_id;
                $data = "";
                $sql_cart =
                    "SELECT c.*," .
                    "\r\n\t\t\t\t" .
                    "p.name AS product," .
                    "\r\n\t\t\t\t" .
                    "p.price," .
                    "\r\n\t\t\t\t" .
                    "p.image_path" .
                    "\r\n\t\t\t\t" .
                    "FROM `cart_list` c" .
                    "\r\n\t\t\t\t" .
                    "INNER JOIN product_list p ON c.product_id = p.id" .
                    "\r\n\t\t\t\t" .
                    'WHERE customer_id = \'' .
                    $customer_id .
                    '\'';
                $cart = $this->conn->query($sql_cart);
                $qty_numbers = $qty_numbers - 1;
                $total_numbers_generated = $quantity;
                $use_manual_numbers = false;

                if (1 < $type_of_draw) {
                    $use_manual_numbers = true;
                }

                if ($use_manual_numbers) {
                    $orders = $this->conn->query(
                        'SELECT order_numbers FROM order_list WHERE product_id = \'' .
                            $product_id .
                            '\' AND status <> 3'
                    );
                    $cotas_vendidas = [];
                    $all_lucky_numbers = [];

                    while ($row = $orders->fetch_assoc()) {
                        $cotas_vendidas[] = $row["order_numbers"];
                    }

                    $all_lucky_numbers = implode(",", $cotas_vendidas);
                    $all_lucky_numbers = explode(",", $all_lucky_numbers);
                    $cotas_vendidas = array_filter($cotas_vendidas);
                    $arrValues = array_filter(
                        explode(",", implode(",", $cotas_vendidas))
                    );
                    $result = $this->is_in_array($numbers, $arrValues);

                    if ($result) {
                        $resultNumber = implode(",", $result);
                        $resp["status"] = "failed";
                        $resp["error"] =
                            1 < count($result)
                            ? "Os números " .
                            $resultNumber .
                            " acabaram de ser reservados por outra pessoa. Por favor, escolha outros números"
                            : "O número " .
                            $resultNumber .
                            " acabou de ser reservado por outra pessoa. Por favor, escolha outro número";
                        $this->conn->query(
                            'DELETE FROM `order_list` where code = \'' .
                                $code .
                                '\''
                        );
                        $this->conn->query(
                            'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` - \'' .
                                $total_numbers_generated .
                                '\' WHERE `id` = \'' .
                                $product_id .
                                '\''
                        );
                        return json_encode($resp);
                    }

                    $order_numbers = implode(",", $numbers) . ",";
                    $update = $this->conn->query(
                        'UPDATE `order_list` SET `order_numbers` = \'' .
                            $order_numbers .
                            '\' WHERE `code` = \'' .
                            $code .
                            '\''
                    );
                } else {
                    $orders = $this->conn->query(
                        "SELECT order_numbers , product_list.cotas_premiadas, product_list.status_auto_cota FROM order_list INNER JOIN product_list ON product_list.id = order_list.product_id WHERE order_list.product_id = '" .
                            $product_id .
                            "' AND order_list.status <> 3"
                    );
                    $cotas_vendidas = [];
                    $cotas_premiadas = "";
                    $all_lucky_numbers = [];

                    $status_cota_check = $this->conn
                        ->query(
                            "SELECT paid_numbers, status_auto_cota, valor_base_auto , qty_numbers FROM product_list WHERE id = '" .
                                $product_id .
                                "'"
                        )
                        ->fetch_assoc();
                    $total_numbers = $status_cota_check["qty_numbers"];
                    $total_paid_numbers = $status_cota_check["paid_numbers"];
                    $status_auto_cota = $status_cota_check["status_auto_cota"];
                    $valor_base_auto = $status_cota_check["valor_base_auto"];
                    $min_paid_numbers =
                        ($valor_base_auto / 100) * $total_numbers;
                    if (
                        $status_auto_cota == 1 &&
                        $total_paid_numbers >= $min_paid_numbers
                    ) {
                        $this->conn->query(
                            "UPDATE `product_list` SET `status_auto_cota` = 0 WHERE `id` = '" .
                                $product_id .
                                "'"
                        );
                    }

                    $row = []; // Inicializando $row

                    while ($row = $orders->fetch_assoc()) {
                        $cotas_vendidas[] = $row["order_numbers"];
                        if (
                            empty($cotas_premiadas) &&
                            !empty($row["cotas_premiadas"]) &&
                            $status_auto_cota == 1 &&
                            $total_paid_numbers < $min_paid_numbers
                        ) {
                            $cotas_premiadas = $row["cotas_premiadas"];
                        }
                    }

                    if (!empty($cotas_premiadas)) {
                        $cotas_vendidas[] = $cotas_premiadas;
                    }
  
                    echo $cotas_premiadas;
                    

                    $all_lucky_numbers = implode(",", $cotas_vendidas);
                    $all_lucky_numbers = explode(",", $all_lucky_numbers);
                    $numeros_ja_vendidos = array_filter($all_lucky_numbers);
 
                    if (
                        $qty_numbers <
                        $total_numbers_generated +
                        count($numeros_ja_vendidos) -
                        1
                    ) {  
                        $resp["status"] = "failed";
                        $resp["error"] =
                            "[DP01] - Erro ao criar pedido, selecione uma quantidade menor.";
                        $this->conn->query(
                            'DELETE FROM `order_list` where code = \'' .
                                $code .
                                '\''
                        );
                        $this->conn->query(
                            'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` - \'' .
                                $total_numbers_generated .
                                '\' WHERE `id` = \'' .
                                $product_id .
                                '\''
                        );
                        flock($lock, LOCK_UN);
                        fclose($lock);
                        
                    }

                    $numeros_ja_vendidos = array_map('intval', $numeros_ja_vendidos); // Garantir que $numeros_ja_vendidos contenha inteiros
                    $sold_numbers_set = array_flip($numeros_ja_vendidos); // Transformar em um conjunto para busca rápida
                    $numeris = [];
                    $globos = strlen((string)$qty_numbers);
                    while (count($numeris) < $total_numbers_generated) {
                        // Gerar um número aleatório entre 0 e $qty_numbers - 1
                        $random_number = mt_rand(0, $qty_numbers );
                    
                        // Verificar se o número já foi vendido
                        if (!isset($sold_numbers_set[$random_number])) {
                            // Adicionar o número preenchido ao array se não foi vendido
                            $padded_number = str_pad(
                                $random_number,
                                $globos,
                                "0",
                                STR_PAD_LEFT
                            );
                            $numeris[] = $padded_number;
                    
                            // Adicionar o número ao conjunto de vendidos para evitar duplicações
                            $sold_numbers_set[$random_number] = true;
                        }
                    }
                    
                    // Embaralhar o array de números
                    shuffle($numeris);
                    
                    // Juntar o array em uma string separada por vírgulas
                    $order_numbers = implode(",", $numeris);
                    $update = $this->conn->query(
                        'UPDATE `order_list` SET `order_numbers` = \'' .
                            $order_numbers .
                            '\' WHERE `code` = \'' .
                            $code .
                            '\''
                    );
                }

                if (
                    $this->settings->info("mercadopago") == 1 &&
                    $total_amount > 0
                ) { 
                    mercadopago_generate_pix(
                        $oid,
                        $total_amount,
                        $customer_name,
                        $customer_email,
                        $order_expiration
                    );
                }
                if (
                    $this->settings->info("gerencianet") == 1 &&
                    0 < $total_amount
                ) {
                    gerencianet_generate_pix(
                        $oid,
                        $total_amount,
                        $customer_name,
                        $customer_email,
                        $order_expiration
                    );
                }
                if ($this->settings->info("paggue") == 1 && $total_amount > 0) {

                    paggue_generate_pix(
                        $oid,
                        $total_amount,
                        $customer_name,
                        $customer_email,
                        $order_expiration,

                    );
                }
                if (
                    $this->settings->info("openpix") == 1 &&
                    0 < $total_amount
                ) {
                    openpix_generate_pix(
                        $oid,
                        $total_amount,
                        $customer_name,
                        $customer_email,
                        $order_expiration,
                        $customer_phone
                    );
                }
                if ($this->settings->info("pay2m") == 1 && 0 < $total_amount) {
                    pay2m_generate_pix(
                        $oid,
                        $total_amount,
                        $customer_name,
                        $customer_cpf,
                        $order_expiration
                    );
                }

                if (!empty($ref)) {
                    $referral = $this->conn->query(
                        'SELECT status FROM referral WHERE referral_code = \'' .
                            $ref .
                            '\''
                    );
              
                 
                    if (0 < $referral->num_rows) {
                        $row = $referral->fetch_assoc();
                        $status_affiliate = $row["status"];


                        if ($status_affiliate == 1) {
                            $update = $this->conn->query(
                                "UPDATE order_list SET referral_id = " .
                                    $ref .
                                    " WHERE id = " .
                                    $oid
                            );
                        }
                    }
                }

                if ($this->settings->info("enable_dwapi") == 1) {
                    $queryPhone = $this->conn->query(
                        'SELECT phone FROM customer_list WHERE id = \'' .
                            $customer_id .
                            '\''
                    );
                    if ($queryPhone && 0 < $queryPhone->num_rows) {
                        $customerRow = $queryPhone->fetch_assoc();
                        $customerPhone = $customerRow["phone"];
                        $message = $this->settings->info(
                            "mensagem_novo_pedido_dwapi"
                        );
                        $queryPIX = $this->conn->query(
                            'SELECT pix_code FROM order_list WHERE id = \'' .
                                $oid .
                                '\''
                        );
                        if ($queryPIX && 0 < $queryPIX->num_rows) {
                            $pixRow = $queryPIX->fetch_assoc();
                            $pix_code = $pixRow["pix_code"];
                            $this->send_order_whatsapp(
                                $customerPhone,
                                $customer_name,
                                $product_name,
                                $order_numbers,
                                $total_amount,
                                $message,
                                $pix_code
                            );
                        }
                    }
                }

                while ($row = $cart->fetch_assoc()) {
                    if (!empty($data)) {
                        $data .= ", ";
                    }


                    $data .=
                        '(\'' .
                        $oid .
                        '\', \'' .
                        $row["product_id"] .
                        '\', \'' .
                        $row["quantity"] .
                        '\', \'' .
                        $row["price"] .
                        '\')';
                }

                if (!empty($data)) {
                    $sql =
                        "INSERT INTO order_items (`order_id`, `product_id`, `quantity`, `price`) VALUES " .
                        $data;
                    $save = $this->conn->query($sql);

                    if ($save) {
                        $resp["status"] = "success";
                        $this->conn->query(
                            'DELETE FROM `cart_list` where customer_id = \'' .
                                $customer_id .
                                '\''
                        );
                    } else {
                        $resp["status"] = "failed";
                        $resp["error"] = $this->conn->error;
                        $this->conn->query(
                            'DELETE FROM `order_list` where id = \'' .
                                $oid .
                                '\''
                        );
                    }
                } else {
                    $resp["status"] = "success";
                }
            } else {
                $resp["status"] = "failed";
                $resp["error"] = $this->conn->error;
            }

            if ($resp["status"] == "success") {
                $resp["redirect"] = "/compra/" . $order_token . "";
                $resp["msg"] = "Pedido criado com sucesso!" .  round(memory_get_usage() / (1024 * 1024), 2) . " MB";
                ;
            }

            if ($this->settings->info("enable_pixel") == 1) {
                $dados = [
                    "first_name" => $customer_fname,
                    "last_name" => $customer_lname,
                    "phone" => "55" . $customer_phone,
                    "id" => $oid,
                    "total_amount" => $total_amount,
                ];
                send_event_pixel("InitiateCheckout", $dados);
            }

            $this->correct_stock($product_id);

            if ($status == 1) {
                $query = $this->conn->query(
                    'SELECT SUM(quantity) as quantity FROM order_list WHERE product_id = \'' .
                        $product_id .
                        '\' AND status <> 3'
                );
                if ($query && 0 < $query->num_rows) {
                    $row = $query->fetch_assoc();
                    $quantidade = $row["quantity"];

                    if ($qty_numbers + 1 <= $quantidade) {
                        $this->conn->query(
                            'UPDATE product_list SET status = \'3\', status_display = \'6\' WHERE id = \'' .
                                $product_id .
                                '\''
                        );
                    }
                }
            }

            order_email(
                $this->settings->info("email_order"),
                "[" .
                    $this->settings->info("name") .
                    "] - Confirmação de pedido",
                $oid
            );
            flock($lock, LOCK_UN);
            fclose($lock);
        }

        return json_encode($resp);
    }

    public function gerarNumeroRifa($numerosVendidos, $qtd_pedido, $qty_numbers)
    {
        $numerosGerados = [];

        while (count($numerosGerados) < $qtd_pedido) {
            $numero = "";

            do {
                $numero = str_pad(
                    mt_rand(0, $qty_numbers),
                    strlen($qty_numbers),
                    "0",
                    STR_PAD_LEFT
                );
            } while (
                in_array($numero, $numerosVendidos) ||
                in_array($numero, $numerosGerados)
            );

            $numerosGerados[] = $numero;
        }

        return $numerosGerados;
    }

    public function is_in_array($values, $array)
    {
        $numbers = false;

        foreach ((array) $values as $value) {
            if (in_array($value, $array)) {
                $numbers[] = $value;
            }
        }

        return $numbers;
    }

    public function correct_stock($id)
    {
        if (empty($id)) {
            $id = $_GET["id"];
        }

        $sql_pending = $this->conn->query(
            'SELECT p.pending_numbers, SUM(o.quantity) as quantity FROM product_list as p LEFT JOIN order_list as o ON p.id = o.product_id WHERE p.id = \'' .
                $id .
                '\' AND o.status = \'1\''
        );
        if ($sql_pending && 0 < $sql_pending->num_rows) {
            while ($row = $sql_pending->fetch_assoc()) {
                $pl_pending = $row["pending_numbers"];
                $ol_pending = $row["quantity"];
                if (empty($ol_pending) || $ol_pending == null) {
                    $ol_pending = 0;
                }

                if ($pl_pending != $ol_pending) {
                    $update = $this->conn->query(
                        'UPDATE product_list SET pending_numbers = \'' .
                            $ol_pending .
                            '\' WHERE id = \'' .
                            $id .
                            '\''
                    );

                    if ($update) {
                        $resp["status"] = "success";
                        continue;
                    }

                    $resp["status"] = "failed";
                    $resp["msg"] = $this->conn->error;
                }
            }
        }

        $sql_paid = $this->conn->query(
            'SELECT p.paid_numbers, SUM(o.quantity) as quantity FROM product_list as p LEFT JOIN order_list as o ON p.id = o.product_id WHERE p.id = \'' .
                $id .
                '\' AND o.status = \'2\''
        );
        if ($sql_paid && 0 < $sql_paid->num_rows) {
            $resp = [];
            while ($row = $sql_paid->fetch_assoc()) {
                $pl_paid = $row["paid_numbers"];
                $ol_paid = $row["quantity"];
                if (empty($ol_paid) || $ol_paid == null) {
                    $ol_paid = 0;
                }

                if ($pl_paid != $ol_paid) {
                    $update = $this->conn->query(
                        'UPDATE product_list SET paid_numbers = \'' .
                            $ol_paid .
                            '\' WHERE id = \'' .
                            $id .
                            '\''
                    );

                    if ($update) {
                        $resp["status"] = "success";
                        continue;
                    }

                    $resp["status"] = "failed";
                    $resp["msg"] = $this->conn->error;
                }
            }
        }

        return json_encode($resp);
    }

    public function send_order_whatsapp(
        $phone,
        $name,
        $pname,
        $cotas,
        $total,
        $message,
        $pix
    ) {
        global $_settings;
        $this->settings = $_settings;

        $token_dwapi = $this->settings->info("token_dwapi");
        $numero_dwapi = $this->settings->info("numero_dwapi");
        $cotas = rtrim($cotas, ",");
        $pix = $pix != "" ? $pix : "";

        if (!empty($message)) {
            $message = str_replace("[N]", '\\n', $message);
            $message = str_replace("[CAMPANHA]", $pname, $message);
            $message = str_replace("[CLIENTE]", $name, $message);
            $message = str_replace("[COTAS]", $cotas, $message);
            $message = str_replace("[TOTAL]", $total, $message);
            $message = str_replace("[PIX]", $pix, $message);
            $dwapi = [
                "receiver" => "55" . $phone,
                "msgtext" => $message,
                "sender" => $numero_dwapi,
                "token" => $token_dwapi,
            ];
            $curl_dwapi = curl_init();
            curl_setopt_array($curl_dwapi, [
                CURLOPT_URL => "https://api.dw-api.com/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                CURLOPT_TCP_FASTOPEN => 1,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => stripslashes(
                    json_encode($dwapi, JSON_UNESCAPED_UNICODE)
                ),
                CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            ]);
            $retorno = curl_exec($curl_dwapi);
            curl_close($curl_dwapi);
        }
    }

    public function update_order_status()
    {  global $_settings;
        $this->settings = $_settings;
      

        extract($_POST);
        $qry = $this->conn->query(
            "SELECT o.status, o.product_id, o.quantity, p.qty_numbers, p.type_of_draw, o.code, o.referral_id, o.total_amount" .
                "\r\n\t\t\t\t\t\t\t\t\t" .
                "FROM order_list o" .
                "\r\n\t\t\t\t\t\t\t\t\t" .
                "INNER JOIN product_list p ON o.product_id = p.id" .
                "\r\n\t\t\t\t\t\t\t\t\t" .
                'WHERE o.id = \'' .
                $id .
                '\''
        );

        if (0 < $qry->num_rows) {
            $row = $qry->fetch_assoc();
            $status_order = $row["status"];
            $product_id = $row["product_id"];
            $quantity = $row["quantity"];
            $qty_numbers = $row["qty_numbers"];
            $code = $row["code"];
            $ref = $row["referral_id"];
            $total_amount = $row["total_amount"];
        }

        $product_list = $this->conn->query(
            "\r\n\t\t\t" .
                "SELECT pending_numbers, paid_numbers" .
                "\r\n\t\t\t" .
                "FROM product_list" .
                "\r\n\t\t\t" .
                'WHERE id = \'' .
                $product_id .
                '\'' .
                "\r\n\t\t\t"
        );

        if (0 < $product_list->num_rows) {
            $row = $product_list->fetch_assoc();
            $pendingNumbers = $row["pending_numbers"];
            $updatePending = $pendingNumbers - $quantity;
            $paidNumbers = $row["paid_numbers"];
            $updatePaid = $paidNumbers + $quantity;
        }

        date_default_timezone_set("America/Sao_Paulo");
        $payment_date = date("Y-m-d H:i:s");

        if ($status_order == 3) {
            if ($qty_numbers < $pendingNumbers + $paidNumbers + $quantity) {
                $resp["failed"] = "failed";
                $resp["msg"] =
                    "Não é possível aprovar este pedido pois ultrapassa a quantidade disponível.";
                return json_encode($resp);
            }

            $orders = $this->conn->query(
                'SELECT order_numbers FROM order_list WHERE product_id = \'' .
                    $product_id .
                    '\' AND status <> 3'
            );
            $cotas_vendidas = [];
            $all_lucky_numbers = [];

            while ($row = $orders->fetch_assoc()) {
                $cotas_vendidas[] = $row["order_numbers"];
            }

            $all_lucky_numbers = implode(",", $cotas_vendidas);
            $all_lucky_numbers = explode(",", $all_lucky_numbers);
            $numeros_ja_vendidos = array_filter($all_lucky_numbers);
            $qty_numbers = $qty_numbers - 1;

            if ($qty_numbers < $quantity + count($numeros_ja_vendidos) - 1) {
                $resp["status"] = "failed";
                $resp["error"] =
                    "[DP01] - Erro ao criar pedido, selecione uma quantidade menor.";
                $this->conn->query(
                    'DELETE FROM `order_list` where code = \'' . $code . '\''
                );
                $this->conn->query(
                    'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` - \'' .
                        $quantity .
                        '\' WHERE `id` = \'' .
                        $product_id .
                        '\''
                );
                return json_encode($resp);
            }
            $globos = strlen($qty_numbers);
            $numeris = range(0, $qty_numbers);
            $numeris = array_map(function ($item) use ($qty_numbers, $globos) {
                return str_pad(
                    $item,
                    max((int) $globos, strlen($qty_numbers)),
                    "0",
                    STR_PAD_LEFT
                );
            }, $numeris);
            $array_without_ja_vendidos = array_filter(
                array_diff($numeris, $numeros_ja_vendidos)
            );
            shuffle($array_without_ja_vendidos);
            $order_numbers = array_slice(
                $array_without_ja_vendidos,
                0,
                $quantity
            );
            $order_numbers = implode(",", $order_numbers) . ",";
            $update = $this->conn->query(
                'UPDATE `order_list` set `status` = \'' .
                    $status .
                    '\', `order_numbers` = \'' .
                    $order_numbers .
                    '\', `payment_method` = \'Manual\', `whatsapp_status` = \'\', `date_updated` = \'' .
                    $payment_date .
                    '\' where id = \'' .
                    $id .
                    '\''
            );
        } else {
            $update = $this->conn->query(
                'UPDATE `order_list` set `status` = \'' .
                    $status .
                    '\', `payment_method` = \'Manual\', `whatsapp_status` = \'\', `date_updated` = \'' .
                    $payment_date .
                    '\' where id = \'' .
                    $id .
                    '\''
            );
        }

        if ($update) {
            if ($ref) {
                $referral = $this->conn->query(
                    'SELECT * FROM referral WHERE referral_code = \'' .
                        $ref .
                        '\''
                );

                if (0 < $referral->num_rows) {
                    $row = $referral->fetch_assoc();
                    $status_affiliate = $row["status"];
                    $percentage_affiliate = $row["percentage"];
                    $amount_paid_affiliate = $row["amount_paid"];
                    $amount_pending_affiliate = $row["amount_pending"];
                }
            }

            $user_name = $this->settings->userdata("firstname");
            $insert = $this->conn->query(
                'INSERT INTO `logs` (`origin`, `description`) VALUES (\'ORDER\', \'Pedido ' .
                    $id .
                    " aprovado manualmente pelo usuário " .
                    $user_name .
                    '\')'
            );
            if ($status_order == 1 && $status == "2") {
                $sql_pl =
                    'UPDATE product_list SET pending_numbers = \'' .
                    $updatePending .
                    '\', paid_numbers = \'' .
                    $updatePaid .
                    '\' WHERE id = \'' .
                    $product_id .
                    '\'';
                $this->conn->query($sql_pl);

                if ($ref) {
                    if ($status_affiliate == 1) {
                        $value = $total_amount * $percentage_affiliate;
                        $value = $value / 100;
                        $aff_sql =
                            "UPDATE referral SET amount_pending = amount_pending + " .
                            $value .
                            " WHERE referral_code = " .
                            $ref;
                        $this->conn->query($aff_sql);
                    }
                }

                order_email(
                    $this->settings->info("email_purchase"),
                    "[" .
                        $this->settings->info("name") .
                        "] - Pagamento aprovado",
                    $id
                );
            }
            if ($status_order == 3 && $status == "2") {
                corrigir_duplicidade($id);
                $sql_pl =
                    'UPDATE product_list SET paid_numbers = \'' .
                    $updatePaid .
                    '\' WHERE id = \'' .
                    $product_id .
                    '\'';
                $this->conn->query($sql_pl);

                if ($ref) {
                    if ($status_affiliate == 1) {
                        $value = $total_amount * $percentage_affiliate;
                        $value = $value / 100;
                        $aff_sql =
                            "UPDATE referral SET amount_pending = amount_pending + " .
                            $value .
                            " WHERE referral_code = " .
                            $ref;
                        $this->conn->query($aff_sql);
                    }
                }

                order_email(
                    $this->settings->info("email_purchase"),
                    "[" .
                        $this->settings->info("name") .
                        "] - Pagamento aprovado",
                    $id
                );
            }
            if ($status_order == "2" && $status == "3") {
                $sql_pl =
                    'UPDATE product_list SET paid_numbers = paid_numbers - \'' .
                    $quantity .
                    '\' WHERE id = \'' .
                    $product_id .
                    '\'';
                $this->conn->query($sql_pl);

                if ($ref) {
                    if ($status_affiliate == 1) {
                        $value = $total_amount * $percentage_affiliate;
                        $value = $value / 100;
                        $aff_sql =
                            "UPDATE referral SET amount_pending = amount_pending - " .
                            $value .
                            " WHERE referral_code = " .
                            $ref;
                        $this->conn->query($aff_sql);
                    }
                }
            }
            if ($status_order == "2" && $status == "1") {
                $sql_pl =
                    'UPDATE product_list SET paid_numbers = paid_numbers - \'' .
                    $quantity .
                    '\' WHERE id = \'' .
                    $product_id .
                    '\'';
                $this->conn->query($sql_pl);

                if ($ref) {
                    if ($status_affiliate == 1) {
                        $value = $total_amount * $percentage_affiliate;
                        $value = $value / 100;
                        $aff_sql =
                            "UPDATE referral SET amount_pending = amount_pending - " .
                            $value .
                            " WHERE referral_code = " .
                            $ref;
                        $this->conn->query($aff_sql);
                    }
                }

                order_email(
                    $this->settings->info("email_order"),
                    "[" .
                        $this->settings->info("name") .
                        "] - Confirmação de pedido",
                    $id
                );
            }
            if ($status_order == "1" && $status == "3") {
                $sql_pl =
                    'UPDATE product_list SET pending_numbers = pending_numbers - \'' .
                    $quantity .
                    '\' WHERE id = \'' .
                    $product_id .
                    '\'';
                $this->conn->query($sql_pl);
            }

            $resp["status"] = "success";
        } else {
            $resp["failed"] = "failed";
            $resp["msg"] = $this->conn->error;
        }

        revert_product($product_id);
        $query = $this->conn->query(
            'SELECT SUM(quantity) as quantity FROM order_list WHERE product_id = \'' .
                $product_id .
                '\' AND status <> 3'
        );
        if ($query && 0 < $query->num_rows) {
            $row = $query->fetch_assoc();
            $quantidade = $row["quantity"];

            if ($qty_numbers <= $quantidade) {
                $this->conn->query(
                    'UPDATE product_list SET status = \'3\', status_display = \'6\' WHERE id = \'' .
                        $product_id .
                        '\''
                );
            }
        }

        return json_encode($resp);
    }

    public function update_whatsapp_status()
    {
        global $_settings;
        $this->settings = $_settings;

        extract($_POST);
        $status = 1;
        $update = $this->conn->query(
            'UPDATE `order_list` set `whatsapp_status` = \'' .
                $status .
                '\' where id = \'' .
                $id .
                '\''
        );

        if ($update) {
            $resp["status"] = "success";
        } else {
            $resp["failed"] = "failed";
            $resp["msg"] = $this->conn->error;
        }

        return json_encode($resp);
    }

    public function check_order()
    {  
        if (!$this->settings->userdata("firstname")) {
            $resp["status"] = "failed";
            $resp["msg"] = "Não autorizado.";
            return json_encode($resp);
        }

        extract($_POST);
        $qry = $this->conn->query(
            'SELECT * FROM order_list WHERE order_token = \'' .
                $order_token .
                '\''
        );
        $order_id = "";
        $customer_id = "";
        $dateCreated = "";
        $orderExpiration = "";

        if (0 < $qry->num_rows) {
            while ($row = $qry->fetch_assoc()) {
                $resp["status"] = $row["status"];
                $order_id = $row["id"];
                $customer_id = $row["customer_id"];
                $dateCreated = $row["date_created"];
                $orderExpiration = $row["order_expiration"];
                $product_id = $row["product_id"];
                $quantity = $row["quantity"];
                $payment_method = $row["payment_method"];
                $id_mp = $row["id_mp"];
                $expirationTime = date(
                    "Y-m-d H:i:s",
                    strtotime(
                        $dateCreated . " + " . $orderExpiration . " minutes"
                    )
                );
                $currentDateTime = date("Y-m-d H:i:s");
                if (
                    $expirationTime < $currentDateTime &&
                    0 < $orderExpiration &&
                    $row["status"] != "3"
                ) {
                    if ($payment_method == "MercadoPago") {
                        if (check_order_mp($order_id, $id_mp) == "failed") {
                            $query = $this->conn->query(
                                'UPDATE order_list SET status = 3 WHERE id = \'' .
                                    $order_id .
                                    '\''
                            );
                            $query2 = $this->conn->query(
                                'UPDATE product_list SET pending_numbers = pending_numbers - \'' .
                                    $quantity .
                                    '\' WHERE id = \'' .
                                    $product_id .
                                    '\''
                            );
                            revert_product($product_id);
                        }

                        continue;
                    }

                    $query = $this->conn->query(
                        'UPDATE order_list SET status = 3 WHERE id = \'' .
                            $order_id .
                            '\''
                    );
                    $query2 = $this->conn->query(
                        'UPDATE product_list SET pending_numbers = pending_numbers - \'' .
                            $quantity .
                            '\' WHERE id = \'' .
                            $product_id .
                            '\''
                    );
                    revert_product($product_id);
                }
            }
        }

        $enable_dwapi = $this->settings->info("enable_dwapi");

        if ($enable_dwapi == 1) {
            $query = $this->conn->query(
                'SELECT `status`, `dwapi_status` FROM order_list WHERE order_token = \'' .
                    $order_token .
                    '\''
            );
            if ($query && 0 < $query->num_rows) {
                $status = $query->fetch_assoc();
                $status_order = $status["status"];
                $dwapi_status = $status["dwapi_status"];
                if ($status_order == 2 && $dwapi_status != 1) {
                    $query2 = $this->conn->query(
                        "\r\n\t\t\t\t\t\t" .
                            "SELECT o.id, c.firstname, p.name, c.lastname, c.phone, o.pix_code, o.total_amount, o.order_numbers" .
                            "\r\n\t\t\t\t\t\t\t" .
                            "FROM order_list o" .
                            "\r\n\t\t\t\t\t\t\t" .
                            "LEFT JOIN customer_list c ON o.customer_id = c.id" .
                            "\r\n\t\t\t\t\t\t\t" .
                            "LEFT JOIN product_list p ON o.product_id = p.id" .
                            "\r\n\t\t\t\t\t\t" .
                            'WHERE o.customer_id = \'' .
                            $customer_id .
                            '\' ORDER BY o.id DESC LIMIT 1'
                    );
                    $result = $query2->fetch_assoc();
                    $name = $result["firstname"] . " " . $result["lastname"];
                    $pname = $result["name"];
                    $phone = $result["phone"];
                    $cotas = $result["order_numbers"];
                    $total = $result["total_amount"];
                    $pix = $result["pix_code"];

                    if (0 < $query2->num_rows) {
                        $message = $this->settings->info(
                            "mensagem_pedido_pago_dwapi"
                        );
                        $this->send_order_whatsapp(
                            $phone,
                            $name,
                            $pname,
                            $cotas,
                            $total,
                            $message,
                            $pix
                        );
                        $sql_pl =
                            'UPDATE order_list SET dwapi_status = 1 WHERE id = \'' .
                            $order_id .
                            '\'';
                        $this->conn->query($sql_pl);
                    }
                }
            }
        }

        return json_encode($resp);
    }

    public function check_payment_status()
    { 
        global $_settings;
        $this->settings = $_settings;
        if (!$this->settings->userdata("firstname")) {
            $resp["status"] = "failed";
            $resp["msg"] = "Não autorizado.";
            return json_encode($resp);
        }

        extract($_POST);
        $qry = $this->conn->query(
            'SELECT * FROM order_list WHERE order_token = \'' .
                $order_token .
                '\''
        );
        $order_id = "";
        $customer_id = "";

        if (0 < $qry->num_rows) {
            while ($row = $qry->fetch_assoc()) {
                $resp["status"] = $row["status"];
                $order_id = $row["id"];
                $payment_method = $row["payment_method"];
                $id_mp = $row["id_mp"];

                if ($payment_method == "MercadoPago") {
                    check_order_mp($order_id, $id_mp);
                }

                if ($payment_method == "Paggue") {
                    check_order_pg($order_id, $id_mp);
                }

                if ($payment_method == "OpenPix") {
                    check_order_op($order_id);
                }

                if ($payment_method == "Pay2m") {
                    check_order_pay2m($order_id, $id_mp);
                }
            }
        }

        return json_encode($resp);
    }

    public function export_raffle_contacts()
    {
        extract($_GET);
        $where = "";

        if ($raffle) {
            $where .= ' AND o.product_id = \'' . $raffle . '\'';
        }

        if ($status) {
            $where .= ' AND o.status = \'' . $status . '\'';
        }

        if (!empty($where)) {
            $where = " WHERE " . ltrim($where, " AND");
        }

        $qry = $this->conn->query(
            'SELECT o.*, CONCAT(c.firstname, \' \', c.lastname) as customer, p.type_of_draw, c.phone, c.cpf, o.id, o.order_numbers' .
                "\r\n\t\t\t" .
                "FROM `order_list` o" .
                "\r\n\t\t\t" .
                "INNER JOIN customer_list c ON o.customer_id = c.id" .
                "\r\n\t\t\t" .
                "INNER JOIN product_list p ON o.product_id = p.id" .
                "\r\n\t\t\t" .
                $where .
                "\r\n\t\t\t" .
                "ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC"
        );

        if (0 < $qry->num_rows) {
            header("Content-Type: text/csv");
            header(
                'Content-Disposition: attachment; filename="contatos-' .
                    base64_encode($raffle) .
                    '.csv"'
            );
            header("Pragma: no-cache");
            header("Expires: 0");
            $file = fopen("php://output", "w");
            fwrite($file, "﻿");

            while ($row = $qry->fetch_assoc()) {
                fputcsv(
                    $file,
                    [
                        $row["id"],
                        $row["customer"],
                        $row["phone"],
                        $row["cpf"],
                        $row["order_numbers"],
                    ],
                    ";",
                    " "
                );
            }

            fclose($file);
            exit();
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = $this->conn->error;
        }

        return json_encode($resp);
        
    }

    public function export_raffle_contacts2()
    {
    extract($_GET);
include app_path("Includes/simplexlsxgen/src/SimpleXLSXGen.php");
$where = "";

        if ($raffle) {
            $where .= ' AND o.product_id = \'' . $raffle . '\'';
        }

        

        if (!empty($where)) {
            $where = " WHERE " . ltrim($where, " AND");
        }

        $qry = $this->conn->query(
            'SELECT o.*, CONCAT(c.firstname, \' \', c.lastname) as customer, p.type_of_draw, c.phone, c.cpf, o.id, o.order_numbers' .
                "\r\n\t\t\t" .
                "FROM `order_list` o" .
                "\r\n\t\t\t" .
                "INNER JOIN customer_list c ON o.customer_id = c.id" .
                "\r\n\t\t\t" .
                "INNER JOIN product_list p ON o.product_id = p.id" .
                "\r\n\t\t\t" .
                $where .
                "\r\n\t\t\t" .
                "ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC"
        );
        $lista = [];
        $product = $this->conn
            ->query(
                'SELECT name FROM product_list WHERE id = \'' . $raffle . '\''
            )
            ->fetch_assoc();
        $lista[0] = [
            '<middle><center><style height="30" bgcolor="#800000" color="#FFFFFF">' .
                $product["name"] .
                "</style></center></middle>",
        ];

        if ($this->settings->info("enable_cpf") == 1) {
            $lista[1] = [
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">PEDIDO</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">NOME</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">TELEFONE</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">CPF</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">COTA</style></center></middle>',
            ];
        } else {
            $lista[1] = [
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">PEDIDO</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">NOME</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">TELEFONE</style></center></middle>',
                '<middle><center><style height="30" bgcolor="#000000" color="#FFFFFF">COTA</style></center></middle>',
            ];
        }
        if (0 < $qry->num_rows) {
            while ($row = $qry->fetch_assoc()) {
                $numbers = array_filter(
                    explode(",", $row["order_numbers"] ?? "")
                );

                if ($numbers) {
                    $y = 1;

                    foreach ($numbers as $number) {
                        $key_list = $row["id"] . "__" . $y;
                        $lista[$key_list]["id"] = $row["id"] ?? "";
                        $lista[$key_list]["nome"] = $row["customer"] ?? "";
                        $lista[$key_list]["phone"] =
                            "(" .
                            substr($row["phone"], 0, 2) .
                            ") " .
                            substr($row["phone"], 2, -4) .
                            " - " .
                            substr($row["phone"], -4) ??
                            "";

                        if ($this->settings->info("enable_cpf") == 1) {
                            $lista[$key_list]["cpf"] = $row["cpf"] ?? "";
                        }

                        $lista[$key_list]["cotas"] = $number;
                        ++$y;
                    }
                }
            }

            if ($this->settings->info("enable_cpf") == 1) {
                $xlsx = Shuchkin\SimpleXLSXGen::fromArray($lista)
                    ->setDefaultFont("Calibri")
                    ->setDefaultFontSize(10)
                    ->mergeCells("A1:E1");
            } else {
                $xlsx = Shuchkin\SimpleXLSXGen::fromArray($lista)
                    ->setDefaultFont("Calibri")
                    ->setDefaultFontSize(10)
                    ->mergeCells("A1:D1");
            }

            $xlsx->downloadAs("relatorio-pedidos.xlsx");
            exit();
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = $this->conn->error;
        }

        return json_encode($resp);
    }

    public function export_customers()
    {
        extract($_GET);
        $where = "";

        if ($name) {
            $where =
                'WHERE CONCAT(firstname, \' \', lastname) LIKE \'%' .
                $name .
                '%\'';
        }

        if ($phone) {
            $where = 'WHERE phone LIKE \'%' . $phone . '%\'';
        }

        if ($email) {
            $where = 'WHERE email LIKE \'%' . $email . '%\'';
        }

        $qry = $this->conn->query(
            'SELECT *, concat(firstname,\' \', lastname) as `name`' .
                "\r\n\t\t" .
                "from `customer_list`" .
                "\r\n\t\t" .
                $where .
                "\r\n\t\t" .
                "order by `name` asc"
        );

        if (0 < $qry->num_rows) {
            header("Content-Type: text/csv");
            header('Content-Disposition: attachment; filename="clientes.csv"');
            header("Pragma: no-cache");
            header("Expires: 0");
            $file = fopen("php://output", "w");
            fwrite($file, "﻿");

            while ($row = $qry->fetch_assoc()) {
                fputcsv(
                    $file,
                    [
                        $row["id"],
                        $row["name"],
                        $row["phone"],
                        $row["email"],
                        $row["cpf"],
                    ],
                    ";",
                    " "
                );
            }

            fclose($file);
            exit();
        } else {
            $resp["status"] = "failed";
            $resp["msg"] = $this->conn->error;
        }

        return json_encode($resp);
    }

    public function delete_order()
    {

        global $_settings;
        $this->settings = $_settings;
      

        extract($_POST);
        $qry = $this->conn->query(
            'SELECT status, product_id, quantity FROM order_list WHERE id = \'' .
                $id .
                '\''
        );

        if (0 < $qry->num_rows) {
            $row = $qry->fetch_assoc();
            $status_order = $row["status"];
            $product_id = $row["product_id"];
            $quantity = $row["quantity"];
        }

        $product_list = $this->conn->query(
            "\r\n\t\t\t" .
                "SELECT pending_numbers, paid_numbers" .
                "\r\n\t\t\t" .
                "FROM product_list" .
                "\r\n\t\t\t" .
                'WHERE id = \'' .
                $product_id .
                '\'' .
                "\r\n\t\t"
        );

        if (0 < $product_list->num_rows) {
            $row = $product_list->fetch_assoc();
            $pendingNumbers = $row["pending_numbers"];
            $updatePending = $pendingNumbers - $quantity;
            $paidNumbers = $row["paid_numbers"];
            $updatePaid = $paidNumbers - $quantity;
        }

        if ($status_order == "1") {
            $sql_pl =
                'UPDATE product_list SET pending_numbers = \'' .
                $updatePending .
                '\' WHERE id = \'' .
                $product_id .
                '\'';
            $this->conn->query($sql_pl);
        }

        if ($status_order == "2") {
            $sql_pl =
                'UPDATE product_list SET paid_numbers = \'' .
                $updatePaid .
                '\' WHERE id = \'' .
                $product_id .
                '\'';
            $this->conn->query($sql_pl);
        }

        $delete = $this->conn->query(
            'DELETE FROM `order_list` where id = \'' . $id . '\''
        );
        revert_product($product_id);

        if ($delete) {
            $resp["status"] = "success";
            $user_name = $this->settings->userdata("firstname");
            $insert = $this->conn->query(
                'INSERT INTO `logs` (`origin`, `description`) VALUES (\'ORDER\', \'Pedido ' .
                    $id .
                    " deletado pelo usuário " .
                    $user_name .
                    '\')'
            );
        } else {
            $resp["status"] = "failed";
            $resp["error"] = $this->conn->error;
        }

        if ($resp["status"] == "success") {
        }

        return json_encode($resp);
    }

    public function correct_order()
    {
        global $_settings;
        $this->settings = $_settings;
        extract($_POST);
        $qry = $this->conn
            ->query(
                "SELECT o.status, p.id as product, o.quantity, p.qty_numbers, o.code" .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    "FROM order_list o " .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    "INNER JOIN product_list p ON o.product_id = p.id" .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    'WHERE o.id = \'' .
                    $id .
                    '\''
            )
            ->fetch_assoc();
        $product_id = $qry["product"];
        $qty_numbers = $qry["qty_numbers"] - 1;
        $total_numbers_generated = $qry["quantity"];
        $orders = $this->conn->query(
            'SELECT order_numbers FROM order_list WHERE product_id = \'' .
                $product_id .
                '\' AND status <> 3'
        );
        $cotas_vendidas = [];
        $all_lucky_numbers = [];

        while ($row = $orders->fetch_assoc()) {
            $cotas_vendidas[] = $row["order_numbers"];
        }

        $all_lucky_numbers = implode(",", $cotas_vendidas);
        $all_lucky_numbers = explode(",", $all_lucky_numbers);
        $numeros_ja_vendidos = array_filter($all_lucky_numbers);

        if (
            $qty_numbers <
            $total_numbers_generated + count($numeros_ja_vendidos) - 1
        ) {
            $resp["status"] = "failed";
            $resp["error"] =
                "[DP01] - Erro ao criar pedido, selecione uma quantidade menor.";
            $this->conn->query(
                'DELETE FROM `order_list` where code = \'' . $code . '\''
            );
            $this->conn->query(
                'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` - \'' .
                    $total_numbers_generated .
                    '\' WHERE `id` = \'' .
                    $product_id .
                    '\''
            );
            return json_encode($resp);
        }
        $globos = strlen($qty_numbers);
        $numeris = range(0, $qty_numbers);
        $numeris = array_map(function ($item) use ($qty_numbers, $globos) {
            return str_pad(
                $item,
                max((int) $globos, strlen($qty_numbers)),
                "0",
                STR_PAD_LEFT
            );
        }, $numeris);
        $array_without_ja_vendidos = array_filter(
            array_diff($numeris, $numeros_ja_vendidos)
        );
        shuffle($array_without_ja_vendidos);
        $order_numbers = array_slice(
            $array_without_ja_vendidos,
            0,
            $total_numbers_generated
        );
        $order_numbers = implode(",", $order_numbers) . ",";
        $update = $this->conn->query(
            'UPDATE order_list SET order_numbers =  \'' .
                $order_numbers .
                '\' WHERE id = \'' .
                $id .
                '\''
        );

        if ($update) {
            $resp["status"] = "success";
        } else {
            $resp["status"] = "failed";
        }

        return json_encode($resp);
    }

    public function correct_quantity()
    {
        extract($_POST);
        $qry = $this->conn
            ->query(
                "SELECT o.status, p.id as product, o.quantity, p.qty_numbers, o.code, o.order_numbers" .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    "FROM order_list o " .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    "INNER JOIN product_list p ON o.product_id = p.id" .
                    "\r\n\t\t\t\t\t\t\t\t\t" .
                    'WHERE o.id = \'' .
                    $id .
                    '\''
            )
            ->fetch_assoc();
        $product_id = $qry["product"];
        $qty_numbers = $qry["qty_numbers"] - 1;
        $numbers = $qry["order_numbers"];
        $total_numbers_generated = $qtd;
        $orders = $this->conn->query(
            'SELECT order_numbers FROM order_list WHERE product_id = \'' .
                $product_id .
                '\' AND status <> 3'
        );
        $cotas_vendidas = [];
        $all_lucky_numbers = [];

        while ($row = $orders->fetch_assoc()) {
            $cotas_vendidas[] = $row["order_numbers"];
        }

        $all_lucky_numbers = implode(",", $cotas_vendidas);
        $all_lucky_numbers = explode(",", $all_lucky_numbers);
        $numeros_ja_vendidos = array_filter($all_lucky_numbers);

        if (
            $qty_numbers <
            $total_numbers_generated + count($numeros_ja_vendidos) - 1
        ) {
            $resp["status"] = "failed";
            $resp["error"] =
                "[DP01] - Erro ao criar pedido, selecione uma quantidade menor.";
            $this->conn->query(
                'DELETE FROM `order_list` where code = \'' . $code . '\''
            );
            $this->conn->query(
                'UPDATE `product_list` SET `pending_numbers` = `pending_numbers` - \'' .
                    $total_numbers_generated .
                    '\' WHERE `id` = \'' .
                    $product_id .
                    '\''
            );
            return json_encode($resp);
        }
        $globos = strlen($qty_numbers);
        $numeris = range(0, $qty_numbers);
        $numeris = array_map(function ($item) use ($qty_numbers, $globos) {
            return str_pad(
                $item,
                max((int) $globos, strlen($qty_numbers)),
                "0",
                STR_PAD_LEFT
            );
        }, $numeris);
        $array_without_ja_vendidos = array_filter(
            array_diff($numeris, $numeros_ja_vendidos)
        );
        shuffle($array_without_ja_vendidos);
        $order_numbers = array_slice(
            $array_without_ja_vendidos,
            0,
            $total_numbers_generated
        );
        $order_numbers = $numbers . implode(",", $order_numbers) . ",";
        $update = $this->conn->query(
            'UPDATE order_list SET order_numbers =  \'' .
                $order_numbers .
                '\' WHERE id = \'' .
                $id .
                '\''
        );

        if ($update) {
            $resp["status"] = "success";
        } else {
            $resp["status"] = "failed";
        }

        return json_encode($resp);
    }

    public function contact_send_email()
    {
        global $_settings;
        extract($_POST);
        $to = $_settings->info("email");
        $message = "";

        if (!$_settings->info("smtp_host")) {
            $message .= "Nome: " . $nome . "\n";
            $message .= "Email: " . $email . "\n";
            $message .= "Telefone: " . $telefone . "\n";
            $message .= "Campanha: " . $campanha . "\n";
            $message .= "Assunto: " . $assunto . "\n";
            $message .= "Mensagem: " . $mensagem . "\n";
            $mailSent = mail($to, $assunto, $message);

            if ($mailSent) {
                $resp["status"] = "success";
            } else {
                $resp["status"] = "failed";
            }
        } else {
            include app_path("Includes/phpmailer/src/Exception.php");
            include app_path("Includes/phpmailer/src/PHPMailer.php");
            include app_path("Includes/phpmailer/src/SMTP.php");
            $message .= "Nome: " . $nome . "<br>";
            $message .= "Email: " . $email . "<br>";
            $message .= "Telefone: " . $telefone . "<br>";
            $message .= "Campanha: " . $campanha . "<br>";
            $message .= "Assunto: " . $assunto . "<hr>";
            $message .= "Mensagem: " . $mensagem;
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->SMTPOptions = [
                    "ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true,
                    ],
                ];
                $mail->SMTPAuth = true;
                $mail->Host = $_settings->info("smtp_host");
                $mail->Username = $_settings->info("smtp_user");
                $mail->Password = $_settings->info("smtp_pass");
                $mail->SMTPSecure =
                    PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $_settings->info("smtp_port");
                $mail->CharSet = "UTF-8";
                $mail->setFrom(
                    $_settings->info("smtp_user"),
                    $_settings->info("name")
                );
                $mail->addAddress($to, $nome);
                $mail->isHTML(true);
                $mail->Subject = $assunto;
                $mail->Body = $message;
                $mail->send();
                $resp["status"] = "success";
            } catch (PHPMailer\PHPMailer\Exception $e) {
                echo "Não foi possível enviar a mensagem. Mailer Error: " .
                    $mail->ErrorInfo;
                $resp["status"] = "failed";
            }
        }

        return json_encode($resp);
    }

    public function recover_password()
    {
        if (!$this->settings->userdata("firstname")) {
            $resp["status"] = "failed";
            $resp["msg"] = "Não autorizado.";
            return json_encode($resp);
        }

        global $_settings;
        extract($_POST);
        $assunto = "Recuperação de senha";
        $message = "";
        $senha = $this->generate_password();
        $qry = $this->conn->query(
            'SELECT * FROM customer_list WHERE email = \'' . $email . '\''
        );

        if (0 < $qry->num_rows) {
            $update_pass = $this->conn->query(
                'UPDATE `customer_list` SET `password` = md5(\'' .
                    $senha .
                    '\') WHERE email = \'' .
                    $email .
                    '\''
            );

            if ($update_pass) {
                if (!$_settings->info("smtp_host")) {
                    $message .=
                        'Olá, vimos que você solicitou uma recuperação de senha, aqui estão os dados da sua nova senha:\\n\\n';
                    $message .= "Nova senha: " . $senha . "\n";
                    $mailSent = mail($email, $assunto, $message);

                    if ($mailSent) {
                        $resp["status"] = "success";
                    } else {
                        $resp["status"] = "failed";
                    }
                } else {
                    include app_path("Includes/phpmailer/src/Exception.php");
                    include app_path("Includes/phpmailer/src/PHPMailer.php");
                    include app_path("Includes/phpmailer/src/SMTP.php");
                    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                    $message .=
                        "Olá, vimos que você solicitou uma recuperação de senha, aqui estão os dados da sua nova senha:<br><br>";
                    $message .= "Nova senha: " . $senha . "<br><br>";
                    $message .= "Atenciosamente " . $_settings->info("name");

                    try {
                        $mail->isSMTP();
                        $mail->SMTPSecure = "ssl";
                        $mail->Mailer = "smtp";
                        $mail->SMTPDebug = 0;
                        $mail->SMTPAuth = true;
                        $mail->Host = $_settings->info("smtp_host");
                        $mail->Username = $_settings->info("smtp_user");
                        $mail->Password = $_settings->info("smtp_pass");
                        $mail->SMTPSecure =
                            PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = $_settings->info("smtp_port");
                        $mail->CharSet = "UTF-8";
                        $mail->setFrom(
                            $_settings->info("smtp_user"),
                            $_settings->info("name")
                        );
                        $mail->addAddress($email, "Customer");
                        $mail->isHTML(true);
                        $mail->Subject = $assunto;
                        $mail->Body = $message;
                        $mail->send();
                        $resp["status"] = "success";
                    } catch (PHPMailer\PHPMailer\Exception $e) {
                        echo "Não foi possível enviar a mensagem. Mailer Error: " .
                            $mail->ErrorInfo;
                        $resp["status"] = "failed";
                    }
                }
            }
        }

        return json_encode($resp);
    }

    public function recover_password_admin()
    {
        if (!$this->settings->userdata("firstname")) {
            $resp["status"] = "failed";
            $resp["msg"] = "Não autorizado.";
            return json_encode($resp);
        }

        global $_settings;
        extract($_POST);
        $assunto = "Recuperação de senha";
        $message = "";
        $senha = $this->generate_password();
        $qry = $this->conn->query(
            'SELECT * FROM users WHERE username = \'' .
                $username .
                '\' AND email = \'' .
                $email .
                '\''
        );

        if (0 < $qry->num_rows) {
            $update_pass = $this->conn->query(
                'UPDATE `users` SET `password` = md5(\'' .
                    $senha .
                    '\') WHERE username = \'' .
                    $username .
                    '\''
            );

            if ($update_pass) {
                if (!$_settings->info("smtp_host")) {
                    $message .=
                        "Olá, vimos que você solicitou uma recuperação de senha, aqui estão os dados da sua nova senha:" .
                        "\n\n";
                    $message .= "Nova senha: " . $senha . "\n\n";
                    $message .= "Atenciosamente " . $_settings->info("name");
                    $mailSent = mail($email, $assunto, $message);

                    if ($mailSent) {
                        $resp["status"] = "success";
                    } else {
                        $resp["status"] = "failed";
                    }
                } else {
                    include app_path("Includes/phpmailer/src/Exception.php");
                    include app_path("Includes/phpmailer/src/PHPMailer.php");
                    include app_path("Includes/phpmailer/src/SMTP.php");
                    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                    $message .=
                        "Olá, vimos que você solicitou uma recuperação de senha, aqui estão os dados da sua nova senha:<br><br>";
                    $message .= "Nova senha: " . $senha . "<br><br>";
                    $message .= "Atenciosamente " . $_settings->info("name");

                    try {
                        $mail->SMTPAuth = true;
                        $mail->Host = $_settings->info("smtp_host");
                        $mail->Username = $_settings->info("smtp_user");
                        $mail->Password = $_settings->info("smtp_pass");
                        $mail->SMTPSecure =
                            PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = $_settings->info("smtp_port");
                        $mail->CharSet = "UTF-8";
                        $mail->setFrom(
                            $_settings->info("smtp_user"),
                            $_settings->info("name")
                        );
                        $mail->addAddress($email, $_settings->info("name"));
                        $mail->isHTML(true);
                        $mail->Subject = $assunto;
                        $mail->Body = $message;
                        $mail->send();
                        $resp["status"] = "success";
                    } catch (PHPMailer\PHPMailer\Exception $e) {
                        echo "Não foi possível enviar a mensagem. Mailer Error: " .
                            $mail->ErrorInfo;
                        $resp["status"] = "failed";
                    }
                }
            }
        } else {
            echo "Usuário ou email inválido.";
            $resp["status"] = "failed";
            return json_encode($resp);
        }

        return json_encode($resp);
    }

    public function generate_password()
    {
        $alphabet =
            "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 8; ++$i) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    public function search_orders_by_phone()
    {
        $phone = $this->conn->real_escape_string($_POST["phone"]);
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $resp = [];
        $customerQuery = $this->conn->query(
            "\r\n\t\t\t" .
                "SELECT id" .
                "\r\n\t\t\t" .
                "FROM customer_list" .
                "\r\n\t\t\t" .
                'WHERE phone = \'' .
                $phone .
                '\'' .
                "\r\n\t\t\t"
        );
        if ($customerQuery && 0 < $customerQuery->num_rows) {
            $customerRow = $customerQuery->fetch_assoc();
            $customerId = $customerRow["id"];
            $orderQuery = $this->conn->query(
                "\r\n\t\t\t\t" .
                    "SELECT *" .
                    "\r\n\t\t\t\t" .
                    "FROM order_list" .
                    "\r\n\t\t\t\t" .
                    'WHERE customer_id = \'' .
                    $customerId .
                    '\'' .
                    "\r\n\t\t\t\t"
            );
            if ($orderQuery && 0 < $orderQuery->num_rows) {
                $_SESSION["phone"] = $phone;
                $resp["status"] = "success";
                $resp["redirect"] = "/meus-numeros";
            } else {
                $resp["status"] = "failed";
                $resp["error"] =
                    "Nenhum resultado encontrado na tabela order_list para o número de telefone fornecido.";
            }
        } else {
            $resp["status"] = "failed";
            $resp["error"] =
                "Nenhum resultado encontrado na tabela customer_list para o número de telefone fornecido.";
        }

        return json_encode($resp);
    }

    public function search_orders_by_cpf()
    {
        $cpf = $this->conn->real_escape_string($_POST["cpf"]);
        $resp = [];
        $cpfQuery = $this->conn->query(
            'SELECT `id` FROM customer_list WHERE cpf = \'' . $cpf . '\''
        );
        if ($cpfQuery && 0 < $cpfQuery->num_rows) {
            $cpfRow = $cpfQuery->fetch_assoc();
            $clientId = $cpfRow["id"];
            $orderQuery = $this->conn->query(
                'SELECT * FROM order_list WHERE customer_id = \'' .
                    $clientId .
                    '\''
            );
            if ($orderQuery && 0 < $orderQuery->num_rows) {
                $_SESSION["cpf"] = $cpf;
                $resp["status"] = "success";
                $resp["redirect"] = "/meus-numeros";
            } else {
                $resp["status"] = "failed";
                $resp["error"] =
                    "Nenhum resultado encontrado na tabela order_list para o CPF fornecido.";
            }
        } else {
            $resp["status"] = "failed";
            $resp["error"] =
                "Nenhum resultado encontrado na tabela customer_list para o CPF fornecido.";
        }

        return json_encode($resp);
    }
    public function load_numbers()
    {
        $status = $_POST["status"];
        $id = $_POST["id"];
        $resultado = [];

        if ($status == 1) {
      
$stmt_plist = $this->conn->prepare("SELECT qty_numbers, pending_numbers, paid_numbers FROM `product_list` WHERE id = ?");
$stmt_plist->bind_param("i", $id);
$stmt_plist->execute();
$stmt_plist->bind_result($qty_numbers, $pending_numbers, $paid_numbers);
$stmt_plist->fetch();
$stmt_plist->close();

$total_numbers_generated = $qty_numbers;
if ($pending_numbers > 0 || $paid_numbers > 0) {
    $total_numbers_generated -= ($pending_numbers + $paid_numbers);
}

$stmt_orders = $this->conn->prepare("SELECT order_numbers FROM order_list WHERE product_id = ?");
$stmt_orders->bind_param("i", $id);
$stmt_orders->execute();
$stmt_orders->bind_result($order_numbers);

$used_numbers = [];
while ($stmt_orders->fetch()) {
    $used_numbers[] = $order_numbers;
}
$stmt_orders->close();

// Convertendo $used_numbers em um array único
$used_numbers = array_unique($used_numbers);

// Convertendo a lista de números usados em um array associativo para otimizar a busca
$used_numbers_assoc = array_flip($used_numbers);

$numeros = [];
$unique_numbers_needed = $total_numbers_generated;

$max_attempts = $qty_numbers * 2; // Limite de tentativas para evitar loop infinito

while ($unique_numbers_needed > 0 && $max_attempts > 0) {
    $random_number = str_pad(rand(0, $qty_numbers - 1), strlen($qty_numbers), "0", STR_PAD_LEFT);
    if (!isset($used_numbers_assoc[$random_number])) {
        $numeros[] = $random_number;
        $used_numbers_assoc[$random_number] = true;
        $unique_numbers_needed--;
    }
    $max_attempts--;
}

// Verificando se o limite de tentativas foi atingido
if ($unique_numbers_needed > 0) {
    throw new Exception("Não foi possível gerar números únicos suficientes dentro do limite de tentativas.");
}

// Limpando e ajustando os números gerados
$numeros = array_values($numeros);

        } elseif ($status == 2) {
            $result = $this->conn->query("
  SELECT ol.order_numbers, cl.firstname
  FROM order_list ol
  JOIN customer_list cl ON ol.customer_id = cl.id
  WHERE ol.product_id = '{$id}' AND ol.status = '1'
");

            $numeros = [];
            $firstnames = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order_numbers = $row["order_numbers"];
                    $order_numbers_array = explode(",", $order_numbers);
                    $order_numbers_array = array_filter($order_numbers_array);

                    foreach ($order_numbers_array as $numero) {
                        $numeros[] = $numero;
                        $firstnames[] = $row["firstname"];
                    }
                }
            }
        } elseif ($status == 3) {
            $result = $this->conn->query("
  SELECT ol.order_numbers, cl.firstname
  FROM order_list ol
  JOIN customer_list cl ON ol.customer_id = cl.id
  WHERE ol.product_id = '{$id}' AND ol.status = '2'
");

            $numeros = [];
            $firstnames = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order_numbers = $row["order_numbers"];
                    $order_numbers_array = explode(",", $order_numbers);
                    $order_numbers_array = array_filter($order_numbers_array);

                    foreach ($order_numbers_array as $numero) {
                        $numeros[] = $numero;
                        $firstnames[] = $row["firstname"];
                    }
                }
            }
        } elseif ($status == 4) {
            $numeros = [];
            $firstnames = [];
            $payment_status = [];

            $stmt_plist = $this->conn->prepare(
                "SELECT qty_numbers, pending_numbers, paid_numbers FROM `product_list` WHERE id = ?"
            );
            $stmt_plist->bind_param("i", $id);
            $stmt_plist->execute();
            $product_list = $stmt_plist->get_result();

            if ($product_list->num_rows > 0) {
                $product = $product_list->fetch_assoc();
                $qty_numbers = $product["qty_numbers"];
                $pending_numbers = $product["pending_numbers"];
                $paid_numbers = $product["paid_numbers"];
            }

            //$qty_numbers = $qty_numbers - 1;
            $total_numbers_generated = 25;
            /*	if($pending_numbers || $paid_numbers){
    $total_numbers_generated = $qty_numbers - ($pending_numbers + $paid_numbers);
	} */

            $all_lucky_numbers = [];
            $orders = $this->conn->query("
  SELECT ol.order_numbers, ol.status, cl.firstname
  FROM order_list ol
  JOIN customer_list cl ON ol.customer_id = cl.id
  WHERE ol.product_id = '{$id}'
");

            while ($row1 = $orders->fetch_assoc()) {
                $order_numbers = $row1["order_numbers"];
                $order_numbers_array = explode(",", $order_numbers);
                $order_numbers_array = array_filter($order_numbers_array);

                foreach ($order_numbers_array as $numero) {
                    $numeros[] = $numero;
                    $firstnames[$numero] = $row1["firstname"];
                    $payment_status[$numero] = $row1["status"];
                }
            }

            $all_lucky_numbers = implode(",", $all_lucky_numbers);
            $all_lucky_numbers = explode(",", $all_lucky_numbers);
            $used_numbers = array_flip($all_lucky_numbers);
            $numeros = [];
            for ($j = 0; $j < $total_numbers_generated; $j++) {
                $stmt_orders = $this->conn->prepare(
                    "SELECT order_numbers FROM order_list WHERE product_id = ?"
                );
                $stmt_orders->bind_param("i", $id);
                $stmt_orders->execute();
                $orders = $stmt_orders->get_result();
                if ($orders->num_rows > 0) {
                    $order = $orders->fetch_assoc();
                    $order_lucky_numbers = $order["order_numbers"];
                }

                $lucky_numbers = "";

                do {
                    $random_number = str_pad(
                        rand(0, $qty_numbers - 1),
                        strlen($qty_numbers),
                        "0",
                        STR_PAD_LEFT
                    );
                    $random_number = sprintf(
                        "%0" . strlen($qty_numbers) . "d",
                        $random_number
                    );
                } while (isset($used_numbers[$random_number]));

                $used_numbers[$random_number] = true;
                $numeros[] = $random_number;
            }
        } elseif ($status == 5) {
            $numeros = [];
            $firstnames = [];
            $payment_status = [];

            $stmt_plist = $this->conn->prepare(
                "SELECT qty_numbers, pending_numbers, paid_numbers FROM `product_list` WHERE id = ?"
            );
            $stmt_plist->bind_param("i", $id);
            $stmt_plist->execute();
            $product_list = $stmt_plist->get_result();

            if ($product_list->num_rows > 0) {
                $product = $product_list->fetch_assoc();
                $qty_numbers = $product["qty_numbers"];
                $pending_numbers = $product["pending_numbers"];
                $paid_numbers = $product["paid_numbers"];
            }

            $total_numbers_generated = 50;

            $all_lucky_numbers = [];
            $orders = $this->conn->query("
  SELECT ol.order_numbers, ol.status, cl.firstname
  FROM order_list ol
  JOIN customer_list cl ON ol.customer_id = cl.id
  WHERE ol.product_id = '{$id}'
");

            while ($row1 = $orders->fetch_assoc()) {
                $order_numbers = $row1["order_numbers"];
                $order_numbers_array = explode(",", $order_numbers);
                $order_numbers_array = array_filter($order_numbers_array);

                foreach ($order_numbers_array as $numero) {
                    $numeros[] = $numero;
                    $firstnames[$numero] = $row1["firstname"];
                    $payment_status[$numero] = $row1["status"];
                }
            }

            $all_lucky_numbers = implode(",", $all_lucky_numbers);
            $all_lucky_numbers = explode(",", $all_lucky_numbers);
            $used_numbers = array_flip($all_lucky_numbers);
            $numeros = [];
            for ($j = 0; $j < $total_numbers_generated; $j++) {
                $stmt_orders = $this->conn->prepare(
                    "SELECT order_numbers FROM order_list WHERE product_id = ?"
                );
                $stmt_orders->bind_param("i", $id);
                $stmt_orders->execute();
                $orders = $stmt_orders->get_result();
                if ($orders->num_rows > 0) {
                    $order = $orders->fetch_assoc();
                    $order_lucky_numbers = $order["order_numbers"];
                }

                $lucky_numbers = "";

                do {
                    $random_number = str_pad(
                        rand(0, $qty_numbers - 1),
                        strlen($qty_numbers),
                        "0",
                        STR_PAD_LEFT
                    );
                    $random_number = sprintf(
                        "%0" . strlen($qty_numbers) . "d",
                        $random_number
                    );
                } while (isset($used_numbers[$random_number]));

                $used_numbers[$random_number] = true;
                $numeros[] = $random_number;
            }
        }

        if (!empty($numeros)) {
            $resultado["status"] = "success";
            $resultado["qty_numbers"] =  count($numeros) . '---' .  round(memory_get_usage() / (1024 * 1024), 2) . " MB";
            $resultado["numeros"] = $numeros;
            $resultado["compradas"] = $purchased;
            $resultado["nomes"] = $firstnames;
            $resultado["payment_status"] = isset($payment_status)
                ? $payment_status
                : "";
            return json_encode($resultado);
        } else {
            $resultado["status"] = "error";
        }
    }
    public function search_raffle_winner()
    {

        if (isset($_POST['id']) && isset($_POST['draw_number']) && isset($_POST['draw_winner'])) {
            $id = $this->conn->real_escape_string($_POST["id"]);

            $number = $this->conn->real_escape_string($_POST["draw_number"]);
            $draw_number_formatado = preg_replace("/[^0-9]/", "", $number);
            $array_draw_number = [$draw_number_formatado];
            $draw_number = json_encode($array_draw_number);

            $winner = $this->conn->real_escape_string($_POST["draw_winner"]);
            $draw_winner_formatado = preg_replace("/[^0-9]/", "", $winner);
            $array_draw_winner = [$draw_winner_formatado];
            $draw_winner = json_encode($array_draw_winner);

            $sql = "UPDATE `product_list` SET `draw_number`='{$draw_number}', `draw_winner`='{$draw_winner}' WHERE `id` = {$id};";
            $save = $this->conn->query($sql);
            if ($save) {
                $resp["status"] = "success";
                $resp["msg"] = "Vencedor salvo com sucesso.";
            } else {
                $resp["status"] = "failed";
                $resp["err"] = $this->conn->error . "[{$sql}]";
            }

            return json_encode($resp);
        }

        $draw_number = trim($this->conn->real_escape_string($_POST["number"]));
        $raffle = $this->conn->real_escape_string($_POST["raffle"]);
        $sqlx =
            "\r\n\t\t" .
            "SELECT type_of_draw" .
            "\r\n\t\t" .
            "FROM product_list" .
            "\r\n\t\t" .
            'WHERE id = \'' .
            $raffle .
            '\'' .
            "\r\n\t\t" .
            "LIMIT 1" .
            "\r\n\t\t";
        $resultx = $this->conn->query($sqlx);
        $type_of_draw = "";
        if ($resultx && 0 < $resultx->num_rows) {
            $row = $resultx->fetch_assoc();
            $type_of_draw = $row["type_of_draw"];
        }

        $bichos = [];

        if ($type_of_draw == 3) {
            $bichos = [
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
                10 => "Cavalo",
                11 => "Elefante",
                12 => "Galo",
                13 => "Gato",
                14 => "Jacaré",
                15 => "Leão",
                16 => "Macaco",
                17 => "Porco",
                18 => "Pavão",
                19 => "Peru",
                20 => "Touro",
                21 => "Tigre",
                22 => "Urso",
                23 => "Veado",
                24 => "Vaca",
            ];
        }

        if ($type_of_draw == 4) {
            $bichos = [
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
                10 => "Cabra M1",
                11 => "Cabra M2",
                12 => "Carneiro M1",
                13 => "Carneiro M2",
                14 => "Camelo M1",
                15 => "Camelo M2",
                16 => "Cobra M1",
                17 => "Cobra M2",
                18 => "Coelho M1",
                19 => "Coelho M2",
                20 => "Cavalo M1",
                21 => "Cavalo M2",
                22 => "Elefante M1",
                23 => "Elefante M2",
                24 => "Galo M1",
                25 => "Galo M2",
                26 => "Gato M1",
                27 => "Gato M2",
                28 => "Jacaré M1",
                29 => "Jacaré M2",
                30 => "Leão M1",
                31 => "Leão M2",
                32 => "Macaco M1",
                33 => "Macaco M2",
                34 => "Porco M1",
                35 => "Porco M2",
                36 => "Pavão M1",
                37 => "Pavão M2",
                38 => "Peru M1",
                39 => "Peru M2",
                40 => "Touro M1",
                41 => "Touro M2",
                42 => "Tigre M1",
                43 => "Tigre M2",
                44 => "Urso M1",
                45 => "Urso M2",
                46 => "Veado M1",
                47 => "Veado M2",
                48 => "Vaca M1",
                49 => "Vaca M2",
            ];
        }

        $draw_number_normalized = $draw_number;
        $bicho = "";

        foreach ($bichos as $key => $value) {
            $normalizedValue = $value;

            if (strcmp($draw_number_normalized, $normalizedValue) === 0) {
                $draw_number = $key;
                $bicho = $value;
                break;
            }
        }

        $sql =
            "\r\n\t\t" .
            "SELECT o.id, c.firstname, c.lastname, c.email, c.phone, o.date_created, o.status, o.quantity, o.total_amount, o.product_name" .
            "\r\n\t\t" .
            "FROM order_list o" .
            "\r\n\t\t" .
            "INNER JOIN customer_list c ON o.customer_id = c.id" .
            "\r\n\t\t" .
            "INNER JOIN product_list p ON o.product_id = p.id" .
            "\r\n\t\t" .
            'WHERE (o.order_numbers LIKE CONCAT(\'%,\', \'' .
            $draw_number .
            '\', \',%\') ' .
            "\r\n\t\t" .
            'OR o.order_numbers LIKE CONCAT(\'' .
            $draw_number .
            '\', \',%\') ' .
            "\r\n\t\t" .
            'OR o.order_numbers LIKE CONCAT(\'%,\', \'' .
            $draw_number .
            '\')' .
            "\r\n\t\t" .
            'OR o.order_numbers = \'' .
            $draw_number .
            '\')' .
            "\r\n\t\t" .
            'AND o.product_id = \'' .
            $raffle .
            '\'' .
            "\r\n\t\t" .
            "AND o.status = 2" .
            "\r\n\t\t" .
            "LIMIT 1" .
            "\r\n\t";
        $result = $this->conn->query($sql);
        if ($result && 0 < $result->num_rows) {
            $row = $result->fetch_assoc();
            $pedidoId = $row["id"];
            $firstname = $row["firstname"];
            $lastname = $row["lastname"];
            $email = $row["email"];
            $phone = $row["phone"];
            $date =
                date("d/m/Y", strtotime($row["date_created"])) .
                " às " .
                date("H:i", strtotime($row["date_created"]));
            $quantity = $row["quantity"];
            $value = number_format(
                $row["total_amount"] ? $row["total_amount"] : 0,
                2,
                ",",
                "."
            );
            $fullname = "" . $firstname . " " . $lastname . "";
            $payment_status = $row["status"];
            $product_name = $row["product_name"];

            if ($payment_status == 1) {
                $payment_status = "Pendente";
            }

            if ($payment_status == 2) {
                $payment_status = "Pago";
            }

            if ($payment_status == 3) {
                $payment_status = "Cancelado";
            }

            if ($bicho) {
                $draw_number = $bicho;
            }

            $resultado["status"] = "success";
            $resultado["pedido"] = $pedidoId;
            $resultado["name"] = $fullname;
            $resultado["phone"] = $phone;
            $resultado["date"] = $date;
            $resultado["quantity"] = $quantity;
            $resultado["value"] = $value;
            $resultado["number"] = $draw_number;
            $resultado["payment_status"] = $payment_status;
            $resultado["product_name"] = $product_name;
            $resultado["type_of_draw"] = $type_of_draw;
            echo json_encode($resultado);
            exit();
        } else {
            $resultado["status"] = "failed";
            echo json_encode($resultado);
            exit();
        }
    }

    function save_raffle_winner()
    {
        if (
            !isset($_POST["id"], $_POST["draw_number"], $_POST["draw_winner"])
        ) {
            $resp["status"] = "failed";
            $resp["err"] = "Vencedor não encontrado.";
            echo json_encode($resp);
            return;
        }

        $id = $this->conn->real_escape_string($_POST["id"]);

        $number = $this->conn->real_escape_string($_POST["draw_number"]);
        $draw_number_formatado = preg_replace("/[^0-9]/", "", $number);
        $array_draw_number = [$draw_number_formatado];
        $draw_number = json_encode($array_draw_number);

        $winner = $this->conn->real_escape_string($_POST["draw_winner"]);
        $draw_winner_formatado = preg_replace("/[^0-9]/", "", $winner);
        $array_draw_winner = [$draw_winner_formatado];
        $draw_winner = json_encode($array_draw_winner);

        $sql = "UPDATE `product_list` SET `draw_number`='{$draw_number}', `draw_winner`='{$draw_winner}' WHERE `id` = {$id};";
        $save = $this->conn->query($sql);
        if ($save) {
            $resp["status"] = "success";
            $resp["msg"] = "Vencedor salvo com sucesso.";
        } else {
            $resp["status"] = "failed";
            $resp["err"] = $this->conn->error . "[{$sql}]";
        }

        return json_encode($resp);
    }
    function manage_draw()
    {
        $product_id = $this->conn->real_escape_string($_POST["product_id"]);
        $horainicial = $this->conn->real_escape_string($_POST["horainicial"]);
        $horafinal = $this->conn->real_escape_string($_POST["horafinal"]);
        $valorqt = $this->conn->real_escape_string($_POST["valorqt"]);

        if ($product_id == "") {
            $resp["status"] = "failed";
            $resp["error"] = "Erro ao criar sorteio.";
            return json_encode($resp);
            exit();
        }

        // Consulta SQL para buscar order_numbers onde product_id é igual a $product_id
        $query = "SELECT order_numbers FROM order_list WHERE product_id = '$product_id'";

        // Adiciona a condição para valorqt se estiver disponível
        if (!empty($valorqt)) {
            $query .= " AND quantity >= '$valorqt'";
        }

        // Adiciona as condições para horainicial e horafinal se estiverem disponíveis
        if (!empty($horainicial) && !empty($horafinal)) {
            $query .= " AND date_created BETWEEN '$horainicial' AND '$horafinal'";
        }

        // Executar a consulta
        $result = $this->conn->query($query);
        // Array para armazenar os order_numbers
        $order_numbers = [];

        // Fetch all rows from the result set
        while ($row = $result->fetch_assoc()) {
            // Adicionar cada order_number ao array
            $order_numbers[] = $row["order_numbers"];
        }

        // Agora $order_numbers é um array com todos os order_numbers onde product_id é igual a $product_id
        // Vamos verificar se o array está vazio
        if (empty($order_numbers)) {
            $resp["status"] = "failed";
            $resp["error"] = "Não há números vendidos para este sorteio.";
            return json_encode($resp);
            exit();
        }
        // vamos verificar entradas duplicadas

        $new_array = explode(",", $order_numbers[0]);
        $order_numbers = $new_array;

        // Verificar se o array está vazio
        if (empty($order_numbers)) {
            $resp["status"] = "failed";
            $resp["error"] = "Não há números vendidos para este sorteio.";
            return json_encode($resp);
            exit();
        }
        $result = array_rand($order_numbers, 1);

        $winner = $this->conn->real_escape_string($order_numbers[$result]);

        $sql = "SELECT * FROM `order_list` WHERE FIND_IN_SET('$winner', order_numbers) > 0 AND product_id = '$product_id'";
        $result = $this->conn->query($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if (empty($rows)) {
            $resp["status"] = "failed";
            $resp["error"] = "Erro ao buscar vencedor.";
            return json_encode($resp);
            exit();
        }

        $res = $rows[0];
        $res["draw_cota"] = $winner;
        $customer_winner = "SELECT * FROM `customer_list` WHERE id = '{$res["customer_id"]}'";
        $customer = $this->conn->query($customer_winner)->fetch_assoc();
        $res["customer_name"] =
            $customer["firstname"] . " " . $customer["lastname"];
        $res["customer_phone"] = $customer["phone"];
        $res["customer_avatar"] = $customer["avatar"];

        return json_encode($res);
    }
    public function verify_orders_mp()
    {
        extract($_GET);
        $mercadopago_access_token = $this->settings->info(
            "mercadopago_access_token"
        );
        $orders = $this->conn->query(
            "SELECT o.id, o.id_mp" .
                "\r\n\t\t\t" .
                "FROM order_list o WHERE o.status = 3 " .
                "\r\n\t\t\t" .
                'AND o.date_created BETWEEN \'' .
                $start .
                ' 00:00:00\' AND \'' .
                $end .
                ' 23:59:59\'' .
                "\r\n\t\t\t" .
                "AND o.product_id = " .
                $product .
                "\r\n\t\t\t" .
                'AND payment_method = \'MercadoPago\''
        );

        if (0 < $orders->num_rows) {
            echo "Quantidade de pedidos: " . $orders->num_rows . "<hr>";

            while ($row = $orders->fetch_assoc()) {
                $order_id = $row["id"];
                $url =
                    "https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=" .
                    $order_id .
                    "&range=date_created&begin_date=NOW-5DAYS&end_date=NOW";
                $headers = [
                    "Accept: application/json",
                    "Authorization: Bearer " . $mercadopago_access_token,
                ];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resposta = curl_exec($ch);
                curl_close($ch);
                $payment_info = json_decode($resposta, true);
                $status = $payment_info["results"][0]["status"];
                echo "Pedido " .
                    $order_id .
                    " está com status: " .
                    $status .
                    " no Mercado Pago<br>";
            }

            echo "<hr>Fim da verificação de pedidos.";
        } else {
            echo "Nenhum pedido a ser verificado.";
        }
    }

    public function verify_duplicates()
    {
        extract($_GET);

        if ($id) {
            $time_start = microtime(true);
            $orders = $this->conn->query(
                'SELECT o.order_numbers, p.qty_numbers FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE o.status <> 3 AND o.product_id = \'' .
                    $id .
                    '\''
            );
            $cotas_vendidas = [];

            while ($row = $orders->fetch_assoc()) {
                $cotas_vendidas[] = $row["order_numbers"];
            }

            $cotas_vendidas = implode(",", $cotas_vendidas);
            $cotas_vendidas = explode(",", $cotas_vendidas);
            $cotas_vendidas = array_filter($cotas_vendidas);
            $duplicate_numbers = array_diff_assoc(
                $cotas_vendidas,
                array_unique($cotas_vendidas)
            );
            echo "Total: " . count($duplicate_numbers) . "<br>";

            if (empty($duplicate_numbers)) {
                echo "Números duplicados: nenhum<br><hr>";
            } else {
                echo "Números duplicados: " .
                    implode(",", $duplicate_numbers) .
                    "<br><hr>";
            }

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start) / 60;
            echo "Processo realizado com sucesso.<br>";
            echo "Tempo de duração: " . $execution_time;
        }
    }

    public function correct_duplicates()
    {
        extract($_GET);

        if ($id) {
            $time_start = microtime(true);

            if ($type == 1) {
                $orders = $this->conn->query(
                    'SELECT o.order_numbers, p.qty_numbers FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE o.status <> 3 AND o.product_id = \'' .
                        $id .
                        '\''
                );
                $cotas_vendidas = [];

                while ($row = $orders->fetch_assoc()) {
                    $cotas_vendidas[] = $row["order_numbers"];
                    $qty_numbers = $row["qty_numbers"];
                }
                $cotas_vendidas = implode(",", $cotas_vendidas);
                $cotas_vendidas = explode(",", $cotas_vendidas);
                $cotas_vendidas = array_filter($cotas_vendidas);
                $duplicate_numbers = array_unique(
                    array_diff_assoc(
                        $cotas_vendidas,
                        array_unique($cotas_vendidas)
                    )
                );
                echo "Total: " . count($duplicate_numbers) . "<br>";
                echo "Números duplicados: " .
                    implode(",", $duplicate_numbers) .
                    "<br><hr>";
                $qty_numbers = $qty_numbers - 1;
                $globos = strlen($qty_numbers);
                $numeris = range(0, $qty_numbers);
                $numeris = array_map(function ($item) use (
                    $qty_numbers,
                    $globos
                ) {
                    return str_pad(
                        $item,
                        max((int) $globos, strlen($qty_numbers)),
                        "0",
                        STR_PAD_LEFT
                    );
                }, $numeris);
                $array_without_ja_vendidos = array_filter(
                    array_diff($numeris, $cotas_vendidas)
                );
                shuffle($array_without_ja_vendidos);
                $order_numbers = array_slice(
                    $array_without_ja_vendidos,
                    0,
                    count($duplicate_numbers)
                );

                if (0 < count($duplicate_numbers)) {
                    $count = 0;

                    foreach ($duplicate_numbers as $number) {
                        $find_query = $this->conn->query(
                            "SELECT * FROM order_list WHERE product_id=" .
                                $id .
                                ' AND status <> 3 AND order_numbers REGEXP \'' .
                                $number .
                                '\' ORDER BY id DESC LIMIT 1'
                        );

                        while ($row = $find_query->fetch_assoc()) {
                            $oid = $row["id"];
                            $new_number = $order_numbers[$count];
                            $update = $this->conn->query(
                                'UPDATE order_list SET order_numbers = REPLACE(order_numbers, \'' .
                                    $number .
                                    '\', \'' .
                                    $new_number .
                                    '\') WHERE id = \'' .
                                    $oid .
                                    '\''
                            );
                            ++$count;
                        }
                    }
                }
            } elseif ($type == 2) {
                $orders = $this->conn->query(
                    'SELECT o.order_numbers, p.qty_numbers FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE o.status <> 3 AND o.product_id = \'' .
                        $id .
                        '\''
                );
                $cotas_vendidas = [];

                while ($row = $orders->fetch_assoc()) {
                    $cotas_vendidas[] = $row["order_numbers"];
                    $qty_numbers = $row["qty_numbers"];
                }
                $cotas_vendidas = implode(",", $cotas_vendidas);
                $cotas_vendidas = explode(",", $cotas_vendidas);
                $cotas_vendidas = array_filter($cotas_vendidas);
                $duplicate_numbers = array_unique(
                    array_diff_assoc(
                        $cotas_vendidas,
                        array_unique($cotas_vendidas)
                    )
                );
                echo "Total: " . count($duplicate_numbers) . "<br>";
                echo "Números duplicados: " .
                    implode(",", $duplicate_numbers) .
                    "<br><hr>";
                $qty_numbers = $qty_numbers - 1;
                $globos = strlen($qty_numbers);
                $numeris = range(0, $qty_numbers);
                $numeris = array_map(function ($item) use (
                    $qty_numbers,
                    $globos
                ) {
                    return str_pad(
                        $item,
                        max((int) $globos, strlen($qty_numbers)),
                        "0",
                        STR_PAD_LEFT
                    );
                }, $numeris);
                $array_without_ja_vendidos = array_filter(
                    array_diff($numeris, $cotas_vendidas)
                );
                shuffle($array_without_ja_vendidos);
                $order_numbers = array_slice(
                    $array_without_ja_vendidos,
                    0,
                    count($duplicate_numbers)
                );

                if (0 < count($duplicate_numbers)) {
                    $count = 0;

                    foreach ($duplicate_numbers as $number) {
                        $find_query = $this->conn->query(
                            "SELECT id, order_numbers FROM order_list WHERE product_id=" .
                                $id .
                                ' AND status <> 3 AND order_numbers REGEXP \'' .
                                $number .
                                '\' ORDER BY id DESC LIMIT 1'
                        );

                        while ($row = $find_query->fetch_assoc()) {
                            $oid = $row["id"];
                            $num_pedidos = $row["order_numbers"];
                            $num_pedidos = explode(",", $num_pedidos);
                            $new_duplicate_numbers = array_unique(
                                array_diff_assoc(
                                    $num_pedidos,
                                    array_unique($num_pedidos)
                                )
                            );

                            foreach ($new_duplicate_numbers
                                as $index => $new_number) {
                                $num_pedidos[$index] = $order_numbers[$count];
                            }

                            $novos_numeros = implode(",", $num_pedidos);
                            $update = $this->conn->query(
                                'UPDATE order_list SET order_numbers = \'' .
                                    $novos_numeros .
                                    '\' WHERE id = \'' .
                                    $oid .
                                    '\''
                            );
                            ++$count;
                        }
                    }
                }
            } elseif ($type == 3) {
                $orders = $this->conn->query(
                    'SELECT o.order_numbers, p.qty_numbers FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE o.product_id = \'' .
                        $id .
                        '\''
                );
                $cotas_vendidas = [];

                while ($row = $orders->fetch_assoc()) {
                    $cotas_vendidas[] = $row["order_numbers"];
                    $qty_numbers = $row["qty_numbers"];
                }
                $cotas_vendidas = implode(",", $cotas_vendidas);
                $cotas_vendidas = explode(",", $cotas_vendidas);
                $cotas_vendidas = array_filter($cotas_vendidas);
                $duplicate_numbers = array_filter(
                    array_unique(
                        array_diff_assoc($cotas_vendidas, $cotas_vendidas)
                    )
                );
                echo "Total: " . count($duplicate_numbers) . "<br>";
                echo "Números duplicados: " .
                    implode(",", $duplicate_numbers) .
                    "<br><hr>";
                $numeros_ja_vendidos = array_filter($cotas_vendidas);
                $qty_numbers = $qty_numbers - 1;
                $globos = strlen($qty_numbers);
                $numeris = range(0, $qty_numbers);
                $numeris = array_map(function ($item) use (
                    $qty_numbers,
                    $globos
                ) {
                    return str_pad(
                        $item,
                        max((int) $globos, strlen($qty_numbers)),
                        "0",
                        STR_PAD_LEFT
                    );
                }, $numeris);
                $array_without_ja_vendidos = array_filter(
                    array_diff($numeris, $numeros_ja_vendidos)
                );
                shuffle($array_without_ja_vendidos);
                $find_query = $this->conn->query(
                    "SELECT id FROM order_list WHERE product_id=" .
                        $id .
                        ' AND order_numbers REGEXP \'Array\''
                );
                $orders = [];

                while ($row = $find_query->fetch_assoc()) {
                    $orders[] = $row["id"];
                }

                for ($i = 0; $i < count($orders); ++$i) {
                    $new_number = array_slice(
                        $array_without_ja_vendidos,
                        $i,
                        1
                    );
                    $oid = $orders[$i];
                    $update = $this->conn->query(
                        'UPDATE order_list SET order_numbers = REPLACE(order_numbers, \'Array\', \'' .
                            $new_number[0] .
                            '\') WHERE id = \'' .
                            $oid .
                            '\''
                    );
                }
            }

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start) / 60;
            echo "Processo realizado com sucesso.<br>";
            echo "Tempo de duração: " . $execution_time;
        }
    }

    public function correct_array()
    {
        extract($_POST);

        if ($pid) {
            $orders = $this->conn->query(
                'SELECT o.order_numbers, p.qty_numbers FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE o.product_id = \'' .
                    $pid .
                    '\''
            );
            $cotas_vendidas = [];

            while ($row = $orders->fetch_assoc()) {
                $cotas_vendidas[] = $row["order_numbers"];
                $qty_numbers = $row["qty_numbers"];
            }
            $cotas_vendidas = implode(",", $cotas_vendidas);
            $cotas_vendidas = explode(",", $cotas_vendidas);
            $cotas_vendidas = array_filter($cotas_vendidas);
            $numeros_ja_vendidos = array_filter($cotas_vendidas);
            $qty_numbers = $qty_numbers - 1;
            $globos = strlen($qty_numbers);
            $numeris = range(0, $qty_numbers);
            $numeris = array_map(function ($item) use ($qty_numbers, $globos) {
                return str_pad(
                    $item,
                    max((int) $globos, strlen($qty_numbers)),
                    "0",
                    STR_PAD_LEFT
                );
            }, $numeris);
            $array_without_ja_vendidos = array_filter(
                array_diff($numeris, $numeros_ja_vendidos)
            );
            shuffle($array_without_ja_vendidos);
            $find_query = $this->conn->query(
                'SELECT order_numbers FROM order_list WHERE product_id = \'' .
                    $pid .
                    '\' AND id = \'' .
                    $oid .
                    '\' AND order_numbers REGEXP \'Array\''
            );
            $numbers = [];

            while ($row = $find_query->fetch_assoc()) {
                $numbers[] = $row["order_numbers"];
            }

            $numbers = implode(",", $numbers);
            $numbers = explode(",", $numbers);
            $numbers = array_filter($numbers);
            $count = 0;

            foreach ($numbers as $number) {
                if ($number == "Array") {
                    $new_number = array_slice(
                        $array_without_ja_vendidos,
                        $count,
                        1
                    );
                    $update = $this->conn->query(
                        'UPDATE order_list SET order_numbers = REPLACE(order_numbers, \'Array\', \'' .
                            $new_number[0] .
                            '\') WHERE id = \'' .
                            $oid .
                            '\''
                    );
                }

                ++$count;
            }

            $resp["status"] = "success";
            return json_encode($resp);
        }
    }
    function receive_notify(){
        global $_settings;
        $this->settings = $_settings;
        $method = (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST');

        if ($method == 'GET') {
            $data = json_encode($_GET);
            if(strpos($data, 'amp;') !== false)
            {
                $data = str_replace('amp;', '', $data);
            }
            $data = json_decode($data, true);
            $id = $data['id'];
            $type = $data['topic'];
        } else {
            $data = json_encode($_POST);
            if(strpos($data, 'amp;') !== false)
            {
                $data = str_replace('amp;', '', $data);
            }
            $data = json_decode($data, true);
            $id = $data['id'];
            $type = $data['topic'];
        }
         
        
    
        $mercadopago_access_token = $_settings->info('mercadopago_access_token');
    
        function gerarLog($mensagem) {
            $log_entry = date('Y-m-d H:i:s') . ' - ' . $mensagem . PHP_EOL;
            error_log($log_entry, 3, 'log.txt'); // Use error_log para manter o log
        }
    
        gerarLog(json_encode($data));
    
        if ($type == 'payment') {
            $url = 'https://api.mercadopago.com/v1/payments/' . $id;
            $headers = ['Accept: application/json', 'Authorization: Bearer ' . $mercadopago_access_token];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resposta = curl_exec($ch);
            curl_close($ch);
    
            $payment_info = json_decode($resposta, true);
            $payment_id = $payment_info['id'];
            $status = $payment_info['status'];
            $payment_type = $payment_info['payment_type_id'];
            $uid = $payment_info['external_reference'];
            
            if ($status == 'approved') {
                gerarLog('Pagamento aprovado');
 
                $data = [
                    'external_reference' => $uid,
                    'payment_id' => $payment_id,
                ];
                
                // Converte os dados para JSON
                $jsonData = json_encode($data);
                
                // URL do endpoint
                $url = BASE_URL . 'pagamento/sucesso';
                
                // Inicializa a sessão cURL
                $curl = curl_init($url);
                
                // Configura as opções da requisição
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData)
                ]);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                // Faz a requisição e obtém a resposta
                $response = curl_exec($curl);
               
                // Verifica se houve algum erro na requisição
                if(curl_errno($curl)) {
                    echo 'Erro na requisição cURL: ' . curl_error($curl);
                }
                
                // Fecha a sessão cURL
                curl_close($curl);
                // Processa a resposta, se necessário
                var_dump($response);
                
   
                
            } elseif ($status == 'pending') {
               
                echo 'pending';
            } else {
                gerarLog('Pagamento reprovado: ' . $payment_id . ' - ' . $uid . ' - ' . $status);
            }
     gerarLog(json_encode($payment_info));

     if(
      $payment_info
     ){
        header('Location: /home');
        die();
     }
  }}




  public function load_cotas(){
  global $_settings;
  $this->settings = $_settings;
  $conn = $_settings->conn;
  
  $id = $_POST['product_id']; // Assumindo que o ID do produto é passado via GET
  $cotas_premiadas = $_POST['cotas_premiadas']; // Exemplo de cotas premiadas
  $cotas_vendidas = [];
  $cotas_array = $_POST['cotas_array']; 
  $deserialized = [];
  $pairs = explode(',', $cotas_array);
  foreach ($pairs as $pair) {
      list($key, $value) = explode(':', $pair, 2);
      $deserialized[$key] = $value;
  }
    $cotas_array = $deserialized;

   

  
  $cotas_premiadas_array = explode(',', $cotas_premiadas);
  foreach ($cotas_premiadas_array as $num) {
    if (empty($num)) {
        continue;
    }

    $stmt = $conn->prepare("SELECT customer_id FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND product_id = ?");
    $stmt->bind_param('si', $num, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($result->num_rows > 0) {
        $cotas_vendidas[] = array('cota' => $num, 'winner' => $row['customer_id']);
    }
} 
  $all_lucky_numbers = array_column($cotas_vendidas, 'cota');
  $cotas_premiadas_all = $cotas_premiadas_array;
  $cotas_premiadas_sold = array_intersect($all_lucky_numbers, $cotas_premiadas_all);

  $cotas_premiadas_available = array_diff($cotas_premiadas_all, $cotas_premiadas_sold);
  if ($min_cotas_purchased > 0) {
      $cotas_premiadas_available = $cotas_premiadas_all;
      $cotas_premiadas_sold = [];
  }
  
  ob_start();
 
  

  if ($cotas_premiadas_sold ) {
      foreach ($cotas_premiadas_sold as $cota) {
        $prize = $cotas_array[$cota];
        $winner = $cotas_vendidas[array_search($cota, $all_lucky_numbers)]['winner'];
        $customer = $conn->query("SELECT * FROM customer_list WHERE id = $winner")->fetch_assoc();
        $customer_name = $customer['firstname'];

       echo '<div class=" sc-3f9a15f1-7 reservada p-1">';


     echo '   <div style="justify-content:space-between ;display:flex; align-items:center ; padding-right:8px;">';
      echo '        <div style="display:flex; gap:12px; align-items:center">';
      echo '            <span style="background-color: #e9ecef;border-radius: 10px; color:#0f121a ; padding:6px; font-weight:500; margin-right:4px">'.$cota.'</span>';
       echo '          <span style=" font-weight:600; margin-right:4px">'.$prize.'</span>';
       echo '       </div>';
     echo '         <span>'.$customer_name.' 🏆</span>';
      echo '    </div>';


   echo '   </div>';
   echo ' <div class="hr"></div>';


          
      }
  } 
  if ($cotas_premiadas_available) {
    foreach ($cotas_premiadas_available as $cota) {
        $prize = $cotas_array[$cota];
        if ($cota != '') {
          echo '<div class=" sc-3f9a15f1-7 disponivel p-1">';


          echo '   <div style="justify-content:space-between ;display:flex; align-items:center ; padding-right:8px;">';
           echo '        <div style="display:flex; gap:12px; align-items:center">';
           echo '            <span style="background-color: #e9ecef;border-radius: 10px; color:#0f121a ; padding:6px; font-weight:500; margin-right:4px">'.$cota.'</span>';
            echo '          <span style=" font-weight:600; margin-right:4px">'.$prize.'</span>';
            echo '       </div>';
          echo '         <span>Disponível </span>';
           echo '    </div>';
     
     
        echo '   </div>';
        echo ' <div class="hr"></div>';

     
        }
    }
}
   return ob_get_clean();
}
  



    }


$Main = new Main();
$action = (!isset($_GET['action']) ? 'none' : strtolower($_GET['action']));

switch ($action) {
    case "save_product":
        echo $Main->save_product();
        break;
    case "delete_product":
        echo $Main->delete_product();
        break;
    case "add_to_card":
        echo $Main->add_to_card();
        break;
    case "place_order_process":
        echo $Main->place_order_process();
        break;
    case "correct_duplicates":
        echo $Main->correct_duplicates();
        break;
    case "verify_duplicates":
        echo $Main->verify_duplicates();
        break;
    case "verify_orders_mp":
        echo $Main->verify_orders_mp();
        break;
    case "correct_array":
        echo $Main->correct_array();
        break;
    case "delete_order":
        echo $Main->delete_order();
        break;
    case "correct_order":
        echo $Main->correct_order();
        break;
    case "correct_quantity":
        echo $Main->correct_quantity();
        break;
    case "update_order_status_sys":
        echo $Main->update_order_status();
        break;
    case "check_order":
        echo $Main->check_payment_status();
        break;
    case "check_payment_status":
        echo $Main->check_payment_status();
        break;
    case "update_whatsapp_status":
        echo $Main->update_whatsapp_status();
        break;
    case "export_raffle_contacts":
        echo $Main->export_raffle_contacts();
        break;
    case "export_order":
        echo $Main->export_raffle_contacts2();
        break;
    case "export_customers":
        echo $Main->export_customers();
        break;
    case "search_orders_by_phone":
        echo $Main->search_orders_by_phone();
        break;
    case "search_orders_by_cpf":
        echo $Main->search_orders_by_cpf();
        break;
    case "contact_send_email":
        echo $Main->contact_send_email();
        break;
    case "recover_password":
        echo $Main->recover_password();
        break;
    case "recover_password_admin":
        echo $Main->recover_password_admin();
        break;
    case "generate_password":
        echo $Main->generate_password();
        break;
    case "load_numbers":
        echo $Main->load_numbers();
        break;
    case "search_raffle_winner":
        echo $Main->search_raffle_winner();
        break;
    case "save_raffle_winner":
        echo $Main->save_raffle_winner();
        break;
    case "create_order":
        echo $Main->create_order();
        break;
    case "create_payment_affiliate":
        echo $Main->create_payment_affiliate();
        break;
    case "create_affiliate":
        echo $Main->create_affiliate();
        break;
    case "delete_affiliate":
        echo $Main->delete_affiliate();
        break;
    case "deactive_license":
        echo $Main->deactive_license();
        break;
    case "manage_draw":
        echo $Main->manage_draw();
        break;

    case "receive_notify":
        echo $Main->receive_notify();
        break;    
    case "load_cotas":
        echo $Main->load_cotas();
        break;    

        case "duplicate_product":
            echo $Main->duplicate_product();
            break;
    default:
        break;
}