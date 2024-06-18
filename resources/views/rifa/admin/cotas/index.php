
<?php
include app_path('Includes/settings.php');
?>

<style>
   .number-badge {
      display: inline-block;
      width: 100%;
      box-sizing: border-box;
      text-align: center;
      margin-bottom: 10px;
    }
    
    @media (min-width: 768px) {
      .number-badge {
        width: 50%;
      }
    }
       .numdber-badge {
    padding: 3px 15px;
    font-size: 20px;
    font-weight: 100;
    width: 100%;
    margin: 2px;
    /* background-color: #28262b; */
    color: #fff;
   /* border-radius: 5px;*/
    border-top: 1px solid #fff;
   /* text-align: center;*/
   display: inline-flex;
    margin-bottom: 5px;
}

               .numdber-badge.green {
    /* background-color: #27ae60; */
    /* border-color: #27ae60; */
}

       .numbder-badge.red {
    /* background-color: #5733af; */
    /* border-color: #c0392b; */
}

                .number-badge.highlighted {
                    background-color: #f1c40f;
                    color: black;
                }

                .ganhad {
    border-radius: 11px;
    /* border: solid #8e44ad 1px; */
    display: grid;
    margin: 0px 0px 27px 0px;
    padding: 15px;
    background-color: #ecf0f1;
    /* border-top: 1px solid #8e44ad; */
    max-width: 100%;
    box-sizing: border-box;
    word-wrap: break-word;
    background-color: #28262b;
    color: #fff;
}
                .ganhad .number-badge.green span {
                    font-size: 16px;
                  /*  display: block;*/
                }
                
                .leaderboard {
  max-width: 490px;
  width: 100%;
  border-radius: 12px;
}
.leaderboard header {
  --start: 15%;
  height: 130px;
  background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(54, 89, 219, 0.33) 10%, rgba(54, 89, 219, 0.33) 17%), linear-gradient(to right, #5b7cfa, #3659db);
  color: #fff;
  position: relative;
  border-radius: 12px 12px 0 0;
  overflow: hidden;
}
.leaderboard header .leaderboard__title {
  position: absolute;
  z-index: 2;
  top: 50%;
  right: calc(var(--start) * .75);
  transform: translateY(-50%);
  text-transform: uppercase;
  margin: 0;
}
.leaderboard header .leaderboard__title span {
  display: block;
}
.leaderboard header .leaderboard__title--top {
  font-size: 24px;
  font-weight: 700;
  letter-spacing: 6.5px;
}
.leaderboard header .leaderboard__title--bottom {
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 3.55px;
  opacity: 0.65;
  transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
  fill: #fff;
  opacity: 0.35;
  width: 50px;
  position: absolute;
  top: 50%;
  left: var(--start);
  transform: translate(-50%, -50%);
}
.leaderboard__profiles {
    background-color: #fff;
    border-radius: 0 0 12px 12px;
    padding: 9px 27px 0px;
    display: grid;
    row-gap: 5px;
}
.leaderboard__profile {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    align-items: center;
    padding: 0px 8px 0px 0px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 5px 7px -1px rgb(51 51 51 / 23%);
    cursor: pointer;
    /* transition: transform 0.25s cubic-bezier(0.7, 0.98, 0.86, 0.98), box-shadow 0.25s cubic-bezier(0.7, 0.98, 0.86, 0.98); */
    background-color: #3f1681;
    /* margin: 5px; */
}
.leaderboard__profile:hover {
  /*transform: scale(1.2);
  box-shadow: 0 9px 47px 11px rgba(51, 51, 51, 0.18);*/
}
.leaderboard__picture {
  max-width: 100%;
  width: 60px;
  border-radius: 50%;
  box-shadow: 0 0 0 10px #ebeef3, 0 0 0 22px #f3f4f6;
}
.leaderboard__name {
    color: #fff;
    font-weight: 600;
    font-size: 20px;
    letter-spacing: 0.64px;
    margin-left: 12px;
    font-weight: 100;
    text-transform: uppercase;
}
.leaderboard__value {
    color: #fff;
    font-weight: 700;
    font-size: 23px;
    text-align: right;
    font-weight: 100;
}
.leaderboard__value > span {
  opacity: 0.8;
  font-weight: 600;
  font-size: 13px;
  margin-left: 3px;
}


