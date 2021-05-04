$(document).ready(function (){


    $('#signIN').click(function (){
        email = $('#EmailInput').val();
        pw = $('#PasswordInput').val();
        remember = $('#remember').prop('checked');

        $.post('ajax/Login.php',{
            email: email,
            pw: pw,
            check: remember
        }, function (data, status){
            console.log(data);
            response = JSON.parse(data);
            console.log(response);
            if(response['status'] == "true")
            {
                if(response['LE']=='Login')
                {
                    $('#LoginForm').submit();
                }
                else
                {
                    $('#errorL').show();
                    $('#errorL').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                        '                <strong>Failed</strong> Failed Logg in\n' +
                        '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                        '            </div>');
                    $('#errorL .alert').delay(1000).show('slow');
                }
            }
            else
            {
                if(response['EE'] != "" && response['PE']=="")
                {
                    $('#EmailInputE').html(response['EE'] );
                    $('#EmailInput').addClass('is-invalid');
                    $('#PasswordInput').addClass('is-invalid');
                }
                else if(response['PE'] !="" &&response['EE'] == "" )
                {
                    $('#PasswordInputE').html(response['PE'] );
                    $('#EmailInput').addClass('is-invalid');
                    $('#PasswordInput').addClass('is-invalid');
                }
            }

        });

    });


});