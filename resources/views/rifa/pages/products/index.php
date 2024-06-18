<?php


echo '<style>' . "\r\n" . '    .product-img-holder{width:100%;height:15em;overflow:hidden}.product-img{width:100%;height:100%;object-fit:cover;object-position:center center;transition:.3s ease-in-out}.product-item:hover .product-img{transform:scale(1.2)}' . "\r\n" . '</style>' . "\r\n";
$page_title = 'Our Available Products';
$page_description = '';
if (isset($_GET['cid']) && is_numeric($_GET['cid'])) {
	$category_qry = $conn->query('SELECT * FROM `category_list` where `id` = \'' . $_GET['cid'] . '\' and `status` = 1 and `delete_flag` = 0');

	if (0 < $category_qry->num_rows) {
		$cat_result = $category_qry->fetch_assoc();
		$page_title = $cat_result['name'];
		$page_description = $cat_result['description'];
	}
}

echo '<section class="py-3">' . "\r\n\t" . '<div class="container">' . "\r\n\t\t" . '<div class="content bg-gradient-dark py-5 px-3">' . "\r\n\t\t\t" . '<h4 class="">';
echo $page_title;
echo '</h4>' . "\r\n" . '            ';

if (!empty($page_description)) {
	echo '                <hr>' . "\r\n" . '                <p class="m-0"><small><em>';
	echo html_entity_decode($page_description);
	echo '</em></small></p>' . "\r\n" . '            ';
}

echo "\t\t" . '</div>' . "\r\n\t\t" . '<div class="row mt-n3 justify-content-center">' . "\r\n" . '            <div class="col-lg-10 col-md-11 col-sm-11 col-sm-11">' . "\r\n" . '                <div class="card card-outline rounded-0">' . "\r\n" . '                    <div class="card-body">' . "\r\n" . '                        <div class="row row-cols-xl-4 row-md-6 col-sm-12 col-xs-12 gy-2 gx-2">' . "\r\n" . '                            ';
$cat_where = '';

if (isset($cat_result['id'])) {
	$cat_where = ' and `category_id` = \'' . $cat_result['id'] . '\' ';
}

$qry = $conn->query('SELECT *, (COALESCE((SELECT SUM(quantity) FROM `stock_list` where product_id = product_list.id ), 0) - COALESCE((SELECT SUM(quantity) FROM `order_items` where product_id = product_list.id), 0)) as `available` FROM `product_list` where (COALESCE((SELECT SUM(quantity) FROM `stock_list` where product_id = product_list.id ), 0) - COALESCE((SELECT SUM(quantity) FROM `order_items` where product_id = product_list.id), 0)) > 0 ' . $cat_where . ' order by RAND()');

while ($row = $qry->fetch_assoc()) {
	echo '                            <div class="col">' . "\r\n" . '                                <a class="card rounded-0 shadow product-item text-decoration-none text-reset h-100" href="./?p=products/view_product&id=';
	echo $row['id'];
	echo '">' . "\r\n" . '                                    <div class="position-relative">' . "\r\n" . '                                        <div class="img-top position-relative product-img-holder">' . "\r\n" . '                                            <img src="';
	echo validate_image($row['image_path']);
	echo '" alt="" class="product-img">' . "\r\n" . '                                        </div>' . "\r\n" . '                                        <div class="position-absolute bottom-1 right-1" style="bottom:.5em;right:.5em">' . "\r\n" . '                                            <span class="badge badge-light bg-gradient-light border text-dark px-4 rounded-pill">';
	echo format_num($row['price'], 2);
	echo '</span>' . "\r\n" . '                                        </div>' . "\r\n" . '                                    </div>' . "\r\n" . '                                    <div class="card-body">' . "\r\n" . '                                        <div style="line-height:1em">' . "\r\n" . '                                            <div class="card-title w-100 mb-0">';
	echo $row['name'];
	echo '</div>' . "\r\n" . '                                            <div class="d-flex justify-content-between w-100 mb-3">' . "\r\n" . '                                                <div class=""><small class="text-muted">';
	echo $row['brand'];
	echo '</small></div>' . "\r\n" . '                                                <div class=""><small class="text-muted">Stock: ';
	echo format_num($row['available'], 0);
	echo '</small></div>' . "\r\n" . '                                            </div>' . "\r\n" . '                                            <div class="card-description truncate text-muted">';
	echo html_entity_decode($row['description']);
	echo '</div>' . "\r\n" . '                                        </div>' . "\r\n" . '                                    </div>' . "\r\n" . '                                </a>' . "\r\n" . '                            </div>' . "\r\n" . '                            ';
}

echo '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>' . "\r\n\t\t" . '</div>' . "\r\n\t" . '</div>' . "\r\n" . '</section>';

?>