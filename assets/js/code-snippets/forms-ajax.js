/*ěščřžýáíéúů*/

/* DEFINE THIS GLOBALLY IN HTML:
<script type="text/javascript">
    var formServicesDirectory = THEME_URI + '/services/';
    var formErrorMessage = "<?php _e("Před odesláním prosím doplňte/opravte data ve formuláři.", THEME_TEXT_DOMAIN); ?>\n";
    var gdprError = "<?php _e("Před odesláním musíte souhlasit se zpracováním osobních údajů.", THEME_TEXT_DOMAIN); ?>";
</script>
 */

function initForms()
{
    /// <summary>
    /// Init AJAX sending of forms.
    /// </summary>

    var afterSendFunction = function ()
    {

    };

    // CONTACT FORM
    $(".gt-block.contactForm a.sendBtn").unbind("click");
    $(".gt-block.contactForm a.sendBtn").bind("click", function(e) {
        e.preventDefault();

        sendForm($(".gt-block.contactForm form"), "send-contact.php", afterSendFunction);

        return false;
    });
}

function sendForm($form, service, afterSendMethod)
{
    /// <summary>
    /// Send e-mail form.
    /// </summary>
    /// <param name="$form" type="object">jQuery object of the form.</param>
    /// <param name="service" type="string">PHP file name of the service.</param>
    /// <param name="afterSendMethod" type="function">Method to execute after sending.</param>

    var hasError = false;

    $form.find(".input").removeClass("hasErrorEmpty").removeClass("hasErrorFormat");

    // required
    $form.find("input[data-required='1'],textarea[data-required='1'],select[data-required='1']").each(function ()
    {
        if ($(this).val().length == 0)
        {
            hasError = true;
            $(this).closest(".input").addClass("hasErrorEmpty");
        }
    });

    // radios
    $form.find("input[type='radio']").each(function ()
    {
        if ($(this).attr("data-required") == "1")
        {
            if ($("input[name='" + $(this).attr("name") + "']:checked").length == 0)
            {
                hasError = true;
                $(this).closest(".input").addClass("hasErrorEmpty");
            }
        }
    });

    // email
    $form.find("input[data-format='email']").each(function ()
    {
        if ($(this).val().length > 0)
        {
            if (!validateEmail($(this).val()))
            {
                hasError = true;
                $(this).closest(".input").addClass("hasErrorFormat");
            }
        }
    });

    // phone
    $form.find("input[data-format='phone']").each(function ()
    {
        if ($(this).val().length > 0)
        {
            if (!validatePhone($(this).val()))
            {
                hasError = true;
                $(this).closest(".input").addClass("hasErrorFormat");
            }
        }
    });

    // GDPR
    if (!$form.find("input[type='checkbox']").is(":checked"))
    {
        alert(gdprError);
        return false;
    }

    if (hasError)
    {
        alert(formErrorMessage);
    }
    else
    {
        // send form by AJAX
        $form.addClass("loading");
        var options = {
            url: formServicesDirectory + service,
            type: "POST",
            dataType: "text",
            success: function (data, textStatus, jqXHR)
            {
                $form.find("input,textarea,select").val("");

                $form.find("div.inputs").addClass("hidden");
                $form.find("div.sent").removeClass("hidden");
                $form.removeClass("loading");

                if (afterSendMethod != null)
                {
                    afterSendMethod(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("ERROR");
                $form.removeClass("loading");
            }
        };
        if ($form.is("form"))
        {
            $form.ajaxSubmit(options);
        }
        else
        {
            $form.find("form").ajaxSubmit(options);
        }
    }
}

function validateEmail(email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone)
{
    //var re = /^(\+420)? ?[1-9][0-9]{2} ?[0-9]{3} ?[0-9]{3}$/;
    var re = /^(\+[0-9]{1,3})?( )?[0-9]{3}( )?[0-9]{3}( )?[0-9]{3}$/;
    return re.test(phone);
}