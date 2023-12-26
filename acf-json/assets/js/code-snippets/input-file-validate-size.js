/*ěščřžýáíéúů*/

$("form input[type='file']").change(function() {
    // validate file size
    if (this.files != null && this.files.length > 0 && this.files[0].size != null)
    {
        var fileSize = this.files[0].size;
        fileSize /= 1024; // KB
        fileSize /= 1024; // MB
        if (fileSize > 5)
        {
            alert("Maximální povolená velikost souboru je 5 MB.");
            $("form .uploadfile a").click();
            return;
        }
    }

    // get only filename
    if (file.indexOf("\\") > 0)
    {
        file = file.substr(file.lastIndexOf("\\") + 1);
    }
});