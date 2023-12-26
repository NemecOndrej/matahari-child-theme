<form action="<?= home_url(); ?>" id="searchform" method="GET" class="searchform" >
	<input id="search" type="text" name="s" 
        class="form-control" 
        value="<?php echo (isset($_GET['s']) && $_GET['s'] !='' ? $_GET['s'] : '');?>" 
        placeholder="<?php _e("Hledaný výraz", THEME_TEXT_DOMAIN);?>"
    >
    <input type="hidden" name="post_type[]" value="page">
    <input type="hidden" name="post_type[]" value="posts">

    <button type="submit">
        <?php Theme::read_svg(THEME_PATH."/assets/images/search.svg");?>
        <?php _e("Hledat", THEME_TEXT_DOMAIN);?>
    </button>
</form>