.leaderboard {
  box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
   width: 100%; /* Defina a largura desejada para a sua div */
    margin-left: auto;
    margin-right: auto;
}
            </style>
<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);





if (!isset($_GET['id'])) {
    
    $sql = '';
?>


<form style="margin-top: 20px; background-color: #f5f5f5; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);" id="rifaForm" action="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="get">
    <input type="hidden" value="cotas" name="page">
    <label for="rifas" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">Selecione uma Rifa:</label>
    <select id="id" name="id" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; background-color: #fff; color: #333;">
        <option value="">Selecione...</option>
        <?php
        // Consulta SQL para selecionar todas as rifas
        $sql = "SELECT * FROM product_list";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
            }
        } else {
            echo "<option value=''>Nenhuma rifa encontrada.</option>";
        }
       
        ?>
    </select>
    <br><br>
    <button type="submit" style="background-color: #8e44ad; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">Ver ganhadores</button>
</form>

<?php
} else {
    if (isset($_GET['id'])) {
        // Obtém o ID da rifa da URL
        $rifa_id = $_GET['id'];

        function getCustomerDataById($customer_id)
        {
           
            // Consulta SQL para selecionar os dados do cliente pelo ID
            $sql = "SELECT * FROM customer_list WHERE id = $customer_id";
            $result = $conn->query($sql);

            // Verifica se há resultados
            if ($result->num_rows > 0) {
                // Retorna os dados do cliente
                $customerData = $result->fetch_assoc();
                return $customerData;
            } else {
                // Retorna falso se nenhum cliente for encontrado
                return false;
            }
        }

        // Constrói a consulta SQL para selecionar os detalhes da rifa com base no ID fornecido via GET
        $sql = "SELECT * FROM product_list WHERE id = $rifa_id";
    } else {
        // Se o parâmetro 'id' não estiver presente na URL, define uma consulta padrão
        $sql = "SELECT * FROM product_list WHERE id = 1";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibe o nome dos clientes que compraram cotas premiadas
        while ($row = $result->fetch_assoc()) {
            $dezenas_busca = $row["cotas_premiadas"];

            ?>
          

            <?php //echo '<h3 style="margin-top:20px; font-size:23px; font-weight:400; margin-bottom:15px; color: #8e44ad;">Cotas premiadas</h3>'; ?>
        <article class="leaderboard">
    <header>
      <h1 class="leaderboard__title">
        <span class="leaderboard__title--top">Ganhadores das </span>
        <span class="leaderboard__title--bottom">cotas premiadas</span>
      </h1>
    </header>
 <main class="leaderboard__profiles">
  
    <?php
    // Verifica se há resultados
    if (!empty($dezenas_busca)) {
      // Exibe os números das cotas premiadas
      $numbers = explode(',', $dezenas_busca);
      foreach ($numbers as $number) {
        // Consulta SQL para verificar se alguém comprou esta cota
        $sql_comprador = "SELECT * FROM order_list WHERE FIND_IN_SET('$number', order_numbers) and product_id=$rifa_id and status=2";
        $result_comprador = $conn->query($sql_comprador);

        $class = 'number-badge';
        if ($result_comprador && $result_comprador->num_rows > 0) {
          $class .= ' green';
        } else {
          $class .= ' red';
        }
       // echo '<div class="' . $class . '">';
       
       
        // Exibe o nome do comprador, se houver
      if ($result_comprador && $result_comprador->num_rows > 0) {
        $row_comprador = $result_comprador->fetch_assoc();
      
      
       
        $customerData = getCustomerDataById($row_comprador['customer_id']);
            $cli =  $customerData['firstname'] . ' ' . $customerData['lastname'];
           echo $cli;
          
      }else{
                
                $cli = '*********';
            }
    ?>

   
      <article class="leaderboard__profile">
        <img src="https://ui-avatars.com/api/?background=2f362d&color=fff&name=<?=$cli?>" alt="Mark Zuckerberg" class="leaderboard__picture">
        <span class="leaderboard__name"><?=$cli?></span>
        <span class="leaderboard__value"><?=$number?></span>
      </article>
   

    <?php 
     

    }
      echo ' </main></article>';
   
    } else {
      echo "Nenhuma cota premiada encontrada para esta rifa.";
    } 
    ?>
 

<?php
        }
    }
}
?>
