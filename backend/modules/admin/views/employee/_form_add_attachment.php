<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<span>
    <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
        <div class = "form-group field-staffperviousemployer-hospital_address">
            <label class = "control-label">Attachment</label>
            <input type = "file" name = "creates[file][]">

        </div>
    </div>
    <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group field-staffperviousemployer-designation">
            <label class="control-label" for="">Attachment Name</label>
            <input class="form-control" type = "text" name = "creates[file_name][]">
        </div>
    </div>
    <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group field-staffperviousemployer-designation">
            <label class="control-label" for="">Expiry Date</label>
            <input type="date" class="form-control" name="creates[expiry_date][]">
        </div>
    </div>
    <div class = "col-md-1 col-sm-12 col-xs-12 left_padd">
        <a id="remAttach" class="btn btn-icon btn-red remAttach" style="margin-top: 27px;"><i class="fa-remove"></i></a>
    </div>


    <div style="clear:both"></div>
</span>

