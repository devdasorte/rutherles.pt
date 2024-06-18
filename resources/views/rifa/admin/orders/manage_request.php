<?php

if (isset($_GET['id']) && 0 < $_GET['id']) {
    $qry = $conn->query('SELECT * from `request_list` where id = \'' . $_GET['id'] . '\' ');

    if (0 < $qry->num_rows) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}?>
  <div>
      <?php
echo '<style>' . "\r\n\t" . '#request-logo{max-width:100%;max-height:20em;object-fit:scale-down;object-position:center center}' . "\r\n" . '</style>' . "\r\n" . '<div class="content py-5 px-3 bg-gradient-dark">' . "\r\n\t" . '<h2><b>';
echo (isset($code) ? 'Update <b>' . $code . '</b> Request Detail' : 'New Request Entry');
echo '</b></h2>' . "\r\n" . '</div>' . "\r\n" . '<div class="row mt-lg-n4 mt-md-n4 justify-content-center">' . "\r\n\t" . '<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">' . "\r\n\t\t" . '<div class="card rounded-0">' . "\r\n\t\t\t" . '<div class="card-body">' . "\r\n\r\n\t\t\t\t" . '<div class="container-fluid">' . "\r\n\t\t\t\t\t" . '<form action="" id="request-form">' . "\r\n\t\t\t\t\t\t" . '<input type="hidden" name ="id" value="';
echo (isset($id) ? $id : '');
echo '">' . "\r\n\t\t\t\t\t\t" . '<div class="form-group">' . "\r\n\t\t\t\t\t\t\t" . '<label for="fullname" class="control-label">Fullname <small class="text-danger">*</small></label>' . "\r\n\t\t\t\t\t\t\t" . '<input type="text" class="form-control form-control-sm rounded-0" name="fullname" id="fullname" required="required" value="';
echo (isset($fullname) ? $fullname : '');
echo '">' . "\r\n\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t" . '<div class="form-group">' . "\r\n\t\t\t\t\t\t\t" . '<label for="contact" class="control-label">Contac # <small class="text-danger">*</small></label>' . "\r\n\t\t\t\t\t\t\t" . '<input type="text" class="form-control form-control-sm rounded-0" name="contact" id="contact" required="required" value="';
echo (isset($contact) ? $contact : '');
echo '">' . "\r\n\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t" . '<div class="form-group">' . "\r\n\t\t\t\t\t\t\t" . '<label for="message" class="control-label">Message<small class="text-danger">*</small></label>' . "\r\n\t\t\t\t\t\t\t" . '<textarea rows="3" class="form-control form-control-sm rounded-0" name="message" id="message" required="required">';
echo (isset($message) ? $message : '');
echo '</textarea>' . "\r\n\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t\t" . '<div class="form-group">' . "\r\n\t\t\t\t\t\t\t" . '<label for="location" class="control-label">Location <small class="text-danger">*</small></label>' . "\r\n\t\t\t\t\t\t\t" . '<textarea rows="3" class="form-control form-control-sm rounded-0" name="location" id="location" required="required">';
echo (isset($location) ? $location : '');
echo '</textarea>' . "\r\n\t\t\t\t\t\t" . '</div>' . "\r\n\t\t\t\t\t" . '</form>' . "\r\n\t\t\t\t" . '</div>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<div class="card-footer py-1 text-center">' . "\r\n\t\t\t\t" . '<button class="btn btn-dark btn-sm bg-gradient-dark btn-flat" form="request-form"><i class="fa fa-save"></i> Save</button>' . "\r\n\t\t\t\t" . '<a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=requests"><i class="fa fa-angle-left"></i> Cancel</a>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t" . '</div>' . "\r\n\t" . '</div>' . "\r\n" . '</div>' . "\r\n" . '<script>' . "\r\n\t" . '$(document).ready(function(){' . "\r\n\t\t\r\n\t\t" . '$(\'#request-form\').submit(function(e){' . "\r\n\t\t\t" . 'e.preventDefault();' . "\r\n" . '            var _this = $(this)' . "\r\n\t\t\t" . ' $(\'.err-msg\').remove();' . "\r\n\t\t\t" . 'start_loader();' . "\r\n\t\t\t" . '$.ajax({' . "\r\n\t\t\t\t" . 'url:_BASE_URL_+"classes/Master.php?f=save_request",' . "\r\n\t\t\t\t" . 'data: new FormData($(this)[0]),' . "\r\n" . '                cache: false,' . "\r\n" . '                contentType: false,' . "\r\n" . '                processData: false,' . "\r\n" . '                method: \'POST\',' . "\r\n" . '                type: \'POST\',' . "\r\n" . '                dataType: \'json\',' . "\r\n\t\t\t\t" . 'error:err=>{' . "\r\n\t\t\t\t\t" . 'console.log(err)' . "\r\n\t\t\t\t\t" . 'alert_toast("[AO07] - An error occured",\'error\');' . "\r\n\t\t\t\t\t" . 'end_loader();' . "\r\n\t\t\t\t" . '},' . "\r\n\t\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t\t" . 'if(typeof resp ==\'object\' && resp.status == \'success\'){' . "\r\n\t\t\t\t\t\t" . 'location.replace(\'./?page=requests/view_request&id=\'+resp.tid)' . "\r\n\t\t\t\t\t" . '}else if(resp.status == \'failed\' && !!resp.msg){' . "\r\n" . '                        var el = $(\'<div>\')' . "\r\n" . '                            el.addClass("alert alert-danger err-msg").text(resp.msg)' . "\r\n" . '                            _this.prepend(el)' . "\r\n" . '                            el.show(\'slow\')' . "\r\n" . '                            $("html, body").scrollTop(0);' . "\r\n" . '                            end_loader()' . "\r\n" . '                    }else{' . "\r\n\t\t\t\t\t\t" . 'alert_toast("[AO08] - An error occured",\'error\');' . "\r\n\t\t\t\t\t\t" . 'end_loader();' . "\r\n" . '                        console.log(resp)' . "\r\n\t\t\t\t\t" . '}' . "\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '})' . "\r\n\t\t" . '})' . "\r\n\r\n\t" . '})' . "\r\n" . '</script>';

?>
</div>