<?php /*ěščřžýáíéúů*/

?>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" enctype="multipart/form-data">
    <input type="hidden" name="url" value="<?php echo Theme::get_current_url(); ?>" />

    <div class="inputs">

        <div class="input">
            <label for="<?php echo $id; ?>_contact_name"><?php _e("Vaše jméno:", THEME_TEXT_DOMAIN); ?></label>
            <input type="text" id="<?php echo $id; ?>_contact_name" name="contact_name" placeholder="<?php _e("Zde napište vaše jméno", THEME_TEXT_DOMAIN); ?>" data-required="1" />
            <span class="errorEmpty"><?php _e("Vaše jméno je povinné.", THEME_TEXT_DOMAIN); ?></span>
        </div><!-- /.input -->

        <div class="input">
            <label for="<?php echo $id; ?>_contact_email"><?php _e("Váš email:", THEME_TEXT_DOMAIN); ?></label>
            <input type="text" id="<?php echo $id; ?>_contact_email" name="contact_email" placeholder="@" data-format="email" data-required="1" />
            <span class="errorEmpty"><?php _e("Váš e-mail je povinný.", THEME_TEXT_DOMAIN); ?></span>
            <span class="errorFormat"><?php _e("E-mail má neplatný formát.", THEME_TEXT_DOMAIN); ?></span>
        </div><!-- /.input -->

        <div class="input textarea">
            <label for="<?php echo $id; ?>_contact_message"><?php _e("Vaše zpráva:", THEME_TEXT_DOMAIN); ?></label>
            <textarea id="<?php echo $id; ?>_contact_message" name="contact_message" placeholder="<?php _e("Zde začněte psát vaši zprávu", THEME_TEXT_DOMAIN); ?>" data-required="0"></textarea>
            <span class="errorEmpty"><?php _e("Vaše zpráva je povinná.", THEME_TEXT_DOMAIN); ?></span>
        </div><!-- /.input -->

        <span class="clear"></span>

        <div class="bottom">
            <label for="<?php echo $id; ?>_gdpr" class="checkbox">
                <input type="checkbox" id="<?php echo $id; ?>_gdpr" name="contact_gdpr" />
                <?php _e("Souhlasím se zpracováním osobních údajů.", THEME_TEXT_DOMAIN); ?> <a href="<?php echo get_permalink(get_field("pageid_privacypolicy", "option")); ?>" target="_blank"><?php _e("Více zde.", THEME_TEXT_DOMAIN); ?></a>
            </label>
            <a href="#" class="btn sendBtn"><?php _e("Odeslat", THEME_TEXT_DOMAIN); ?></a>
        </div>

    </div><!-- /.inputs -->
    <div class="sent hidden">
        <p class="iconOk"><?php echo $form["senttext"]; ?></p>
    </div><!-- /.sent -->
</form>