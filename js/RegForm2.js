$(document).ready(function (){
    var currentTab = 0 ;


    showTab(currentTab);



    $('#noEmail').click(function (){
        $('#LoginModal').modal('hide');
        $('#RegModal').modal('show');
    });

    $('#AlreadyHaveEmail').click(function (){
        $('#RegModal').modal('hide');
        $('#LoginModal').modal('show');
    })

    function fixStepIndicator(n) // A function that help us to upgrade the progressBar
    {
        if(n === 0)
        {
            $('.progressbar li').eq(0).attr('class','active');
            $('.progressbar li').eq(1).removeClass('active');
            $('.progressbar li').eq(2).removeClass('active');

        }else if (n === 1)
        {


            $('.progressbar li').eq(n).attr('class','active');
            $('.progressbar li').eq(2).removeClass('active');


        }else
        {
            $('.progressbar li').eq(n).attr('class','active');
        }
    }

    function showTab(n) // To show the current tab we are in in the register form.
    {

        let x = $('.tab')
        x.eq(n).animate({
            display:'block',
            height:"show"
        },500,'linear');

        if(n === 0)
        {
            $('#prev').hide();
            $('#regFooter').hide();
            $('#next').show();

        }
        else
        {
            $('#next').show();
            $('#regFooter').hide();
            $('#prev').show();
        }

        if (n === x.length - 1 )
        {


            $('#next').hide();
            $('#regFooter').show()


        }


        fixStepIndicator(n);
    }


    $('#prev').click(function (){
        prev();
    });



    $('#next ').click(function (){
        next(null);

    });


    function prev() //for the animation of button prev
    {

        let x = $(".tab");
        x.eq(currentTab).animate({
            height: "hide",
            display: 'none'
        },500,'linear');

        currentTab -= 1;
        showTab(currentTab);
    }

    function next(submit) // for the animation of button next and the validation
    {
        let x = $(".tab");
        let firstName = $("#inputFname").val();
        let lastName = $("#inputLname").val();
        let email = $("#inputEmail").val();
        let pw = $("#inputPassword").val();
        let pwC = $("#inputCPassword").val();
        let mobile = $("#inputMobile").val();
        let city = $("#inputCity").val();


        $.post("ajax/validation_register.php",
            {
                firstName: firstName,
                lastName: lastName,
                email: email,
                pw: pw,
                pwC: pwC,
                mobile: mobile,
                city: city,
                currentTab: currentTab,
                submit : submit
            }, function (data , status){
                // console.log(data);
                response = JSON.parse(data);

                if(currentTab === 0)
                {
                    if (response['status'])
                    {
                        $("#inputFname").addClass('is-valid').removeClass('is-invalid');
                        $('#inputFnameE').html(response['FNE']);

                        $("#inputLname").addClass('is-valid').removeClass('is-invalid');
                        $('#inputLnameE').html(response['LNE']);

                        x.eq(currentTab).animate({
                            height: "hide",
                            display:'none'
                        },500,'linear');
                        currentTab += 1;
                        showTab(currentTab);
                    }
                    else
                    {
                        if(response['FNE'] === "")
                        {
                            $("#inputFname").addClass('is-valid').removeClass('is-invalid');
                            $('#inputFnameE').html(response['FNE']);
                        }
                        else
                        {
                            $("#inputFname").addClass('is-invalid');
                            $('#inputFnameE').html(response['FNE']);
                        }

                        if(response['LNE'] === "")
                        {
                            $("#inputLname").addClass('is-valid').removeClass('is-invalid');
                            $('#inputLnameE').html(response['LNE']);
                        }
                        else
                        {
                            $("#inputLname").addClass('is-invalid');
                            $('#inputLnameE').html(response['LNE']);
                        }

                    }
                }

                else if (currentTab === 1)
                {
                    if(response['status'])
                    {

                        $("#inputEmail").addClass('is-valid').removeClass('is-invalid');
                        $('#inputEmailE').html(response['EE']);

                        $("#inputPassword").addClass('is-valid').removeClass('is-invalid');
                        $('#inputPasswordE').html(response['PE']);

                        $("#inputCPassword").addClass('is-valid').removeClass('is-invalid');
                        $('#inputCPasswordE').html(response['PCE']);

                        x.eq(currentTab).animate({
                            height: "hide",
                            display:'none'
                        },500,'linear');
                        currentTab += 1;
                        showTab(currentTab);
                        $('#register').click(function (){
                            var submit = $(this).val();
                            next(submit);
                        });

                    }
                    else
                    {
                        if(response['EE'] === "")
                        {
                            $("#inputEmail").addClass('is-valid').removeClass('is-invalid');
                            $('#inputEmailE').html(response['EE']);
                        }
                        else
                        {
                            $("#inputEmail").addClass('is-invalid');
                            $('#inputEmailE').html(response['EE']);
                        }

                        if(response['PE'] === "")
                        {
                            $("#inputPassword").addClass('is-valid').removeClass('is-invalid');
                            $('#inputPasswordE').html(response['PE']);

                            if(response['PCE'] === "")
                            {
                                $("#inputCPassword").addClass('is-valid').removeClass('is-invalid');
                                $('#inputCPasswordE').html(response['PCE']);
                            }
                            else
                            {
                                $("#inputCPassword").addClass('is-invalid');
                                $('#inputCPasswordE').html(response['PCE']);
                            }
                        }
                        else
                        {
                            $("#inputPassword").addClass('is-invalid');
                            $('#inputPasswordE').html(response['PE']);
                        }


                    }

                }
                else if ( currentTab === 2)
                {
                    if(response['status'])
                    {
                        $("#inputMobile").addClass('is-valid').removeClass('is-invalid');
                        $('#inputMobileE').html(response['ME']);

                        $("#inputCity").addClass('is-valid').removeClass('is-invalid');
                        $('#inputCityE').html(response['CE']);


                        if(response['IE']=='insert')
                        {



                            $("#RegModal").modal('hide');

                            $('#successR').show();

                            $('#successR').html('<div style="display: none" class="alert alert-success alert-dismissible fade show" role="alert" >\n' +
                                '                <strong>Success</strong> You are now registerd successfully\n' +
                                '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                                '            </div>');
                            $('#successR .alert').delay(1000).show('slow');

                            x.eq(currentTab).animate({
                                height: "hide",
                                display:'none'
                            },500,'linear');

                            currentTab = 0;
                            showTab(currentTab);
                            $("#inputFname").val('').removeClass('is-valid');
                            $("#inputLname").val('').removeClass('is-valid');
                            $("#inputEmail").val('').removeClass('is-valid');
                            $("#inputPassword").val('').removeClass('is-valid');
                            $("#inputCPassword").val('').removeClass('is-valid');
                            $("#inputMobile").val('').removeClass('is-valid');
                            $('#inputCity').removeClass('is-valid');

                        }

                        if(response['IE'] == "error")
                        {
                            $('#errorR').show();

                            $('#errorR').html(' <div  class="alert alert-danger alert-dismissible fade show" role="alert"  style="display: none">\n' +
                                '                <strong>Error</strong> in registering!!\n' +
                                '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                                '            </div>');
                            $('#errorR .alert').delay(1000).show('slow');
                        }


                    }
                    else
                    {

                        if(response['ME'] === "")
                        {
                            $("#inputMobile").addClass('is-valid').removeClass('is-invalid');
                            $('#inputMobileE').html(response['ME']);
                        }
                        else
                        {
                            $("#inputMobile").addClass('is-invalid');
                            $('#inputMobileE').html(response['ME']);
                        }

                        if(response['CE'] === "")
                        {
                            $("#inputCity").addClass('is-valid').removeClass('is-invalid');
                            $('#inputCityE').html(response['CE']);
                        }
                        else
                        {
                            $("#inputCity").addClass('is-invalid');
                            $('#inputCityE').html(response['CE']);
                        }





                    }




                }

            });







    }







});