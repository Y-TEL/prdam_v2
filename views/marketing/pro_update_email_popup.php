<script>	
jQuery(document).ready(function () {
    jQuery('#popModal').on('show.bs.modal', function(e) {
        jQuery('.modal-backdrop').fadeIn(150);
        var pro_id = jQuery(e.relatedTarget).data('item-id');
        
        jQuery(".modal-body").append('<input type="hidden" name="pro_id" value="'+pro_id+'">');
        
    });

    jQuery("#add_note").validate({
        rules:
                {
                    email_to: "required",
                },
        messages:
                {
                    email_to: "required",
                },
    });	

});
</script>

<div class="modal" id="popModal" role="dialog" aria-labelledby="basicModal" style="display:none; ">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <form class="contact" action="" id="add_note" name="contact" method="post">
            <div class="modal-header">
                    <div class="single-head center">
                            <div class="caption">
                                    <li class="fa fa-envelope"> </li> Send Mail
                            </div>
                    </div>
            </div>
            <div class="modal-body">

                    <div id="amountdiv">
                        <h4 class="help-block"> To : </h4>
                        <input type="email" name="email_to" id="email_to" class="form-control" value=""/>	
                    </div>
                    <div id="amountdiv">
                        <h4 class="help-block"> CC : </h4>
                        <input type="text" name="email_cc" id="email_cc" class="form-control" value=""/>	
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <!-- <input class="btn btn-primary pull-left" type="submit" value="Save changes" id="submit">-->
                <button class="btn btn-primary pull-left" id="submit" name="email_submit">Submit</button>
            </div>
        </form>    
    </div>
</div>
</div>