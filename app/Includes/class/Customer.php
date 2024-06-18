<?php

use Illuminate\Support\Facades\Hash;


include app_path('Includes/settings.php');
    


class Customer extends DBConnection
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

    public function save_users_system()
    {
        global $_settings;
        $this->settings = $_settings;
    
        // Handle password hashing
        if (!empty($_POST['password'])) {
            $_POST['password'] = Hash::make($_POST['password']);
        } else {
            unset($_POST['password']);
        }
    
        // Rename 'type_user_rifa' to 'type' and unset the original key
        if (isset($_POST['type_user_rifa'])) {
            $_POST['type'] = $_POST['type_user_rifa'];
            unset($_POST['type_user_rifa']);
        }
        if (empty($_POST['id'])) {
            unset($_POST['id']);
        }
        // Concatenate 'firstname' and 'lastname' into 'name'
        if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
            $_POST['name'] = $_POST['firstname'] . ' ' . $_POST['lastname'];
        }
    
        // Validate required fields
        $requiredFields = ['type', 'firstname', 'lastname', 'email', 'username'];
        if (empty($_POST['id'])) {
            $requiredFields[] = 'password';
        }
    
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return 3;
            }
        }
    
        // Sanitize user input and prepare data for SQL query
        $data = '';
        foreach ($_POST as $k => $v) {
            $v = $this->conn->real_escape_string($v);
            $data .= (empty($data) ? '' : ', ') . "`$k` = '$v'";
        }
    
        if (empty($_POST['id'])) {
            // Insert new user
            $qry = $this->conn->query("INSERT INTO users SET $data");
            if ($qry) {
                $id = $this->conn->insert_id;
                $resp["pid"] = $id;
                $resp["status"] = "success";
    
                // Update session data if current user is the one being created
                foreach ($_POST as $k => $v) {
                    if ($id == $_SESSION['userdata']['id']) {
                        $_SESSION['userdata'][$k] = $v;
                    }
                }
    
                if (!empty($_FILES["img"]["tmp_name"])) {
                    $img_path = public_path('/uploads/avatars'); // Caminho ajustado
                
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
                            $desired_width = 200;
                            $desired_height = 200;
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
                            $spath = 'uploads/avatars/' . $_FILES["img"]["name"];
                            $i = 1;
                            while (is_file(public_path($spath))) {
                                $spath = 'uploads/avatars/' . $i++ . "_" . $_FILES["img"]["name"];
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
                                $stmt = $this->conn->prepare('UPDATE users SET avatar = CONCAT(?, \'?v=\', UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) WHERE id = ?');
                                $stmt->bind_param('si', $spath, $id);
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
                return json_encode($resp);

            }
        } else {
            // Update existing user
            $id = $_POST['id'];
            $qry = $this->conn->query("UPDATE users SET $data WHERE id = $id");
            if ($qry) {
                $resp["status"] = "success";
                foreach ($_POST as $k => $v) {
                    if ($id == $_SESSION['userdata']['id']) {
                        $_SESSION['userdata'][$k] = $v;
                    }
                }
    
                $user_name = $this->settings->userdata('firstname');
                $this->conn->query("INSERT INTO logs (origin, description) VALUES ('USER', 'Usuário " . $_POST['firstname'] . " atualizado pelo usuário " . $user_name . "')");
                if (!empty($_FILES["img"]["tmp_name"])) {
                    $img_path = public_path('/uploads/avatars'); // Caminho ajustado
                
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
                            $desired_width = 200;
                            $desired_height = 200;
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
                            $spath = 'uploads/avatars/' . $_FILES["img"]["name"];
                            $i = 1;
                            while (is_file(public_path($spath))) {
                                $spath = 'uploads/avatars/' . $i++ . "_" . $_FILES["img"]["name"];
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
                                $stmt = $this->conn->prepare('UPDATE users SET avatar = CONCAT(?, \'?v=\', UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) WHERE id = ?');
                                $stmt->bind_param('si', $spath, $id);
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
                return json_encode($resp);
            }}
    
    }
    
    public function delete_users_system()
    {
        extract($_POST);

        global $_settings;
        $this->settings = $_settings;
        
        if (!$this->settings->userdata('firstname')) {
            return 2;
        }

        $usr = $this->conn->query('SELECT * FROM users WHERE id = ' . $id);

        if (0 < $usr->num_rows) {
            $row = $usr->fetch_assoc();
            $u_username = $row['username'];
            $u_firstname = $row['firstname'];
            $u_lastname = $row['lastname'];
            $u_email = $row['email'];
            $u_date_added = date('d/m/Y', strtotime($row['date_added']));
        }

        $qry = $this->conn->query('DELETE FROM users where id = ' . $id);

        if ($qry) {
            $user_name = $this->settings->userdata('firstname');
            $insert = $this->conn->query('INSERT INTO `logs` (`origin`, `description`) VALUES (\'USER\', \'Usuário ' . $u_username . ' (' . $u_firstname . ' ' . $u_lastname . ') criado em ' . $u_date_added . ' deletado pelo usuário ' . $user_name . '\')');

            if (is_file(BASE_APP . ('uploads/avatars/' . $id . '.png'))) {
                unlink(BASE_APP . ('uploads/avatars/' . $id . '.png'));
            }

            return 1;
        } else {
            return false;
        }
    }

    public function registration()
    {
        
        global $_settings;
        if (!empty($_POST['password'])) {
            $_POST['password'] = md5($_POST['password']);
        } else {
            unset($_POST['password']);
        }

        if (!empty($_POST['phone_confirm'])) {
            unset($_POST['phone_confirm']);
        }

        $_POST['phone'] = preg_replace('/[^0-9]/', '', $_POST['phone']);
        extract($_POST);
        $id = (isset($id) != '' && isset($id) != null && isset($id) > 0 ? $id : null);
        $data = '';
        
        /*
        if ($this->settings->info('enable_legal_age') == 1) {
            $year = date('Y');
            $birth = date('Y', strtotime($birth));

            if (($year - $birth) < 18) {
                $resp['status'] = 'birth_invalid';
                $resp['msg'] = 'Você precisa ser maior de 18 anos para se registrar.';
                return json_encode($resp);
            }
        }
        
        */

        $check = $this->conn->query('SELECT * FROM `customer_list` where phone = \'' . $phone . '\' ' . (0 < $id ? ' and id!=\'' . $id . '\'' : '') . ' ')->num_rows;

        if (0 < $check) {
            $resp['status'] = 'phone_already';
            $resp['msg'] = 'Esse telefone já está em uso.';
            return json_encode($resp);
        }

        if (!empty($_POST['cpf'])) {
            $cpf_validate = validaCPF($cpf);

            if (!$cpf_validate) {
                $resp['status'] = 'cpf_invalid';
                $resp['msg'] = 'Esse CPF não é válido.';
                return json_encode($resp);
            }

            $cpf = $_POST['cpf'];
            $check = $this->conn->query('SELECT * FROM `customer_list` where cpf = \'' . $cpf . '\'')->num_rows;

            if (0 < $check) {
                $resp['status'] = 'cpf_already';
                $resp['msg'] = 'Esse CPF já está em uso.';
                return json_encode($resp);
            }
        }

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            $check = $this->conn->query('SELECT * FROM `customer_list` where email = \'' . $email . '\'')->num_rows;

            if (0 < $check) {
                $resp['status'] = 'email_already';
                $resp['msg'] = 'Esse email já está em uso';
                return json_encode($resp);
            }
        }

        foreach ($_POST as $k => $v) {
            $v = $this->conn->real_escape_string($v);

            if (!empty($data)) {
                $data .= ', ';
            }

            $data .= ' `' . $k . '` = \'' . $v . '\' ';
        }
        if (empty($id)) {

            $data = str_replace('`id` = \'\' ,', '', $data);
            $sql = 'INSERT INTO `customer_list` set ' . $data . ' ';
        } else {
            $sql = 'UPDATE `customer_list` set ' . $data . ' where id = \'' . $id . '\' ';
        }

        $save = $this->conn->query($sql);

        if ($save) {
            $percentage = '10';
            
            $uid = (!empty($id) ? $id : $this->conn->insert_id);
          $status = 1;

            $user_verify = $this->conn->query(
                "SELECT id FROM referral WHERE customer_id = " . $uid
            );

            if (0 < $user_verify->num_rows) {
                $update = $this->conn->query(
                    "UPDATE referral SET percentage = " .
                        $percentage .
                        ", status = " .
                        $status .
                        ' WHERE customer_id = \'' .
                        $uid .
                        '\''
                );

                if ($update) {
                    $resp["status"] = "success";
                    $resp["msg"] = "Afiliado atualizado com sucesso";
                } else {
                    $resp["status"] = "failed";
                    $resp["msg"] = "Erro ao atualizar afiliado";
                }
            } elseif ($uid) {
                $insert = $this->conn->query(
                    "INSERT INTO referral" .
                        "\r\n\t\t\t\t\t\t\t" .
                        "(status, referral_code, percentage, amount_paid, amount_pending, customer_id)" .
                        "\r\n\t\t\t\t\t\t\t" .
                        "VALUES (" .
                        $status .
                        ", " .
                        $uid .
                        ", " .
                        $percentage .
                        ", 0, 0, " .
                        $uid .
                        ")"
                );

                if ($insert) {
                    $update = $this->conn->query(
                        "UPDATE customer_list SET is_affiliate = " .
                            $status .
                            ' WHERE id = \'' .
                            $uid .
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


            $resp['status'] = 'success';
            $resp['redirect'] = BASE_URL;
            $resp['uid'] = $uid;
           
            if (!empty($id)) {
                $resp['msg'] = 'User Details has been updated successfully';
 

            } else {
                $resp['msg'] = 'Your Account has been created successfully';
            }
            if (!empty($uid) && $_SESSION['userdata']['type_login'] != 1) {
                $user = $this->conn->query('SELECT * FROM `customer_list` where id = \'' . $uid . '\' ');

                if (0 < $user->num_rows) {
                    $res = $user->fetch_assoc();
                   

                    foreach ($res as $k => $v) {
                        
                       
                            $this->settings->set_userdata($k, $v);
                        
                        
                    }
 $_SESSION['userdata']['login_type']='2';
                    
                }
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = $this->conn->error;
            $resp['sql'] = $sql;
        }
        if (($resp['status'] == 'success') && isset($resp['msg'])) {
            if ($uid) {
                $dados = [];
                $qry = $this->conn->query('SELECT c.id, c.firstname, c.lastname, c.phone FROM `customer_list` c WHERE c.id = \'' . $uid . '\' ');
/*
                if (0 < $qry->num_rows) {
                    $row = $qry->fetch_assoc();
                    $dados['id'] = $row['id'];
                    $dados['first_name'] = $row['firstname'];
                    $dados['last_name'] = $row['lastname'];
                    $dados['phone'] = $row['phone'];
                    send_event_pixel('CompleteRegistration', $dados);
                }
                */
            }
        }

        return json_encode($resp);
    }

    public function change_password()
    {
        if (!$this->settings->userdata('id')) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Não autorizado.';
            return json_encode($resp);
        }

        global $_settings;
        $id = $_settings->userdata('id');

        if (!empty($_POST['password'])) {
            $password = md5($_POST['password']);
            $sql = 'UPDATE `customer_list` SET `password` = \'' . $password . '\' WHERE `id` = \'' . $id . '\'';
            $save = $this->conn->query($sql);
            $resp['status'] = 'success';
            $resp['msg'] = 'ok';
            return json_encode($resp);
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Id não existe';
            return json_encode($resp);
        }
    }

    public function update_customer()
    {

        global $_settings;
        $id = $_settings->userdata('id');
        if (!$id) {
            $resp['status'] = 'failed';
            return json_encode($resp);
        }

        if (!empty($_POST['password'])) {
            $_POST['password'] = md5($_POST['password']);
        } else {
            unset($_POST['password']);
        }

        $_POST['phone'] = preg_replace('/[^0-9]/', '', $_POST['phone']);
        extract($_POST);
        $data = '';

        if ($_POST['phone']) {
            $checkPhone = $this->conn->query('SELECT * FROM `customer_list` where phone = \'' . $phone . '\' ' . (0 < $id ? ' and id != \'' . $id . '\'' : '') . ' ')->num_rows;

            if (0 < $checkPhone) {
                $resp['status'] = 'phone_already';
                $resp['msg'] = 'Esse telefone já está em uso.';
                return json_encode($resp);
            }
        }

        if (!empty($_POST['email'])) {
            $checkEmail = $this->conn->query('SELECT * FROM `customer_list` where email = \'' . $email . '\' ' . (0 < $id ? ' and id != \'' . $id . '\'' : '') . ' ')->num_rows;

            if (0 < $checkEmail) {
                $resp['status'] = 'email_already';
                $resp['msg'] = 'Esse email já está em uso.';
                return json_encode($resp);
            }
        }

        if (!empty($_POST['cpf'])) {
            $cpf_validate = validaCPF($cpf);

            if (!$cpf_validate) {
                $resp['status'] = 'cpf_invalid';
                $resp['msg'] = 'Esse CPF não é válido.';
                return json_encode($resp);
            }

            $checkCPF = $this->conn->query('SELECT * FROM `customer_list` where cpf = \'' . $cpf . '\' ' . (0 < $id ? ' and id != \'' . $id . '\'' : '') . ' ')->num_rows;

            if (0 < $checkCPF) {
                $resp['status'] = 'cpf_already';
                $resp['msg'] = 'Esse CPF já está em uso.';
                return json_encode($resp);
            }
        }

        foreach ($_POST as $k => $v) {
            $v = $this->conn->real_escape_string($v);

            if (!empty($data)) {
                $data .= ', ';
            }

            $data .= ' `' . $k . '` = \'' . $v . '\' ';
        }

        if (empty($id)) {
            $sql = 'INSERT INTO `customer_list` set ' . $data . ' ';
        } else {
            $sql = 'UPDATE `customer_list` set ' . $data . ' where id = \'' . $id . '\' ';
        }

        $save = $this->conn->query($sql);

        if ($save) {
            $uid = !empty($id) ? $id : $this->conn->insert_id;
            $resp['status'] = 'success';
            $resp['uid'] = $uid;
            $resp['redirect'] = BASE_URL . 'user/atualizar-cadastro';

        
            if (!empty($id)) {
                $resp['msg'] = 'User Details has been updated successfully';
            } else {
                $resp['msg'] = 'Your Account has been created successfully';
            }
        
            if (!empty($_FILES['img']['tmp_name'])) {
                if (!is_dir(BASE_APP . 'uploads/customers')) {
                    mkdir(BASE_APP . 'uploads/customers');
                }
        
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $fname = 'uploads/customers/' . $uid . '.png';
                $accept = ['image/jpeg', 'image/png'];
        
                if (!in_array($_FILES['img']['type'], $accept)) {
                    $resp['msg'] = 'Image file type is invalid';
                    echo json_encode($resp);
                    exit;
                }
        
                if ($_FILES['img']['type'] == 'image/jpeg') {
                    $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                } else if ($_FILES['img']['type'] == 'image/png') {
                    $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
                } else {
                    $resp['msg'] = 'Unsupported image type';
                    echo json_encode($resp);
                    exit;
                }
        
                if (!$uploadfile) {
                    $resp['msg'] = 'Image is invalid';
                    echo json_encode($resp);
                    exit;
                }
        
                $temp = imagescale($uploadfile, 200, 200);
        
                if (is_file(BASE_APP . $fname)) {
                    unlink(BASE_APP . $fname);
                }
        
                $upload = imagepng($temp, BASE_APP . $fname);
        
                if ($upload) {
                    $this->conn->query('UPDATE `customer_list` set `avatar` = CONCAT(\'' . $fname . '\', \'?v=\',unix_timestamp(CURRENT_TIMESTAMP)) where id = \'' . $uid . '\'');
                } else {
                    $resp['msg'] = 'Failed to upload image';
                    echo json_encode($resp);
                    exit;
                }
        
                imagedestroy($temp);
            }
        
            if (!empty($uid) && $this->settings->userdata('login_type') != 1) {
                $user = $this->conn->query('SELECT * FROM `customer_list` where id = \'' . $uid . '\' ');
        
                if ($user->num_rows > 0) {
                    $res = $user->fetch_array();
        
                    foreach ($res as $k => $v) {
                        if (!is_numeric($k) && $k != 'password') {
                            $this->settings->set_userdata($k, $v);
                        }
                    }
        
                    $this->settings->set_userdata('login_type', '2');
                }
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = $this->conn->error;
            $resp['sql'] = $sql;
        }
        
        return json_encode($resp);
    }

    

    public function delete_customer_system()
    {
        if (!$this->settings->userdata('firstname')) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Não autorizado.';
            return json_encode($resp);
        }

        extract($_POST);
        $avatarResult = $this->conn->query('SELECT avatar FROM customer_list where id = ' . $id);
        $qry = $this->conn->query('DELETE FROM customer_list where id = ' . $id);

        if ($qry) {
            $resp['status'] = 'success';

            if (0 < $avatarResult->num_rows) {
                $avatarRow = $avatarResult->fetch_array();
                $avatar = $avatarRow[0];

                if ($avatar !== null) {
                    $avatarParts = explode('?', $avatar);
                    $avatarPath = $avatarParts[0];

                    if (is_file(BASE_APP . $avatarPath)) {
                        unlink(BASE_APP . $avatarPath);
                    }
                }
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = $this->conn->error;
        }

        return json_encode($resp);
    }

  
}

$users = new Customer();
$action = (!isset($_GET['action']) ? 'none' : strtolower($_GET['action']));

switch ($action) {
    case 'save_system':
        echo $users->save_users_system();
        break;
    case 'delete_system':
        echo $users->delete_users_system();
        break;
    case 'delete_system_customer':
        echo $users->delete_customer_system();
        break;
    case 'update_customer':
        echo $users->update_customer();
        break;
    case 'change_password_system':
        echo $users->change_password();
        break;
    case 'registration':
        echo $users->registration();
        break;
    default:
        break;
}
