<div>
<style>
	.cards {
  position: relative;
  height: 90px;
  transition-duration: 0.5s;
  background: none;
  overflow: hidden;
}

.cards:hover {
  height: 180px;
}

.cards:hover .outlinePage {
  box-shadow: 0 10px 15px #b1985e;
}

.cards:hover .detailPage {
  display: flex;
}



.outlinePage1 {
  position: relative;
  background: #0f121a;
  height: 90px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;
}
.outlinePage2 {
  position: relative;
  background: #0f121a;
  height: 90px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;
}
.outlinePage3{
  position: relative;
  background: #0f121a;
  height: 90px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;
}
.outlinePage4{
  position: relative;
  background: #0f121a;
  height: 90px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;
}.outlinePage5{
  position: relative;
  background: #0f121a;
  height: 90px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;
}
.detailPage {
  position: relative;
  display: none;
  background: white;
  top: -20px;
  z-index: 1;
  transition-duration: 1s;
  border-radius: 0 0 25px 25px;
  overflow: hidden;
  align-items: center;
  justify-content: flex-start;
}

.splitLine1 {
opacity: 0.6;
	position: absolute;
  height: 10px;
  width: 100%;
  top: 45px;
  background-image: linear-gradient(
    to right,
    transparent 10%,
    #ffe8a0 35%,
    #f7b733 50%,
    #0f121a 80%,
    transparent 90%
  );
  z-index: 1;
}
.splitLine2 {
opacity: 0.6;
	position: absolute;
  height: 10px;
  width: 100%;
  top: 45px;
  background-image: linear-gradient(
    to right,
    transparent 10%,
    #e9e9e9 35%,
    #c0c0c0 50%,
    #0f121a 80%,
    transparent 90%
  );
  z-index: 1;
}
.splitLine3 {
opacity: 0.6;
	position: absolute;
  height: 10px;
  width: 100%;
  top: 45px;
  background-image: linear-gradient(
    to right,
    transparent 10%,
    #dda16f 35%,
    #cd7f3d 50%,
    #0f121a 80%,
    transparent 90%
  );
  z-index: 1;
}
.splitLine4 {
opacity: 0.6;
	position: absolute;
  height: 10px;
  width: 100%;
  top: 45px;
  background-image: linear-gradient(
    to right,
    transparent 10%,
    #fff 35%,
    #fcfcfc 50%,
    #0f121a 80%,
    transparent 90%
  );
  z-index: 1;
}
.splitLine5 {
opacity: 0.6;
	position: absolute;
  height: 10px;
  width: 100%;
  top: 45px;
  background-image: linear-gradient(
    to right,
    transparent 10%,
    #fff 35%,
    #fcfcfc 50%,
    #0f121a 80%,
    transparent 90%
  );
  z-index: 1;
}

.trophy {
  position: absolute;
  right: 8px;
  top: -4px;
  z-index: 2;
  font-size: 60px;
}

.ranking_number1 {
  position: relative;
  color: #ffc64b;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 35px;
  left: 20px;
  padding: 0;
  margin: 0;
  top: -5px;
}
.ranking_number2 {
  position: relative;
  color: #c0c0c0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 35px;
  left: 20px;
  padding: 0;
  margin: 0;
  top: -5px;
}
.ranking_number3 {
  position: relative;
  color: #cd7f3d;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 35px;
  left: 20px;
  padding: 0;
  margin: 0;
  top: -5px;
}
.ranking_number4{
  position: relative;
  color: #fff;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 35px;
  left: 20px;
  padding: 0;
  margin: 0;
  top: -5px;
}
.ranking_number5 {
  position: relative;
  color: #fff;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 35px;
  left: 20px;
  padding: 0;
  margin: 0;
  top: -5px;
}
.ranking_word {
  position: relative;
  font-size: 16px;
}

.userAvatar {
  position: absolute;
  bottom: 8px;
  left: 30px;
  font-size: 14px;
}

.userName {
  position: absolute;
  font-weight: 500;
  left: 55px;
  font-size: 14px;
  margin-bottom: 0;
  bottom:8px
}

.medals {
  position: absolute;
  top: 15px;
  right: 5px;
  font-size: 50px;
}

.gradesBox {
  position: relative;
  top: 10px;
  margin-right: 10px;
  margin-left: 15px;
}

.gradesIcon {
  position: absolute;
  top: 10px;
}

.gradesBoxLabel {
  position: relative;
  display: block;
  color: #424c50;
  letter-spacing: 2px;
  margin-top: 20px;
  font-weight: 800;
  font-size: 16px;
}

.gradesBoxNum {
  position: relative;
  font-family: Arial, Helvetica, sans-serif;
  display: block;
  font-size: 18px;
  font-weight: 800;
  margin-left: 20px;
  color: #ea9518;
  top: -5px;
}

.timeNum {
  color: #6cabf6;
}

.slide-in-top {
  animation: slide-in-top 1s cubic-bezier(0.65, 0.05, 0.36, 1) both;
}

@keyframes slide-in-top {
  0% {
    transform: translateY(-100px);
    opacity: 0;
  }

  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

</style>
	<?php

	
	if ($id) {
		$qry = $conn->query('SELECT * from `product_list` where slug = \'' . $id . '\' ');

		if (0 < $qry->num_rows) {
			foreach ($qry->fetch_assoc() as $k => $v) {
				$$k = $v;
			}
		} else {
			echo '<script>' . "\r\n" . '            //alert(\'Você não tem permissão para acessar essa página.\'); ' . "\r\n" . '            location.replace(\'' . BASE_URL . '\');' . "\r\n" . '          </script>';
			exit();
		}
	} else {
		echo '<script>' . "\r\n" . '          //alert(\'Você não tem permissão para acessar essa página.\');' . "\r\n" . '          location.replace(\'' . BASE_URL . '\');' . "\r\n" . '        </script>';
		exit();
	}

	$totalNumbers = $paid_numbers + $pending_numbers;
	$percentage = ($totalNumbers / $qty_numbers) * 100;
	if ((85 <= $percentage) && $status == 1 && $status_display != 2) {
		$updateStatusStatements = $conn->query('UPDATE product_list SET status_display = \'2\' WHERE id = \'' . $id . '\'');
	}

	if ($date_of_draw) {
		$expirationTime = date('Y-m-d H:i:s', strtotime($date_of_draw));
		$currentDateTime = date('Y-m-d H:i:s');

		if ($expirationTime < $currentDateTime) {
			$selectStatement = 'SELECT * FROM product_list WHERE id = \'' . $id . '\'';
			$selectResult = $conn->query($selectStatement);

			if (0 < $selectResult->num_rows) {
				$updatePendingStatements = $conn->query('UPDATE product_list SET status = \'3\', status_display = \'4\' WHERE id = \'' . $id . '\'');
			}
		}
	}

	if ($type_of_draw == '1') {
		require_once 'automatic.php';
	}

	if ($type_of_draw == '2') {
		require_once 'numbers.php';
	}

	if ($type_of_draw == '3') {
		require_once 'farm.php';
	}

	if ($type_of_draw == '4') {
		require_once 'half-farm.php';
	}
	?>
	
	</div>