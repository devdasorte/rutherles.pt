<?php


require_once '../../config.php';
if (isset($_GET['id']) && 0 < $_GET['id']) {
	$qry = $conn->query('SELECT * from `order_list` where id = \'' . $_GET['id'] . '\' ');

	if (0 < $qry->num_rows) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}

echo '<div class="container-fluid">' . "\r\n" . '    <form action="" id="take-action-form">' . "\r\n" . '        <input type="hidden" name="id" value="';
echo (isset($id) ? $id : '');
echo '">' . "\r\n" . '        <div class="form-group">' . "\r\n" . '            <label for="status" class="control-label">Status</label>' . "\r\n" . '            <select class="form-control form-control-sm rounded-0" name="status" id="status" required="required">' . "\r\n" . '                <option value="0" ';
echo (isset($status) && $status == 0 ? 'selected' : '');
echo '>Pending</option>' . "\r\n" . '                <option value="1" ';
echo (isset($status) && $status == 1 ? 'selected' : '');
echo '>Packed</option>' . "\r\n" . '                <option value="2" ';
echo (isset($status) && $status == 2 ? 'selected' : '');
echo '>Our for Delivery</option>' . "\r\n" . '                <option value="3" ';
echo (isset($status) && $status == 3 ? 'selected' : '');
echo '>Done and Paid</option>' . "\r\n" . '            </select>' . "\r\n" . '        </div>' . "\r\n" . '    </form>' . "\r\n" . '</div>' . "\r\n" . '<script>' . "\r\n" . '    $(function(){' . "\r\n" . '        $(\'#take-action-form\').submit(function(e){' . "\r\n\t\t\t" . 'e.preventDefault();' . "\r\n" . '            var _this = $(this)' . "\r\n\t\t\t" . ' $(\'.err-msg\').remove();' . "\r\n\t\t\t" . 'start_loader();' . "\r\n\t\t\t" . '$.ajax({' . "\r\n\t\t\t\t" . 'url:_base_url_+"classes/Master.php?f=update_order_status",' . "\r\n\t\t\t\t" . 'data: new FormData($(this)[0]),' . "\r\n" . '                cache: false,' . "\r\n" . '                contentType: false,' . "\r\n" . '                processData: false,' . "\r\n" . '                method: \'POST\',' . "\r\n" . '                type: \'POST\',' . "\r\n" . '                dataType: \'json\',' . "\r\n\t\t\t\t" . 'error:err=>{' . "\r\n\t\t\t\t\t" . 'console.log(err)' . "\r\n\t\t\t\t\t" . 'alert_toast("[AO09] - An error occured",\'error\');' . "\r\n\t\t\t\t\t" . 'end_loader();' . "\r\n\t\t\t\t" . '},' . "\r\n\t\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t\t" . 'if(typeof resp ==\'object\' && resp.status == \'success\'){' . "\r\n\t\t\t\t\t\t" . 'location.reload()' . "\r\n\t\t\t\t\t" . '}else if(resp.status == \'failed\' && !!resp.msg){' . "\r\n" . '                        var el = $(\'<div>\')' . "\r\n" . '                            el.addClass("alert alert-danger err-msg").text(resp.msg)' . "\r\n" . '                            _this.prepend(el)' . "\r\n" . '                            el.show(\'slow\')' . "\r\n" . '                            $("html, body, .modal").scrollTop(0);' . "\r\n" . '                            end_loader()' . "\r\n" . '                    }else{' . "\r\n\t\t\t\t\t\t" . 'alert_toast("[AO10] - An error occured",\'error\');' . "\r\n\t\t\t\t\t\t" . 'end_loader();' . "\r\n" . '                        console.log(resp)' . "\r\n\t\t\t\t\t" . '}' . "\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '})' . "\r\n\t\t" . '})' . "\r\n" . '    })' . "\r\n" . '</script>';

?>