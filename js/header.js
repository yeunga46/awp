$().ready(function () {
    
    $('#searchbar_dropdown').hide();
    //variables used in registering
    var passwordsMatch = false;
    var userExist = false;
    var emailExist = false;

    $('#searchbar').on('change keyup paste', function () {
        $.ajax({
            url: 'database/search.php',
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
                    let currentPhotoURL = './photo/' + data[1][i].photo_id;
                    let currentPhotoOption = $('<option>' + data[1][i].title + ' by ' + data[1][i].uploader + '</option>').val(currentPhotoURL);
                    $('#searchbar_dropdown').append(currentPhotoOption);
                }
            }
        });
    });
    $('#searchbar_dropdown').on('change', function() {
        window.location.href = $('#searchbar_dropdown option:selected').val();
    });

    $('#input_email').on('change keyup paste', function(e) {
        $.ajax({
            url: 'database/checker.php',
            type: 'GET',
            data: {check: 'emailExist', 'email': $('#input_email').val() },
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    emailExist = true;
                    $('#form-register p').remove();
                    $('#input_email').css({
                        "border-color": "#FF0000",
                        "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)"
                    });
                    var error = $('<p>The email you entered has already been used.</p>').css('color', 'red');
                    $('#form-register').append(error);
                }
                else
                {
                    $('#form-register p').remove();
                    $('#input_email').removeAttr('style');
                    emailExist = false;
                }
            }
        });

    });

    $('#btn_login').on('click', function () {
        $.ajax({
            url: 'database/login.php',
            type: 'POST',
            data: $('#form_login').serialize(),
            success: function (response) {
                if ($.trim(response) === "invalid") {
                    $('#form_login').trigger("reset");
                    alert('Invalid username or password.');
                    
                } else {
                    location.reload();
                }
            }
        });
    });

    $('#input_username').on('change keyup paste', function(e) {
        $.ajax({
            url: 'database/checker.php',
            type: 'GET',
            data: {check: 'userExist', 'username': $('#input_username').val() },
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    $('#form-register p').remove();
                    $('#input_username').css({
                        "border-color": "#FF0000",
                        "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)"
                    });
                    var error = $('<p>This username is currently in use.</p>').css('color', 'red');
                    $('#form-register').append(error);
                    userExist = true;
                }
                else
                {
                    $('#form-register p').remove();
                    userExist = false;
                    $('#input_username').removeAttr('style');
                }
            }
        });

    });

    $('.password_input').on('change keyup paste', function() {
        //set to clear if fields are empty
        if($('#input_confirm_pword').val() !== "" && ($('#input_confirm_pword').val() === $('#input_pword').val()))
        {
            $('#form-register p').remove();
            $('#input_confirm_pword').css({
                "border-color": "#00ff00",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 255, 0, 0.6)"
            });
            $('#input_pword').css({
                "border-color": "#00ff00",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 255, 0, 0.6)"
            });
            passwordsMatch = true;
            
        }
        else if($('#input_pword').val() === "" || $('#input_confirm_pword').val() === ""){
            $('#form-register p').remove();
            $('#input_confirm_pword').removeAttr('style');
            $('#input_pword').removeAttr('style');
            passwordsMatch = false;
        }
        else
        {
            $('#form-register p').remove();
            $('#input_confirm_pword').css({
                "border-color": "#FF0000",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)"
            });
            $('#input_pword').removeAttr('style');

            var error = $('<p>Passwords should match.</p>').css('color', 'red');
            $('#form-register').append(error);
            passwordsMatch = false;
        }
    });

    $('#form-register').on('submit', function (e) {
        if(!($('#input_username').val() === "" || $('#input_email').val() === "" 
        || $('#input_pword').val() === "" || $('#input_confirm_pword').val() === ""))
        {
            if(!passwordsMatch || userExist || emailExist)
            {
                e.preventDefault();
            }
            if(!verifyEmail($('#input_email').val()))
            {
                alert("The email you entered was invalid; please try again.");
                e.preventDefault();
            }
        }
        else
        {
            alert("You left one or more fields empty. Please fill out the entire form and try again.");
            e.preventDefault();
        }

    });
});