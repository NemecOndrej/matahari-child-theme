<?php /*ěščřžýáíéúů*/

// create block id and classes
if ( !empty($block['anchor']) ) {
    $id = $block['anchor'];
} else {
    $id = 'XXXXX-' . $block['id'];
}
$classes = 'gt-block XXXXXXX';
$classes .= (!empty($block['className'])) ? ' '.$block['className'] : '';

// check admin preview mode (in blocks selection)
$is_preview = get_field( 'is_preview' );
if ( !isset( $is_preview ) ) {
    $is_preview = false;
}

// get data


// preview data
if ( $is_preview === true ) {
    $classes .= ' preview';
}
?>
<section id="<?php echo $id; ?>" data-id="<?php echo $id; ?>" class="<?php echo $classes; ?>">
    
</section>

<?php 
// ADMIN SPECIFIC CSS + JS
if ( is_admin() ) :
?>
<style type="text/css">
    section[data-id="<?php echo $id; ?>"]
    {
        
    }
</style>
<script type="text/javascript">
    var gtBlock = jQuery("[data-id='<?php echo $id; ?>']");
    if ( gtBlock.attr('data-background') != null ) {
        gtBlock.css('background-image', "url('" + gtBlock.attr('data-background') + "')");
    }
    gtBlock.find("[data-background]").each(function() {
        jQuery(this).css("background-image", "url('" + jQuery(this).attr("data-background") + "')");
    });

</script>
<?php endif; ?>