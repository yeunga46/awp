$().ready(function () {

    $('#searchbar_dropdown').hide();
    $('#searchbar').on('change keyup paste', function () {
        console.log($('#form_search').serialize());
        $.ajax({
            url: './search.php',
            type: 'GET',
            data: $('#form_search').serialize(),
            success: function (response) {
                let data = $.parseJSON($.trim(response));

                //https://stackoverflow.com/questions/158070/how-to-position-one-element-relative-to-another-with-jquery
                let pos = $('#searchbar').position();
                let height = $('#searchbar').outerHeight();
                let width = $('#searchbar').outerWidth();
                $('#searchbar_dropdown').css({
                    position: "absolute",
                    top: height + "px",
                    left: (pos.left) + "px",
                    width: width + "px",
                }).show();

                $('#searchbar_dropdown').children('option').remove();



                //0 - accounts
                for(i = 0; i < data[0].length; i++)
                {
                    let currentUserURL = './u/' + data[0][i].username;
                    let currentUserOption = $('<option>' + data[0][i].username + '</option>').val(currentUserURL);
                    $('#searchbar_dropdown').append(currentUserOption);
                }
                //1 - pictures
                for(i = 0; i < data[1].length; i++)
                {
                    let currentPhotoURL = './photo.php?pid=' + data[1][i].photo_id;
                    let currentPhotoOption = $('<option>' + data[1][i].title + ' by ' + data[1][i].uploader + '</option>').val(currentPhotoURL);
                    $('#searchbar_dropdown').append(currentPhotoOption);
                }
            }
        });
    });
    $('#searchbar_dropdown').on('change', function() {
        window.location.href = $('#searchbar_dropdown option:selected').val();
    });
    $('#btn_login').on('click', function () {
        $.ajax({
            url: './login.php',
            type: 'POST',
            data: $('#form_login').serialize(),
            success: function (response) {
                //need to trim because otherwise there's extra whitespace and the string won't compare properly
                if ($.trim(response) === "invalid") {
                    $('#form_login').trigger("reset");
                    alert('Invalid username or password');
                    //I'll change this to a tooltip later for extra eye-candy
                } else {
                    //refreshes the page to get the new session variables
                    location.reload();
                }
            }
        });
    });
    $('#form-register').on('submit', function (e) {
        //broken for some reason... it worked once but never again
        $('#form-register input').blur(function() {
            console.log($.trim(this.value).length);
            if(!$.trim(this.value).length) { // zero-length string AFTER a trim
                   e.preventDefault();
            }
       });
    });
});