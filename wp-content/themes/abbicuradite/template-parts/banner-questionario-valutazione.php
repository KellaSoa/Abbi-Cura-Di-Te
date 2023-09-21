<?php $field= get_queried_object();?>
<div class="popup-bloc-test shadow-lg w-75">
    <div class="content">
        <div class="row">
            <div class="col-2 ">
                <div class="exclamation rounded-end text-center text-white">!</div>
            </div>
            <div class="col-10 description">
                <h2><?php echo get_field("titolo_valutazione",$field); ?></h2>
                <h5 class="mb-3"><?php echo get_field("descrizione_valutazione",$field); ?></h5>
                <a class="btn-yellow" href="<?php if(is_user_logged_in()){echo site_url('/valutazione/questionario');}else{echo site_url('/login');} ?>"><?php echo get_field("button_valutazione",$field); ?></a>
            </div>
        </div>
    </div>

</div>