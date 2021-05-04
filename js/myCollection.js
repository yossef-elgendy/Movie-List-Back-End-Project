$(document).ready(function (){
    var property = null ;



    function tooltip()
    {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }


    function count()
    {
        var i = 0;
        $('#list tr td.count').each(function (index){
            if(!($('#list tr').eq(index).attr('class').match('deleted')))
            {
                $(this).html((i+1))
                i++;
            }

        });
    }

    $('#path').change(function (event){

        property = $(this)[0].files[0];
        let property_name = property.name ;

        $('#img-name').html(property_name);
        $('#img-preview span').html('<img src="'+URL.createObjectURL(event.target.files[0])+'" class="img-thumbnail small-img"/>');
    });

    function update_delete()
    {


        $('#list tr').each(function (index){


            $('.delete').eq(index).click(function (){
                let id = $(this).val();
                $('#list tr').eq(index).addClass('deleted').hide('slow');
                let form_data = new FormData();
                form_data.append('id',id);
                $.ajax({
                    url:"ajax/delete_movie.php",
                    method:"POSt",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        console.log(data);
                        if(data==="wellDone")
                        {
                            $('#alert').show();
                            $('#alert').html('<div style="display: none" class="alert alert-success alert-dismissible fade show" role="alert" >\n' +
                                '                <strong>Operations Is Complete!!</strong> The movie has been deleted.\n' +
                                '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                                '            </div>');
                            $('#alert .alert').show('slow');
                            $('#alert').delay(3000).hide('slow');
                        }
                    }

                });
                count();

            });

            $(this).find('.edit').click(function (){
                var id = $(this).val();
                var old = $('#list tr').eq(index).html();
                let form_data = new FormData();
                form_data.append('Edit',id);
                $.ajax({
                    url:"ajax/update_movie.php",
                    method:"POST",
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function (data){
                        $('#list tr').eq(index).hide(1000,function (){
                            $('#list tr').eq(index).html(data).show(500);
                            $('#cancel'+id).click(function (){
                                $('#list tr').eq(index).hide(500,function (){
                                    $('#list tr').eq(index).html(old).show(500);
                                    update_delete();
                                });
                            });

                            var newProperty = null;

                            $('#list tr').eq(index).find('input[name="pathUp"]').change(function (event){
                                newProperty = $(this)[0].files[0];
                                let property_name = newProperty.name ;
                                let extension = property_name.split('.').pop().toLowerCase();
                                // console.log(newProperty);
                                if(jQuery.inArray(extension,['gif','png','jpg','jpeg'])== -1)
                                {
                                    $('#alert').show();
                                    $('#alert').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                                        '                <strong>Invalid img</strong> Please enter a valid image.\n' +
                                        '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                                        '            </div>');
                                    $('#alert .alert').show('slow');
                                    $('#alert').delay(3000).hide('slow');
                                    newProperty = null;

                                }
                                else if(newProperty.size > 2000000)
                                {
                                    $('#alert').show();
                                    $('#alert').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                                        '                <strong>Invalid img</strong> The img should be smaller than 2MB image.\n' +
                                        '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                                        '            </div>');
                                    $('#alert .alert').show('slow');
                                    $('#alert').delay(3000).hide('slow');
                                    newProperty = null;

                                }
                                else
                                {
                                    $('#list tr').eq(index).find('.img-preview').html('<img src="'+URL.createObjectURL(event.target.files[0])+'" class="img-thumbnail small-img"/>');
                                    $('#list tr').eq(index).find('.img-name').html(newProperty.name);

                                }
                            });

                            $('#update'+id).click(function () {
                                let name = $('#list tr').eq(index).find('input[name="nameUp"]').val();
                                let rate = $('#list tr').eq(index).find('input[name="rateUp"]').val();
                                let pID = $('#list tr').eq(index).find('input[name="pID"]').val();
                                var form_update_data = new FormData();
                                if (newProperty !== null)
                                {
                                    form_update_data.append('pathUp',newProperty);
                                }

                                form_update_data.append('nameUp',name);
                                form_update_data.append('rateUp',rate);
                                form_update_data.append('pID',pID);
                                form_update_data.append('Update',id);
                                $.ajax({
                                    url:"ajax/update_movie.php",
                                    method:"POST",
                                    data:form_update_data,
                                    cache:false,
                                    contentType:false,
                                    processData:false,
                                    success:function (data) {
                                        console.log(data);
                                        let result = JSON.parse(data);
                                        if (result['status'])
                                        {
                                            $('#list tr').eq(index).hide(500, function (){
                                                $('#list tr').eq(index).html( '<td class="count"></td><td>'+result['Name']+'</td>' +
                                                    '<td>'+result['Rate']+'</td>' +
                                                    '<td><img src="uploaded-imgs/'+result['Photo']+'" class="img-thumbnail small-img"' +
                                                    ' alt="'+result['Name']+'" height="125" width="75"/></td>' +
                                                    '<td class="text-lg-start"><button data-bs-toggle="modal" data-bs-target="#delete'+result['mID']+'" name="deletee" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' +
                                                    '<button data-bs-toggle="tooltip" data-bs-placement="right" title="Edit" value="'+result['mID']+'" name="edit" class="btn btn-primary edit"><i class="fas fa-edit"></i></button></td>');
                                                $('#list tr').eq(index).show(500);
                                                count();
                                                update_delete();
                                            });


                                        }
                                        else {

                                            if (result['NE'] === "") {
                                                $('#list tr').eq(index).find('input[name="nameUp"]').removeClass('is-invalid');
                                                $('#list tr').eq(index).find('.nameE').html(result['NE']);
                                            }
                                            else
                                            {
                                                $('#list tr').eq(index).find('input[name="nameUp"]').addClass('is-invalid');
                                                $('#list tr').eq(index).find('.nameE').html(result['NE']);
                                            }

                                            if (result['RE']==="")
                                            {
                                                $('#list tr').eq(index).find('input[name="rateUp"]').removeClass('is-invalid');
                                                $('#list tr').eq(index).find('.nameE').html(result['RE']);
                                            }
                                            else
                                            {
                                                $('#list tr').eq(index).find('input[name="rateUp"]').addClass('is-invalid');
                                                $('#list tr').eq(index).find('.rateE').html(result['RE']);
                                            }
                                        }
                                    }
                                });



                            });

                        });


                    }

                });

            });




        });
    }

    $('#search').keyup(function (){
       let key = $(this).val();
       let form_data = new FormData();
       form_data.append('key',key);
       $.ajax({
           url:"ajax/search.php",
           method:"POST",
           data:form_data,
           contentType:false,
           cache:false,
           processData:false,
           success:function (data){
                $('#list').html(data);
                count();
           }
       })
    });




    $('#add1').click(function (){
        if (property !== null)
        {
            let property_name = property.name ;
            let extension = property_name.split('.').pop().toLowerCase();

            if(jQuery.inArray(extension,['gif','png','jpg','jpeg'])== -1)
            {
                $('#errorImg').show();
                $('#errorImg').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                    '                <strong>Invalid img</strong> Please enter a valid image.\n' +
                    '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                    '            </div>');
                $('#errorImg .alert').show('slow');
                $('#errorImg').delay(3000).hide('slow');
            }
            else if(property.size > 2000000)
            {
                $('#errorImg').show();
                $('#errorImg').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                    '                <strong>Invalid img</strong> The img should be smaller than 2MB image.\n' +
                    '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                    '            </div>');
                $('#errorImg .alert').show('slow');
                $('#errorImg').delay(3000).hide('slow');
            }
            else
            {
                let form_data = new FormData();
                form_data.append('file',property);
                form_data.append('name',$('#name').val());
                form_data.append('rate',$('#rate').val());
                form_data.append('uid',$('#add1').val());
                $.ajax({
                    url:'ajax/addMovie.php',
                    method:'POST',
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success: function (data){
                        console.log(data);
                        let result = JSON.parse(data);
                        // console.log(result);
                        if(result['status'] === "true" && result['IE'] ==="Insert")
                        {
                            $('#list').append('<tr class="text-light" style="display: none"><td class="count"></td><td>'+result['Name']+'</td>' +
                                '<td>'+result['Rate']+'</td>' +
                                '<td><img src="uploaded-imgs/'+result['Photo']+'" class="img-thumbnail small-img"' +
                                ' alt="'+result['Name']+'" height="125" width="75"/></td>' +
                                '<td class="text-lg-start"><button data-bs-toggle="modal" data-bs-target="#delete'+result['mID']+'" name="deletee" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' +
                                '<button data-bs-toggle="tooltip" data-bs-placement="right" title="Edit" value="'+result['mID']+'" name="edit" class="btn btn-primary edit"><i class="fas fa-edit"></i></button></td>' +
                                '</tr>');
                            $('#list_1').before('  <div class="modal fade" id="delete'+result['mID']+'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                                '                                    <div class="modal-dialog">\n' +
                                '                                        <div class="modal-content bg-dark text-light">\n' +
                                '                                            <div class="modal-header">\n' +
                                '                                                <h5 class="modal-title" id="exampleModalLabel">'+result['Name']+'</h5>\n' +
                                '                                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                '                                            </div>\n' +
                                '                                            <div class="modal-body">\n' +
                                '                                                Are you sure you want to delete this movie ?\n' +
                                '                                            </div>\n' +
                                '                                            <div class="modal-footer p-2">\n' +
                                '                                                <button type="button" class="btn btn-secondary p-2" data-bs-dismiss="modal">Cancel</button>\n' +
                                '                                                <button name="delete" data-bs-dismiss="modal" type="button" value="'+result['mID']+'" class="btn btn-danger delete">Delete</button>\n' +
                                '                                            </div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>\n' +
                                '                                </div>');

                            $('#list_1').before('             <div class="modal fade" id="updateModal'+result['mID']+'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                                '                            <div class="modal-dialog">\n' +
                                '                                <div class="modal-content bg-dark text-light">\n' +
                                '                                    <div class="modal-header">\n' +
                                '                                        <h5 class="modal-title" id="exampleModalLabel">'+result['Name']+'</h5>\n' +
                                '                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                '                                    </div>\n' +
                                '                                    <div class="modal-body">\n' +
                                '                                        Are you sure you want to save changes for this movie ?\n' +
                                '                                    </div>\n' +
                                '                                    <div class="modal-footer p-2">\n' +
                                '                                        <button type="button" class="btn btn-secondary p-2" data-bs-dismiss="modal">Cancel</button>\n' +
                                '                                        <button name="delete" data-bs-dismiss="modal" type="button" value="'+result['mID']+'" id="update'+result['mID']+'" class="btn btn-success ">Save Changes</button>\n' +
                                '                                    </div>\n' +
                                '                                </div>\n' +
                                '                            </div>\n' +
                                '                        </div>')
                            $('#list tr:last').show(2500);
                            $('#name').val('');
                            $('#rate').val('');
                            property = null;
                            $('#img-name').html('');
                            $('#img-preview').html('<span class="text-center text-muted">Preview</span>');
                            update_delete();
                            count();
                            tooltip();

                        }
                        else
                        {
                            if(result['NE'] === "")
                            {
                                $('#name').removeClass('is-invalid');
                                $('#name').html(result['NE']);
                            }
                            else
                            {
                                $('#name').addClass('is-invalid');
                                $('#nameE').html(result['NE']);
                            }

                            if(result['RE']=== "")
                            {
                                $('#rate').removeClass('is-invalid');
                                $('#rate').html(result['RE']);
                            }
                            else
                            {
                                $('#rate').addClass('is-invalid');
                                $('#rateE').html(result['RE']);
                            }
                        }
                    }
                });
            }
        }
        else
        {
            $('#errorImg').show();
            $('#errorImg').html('<div style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert" >\n' +
                '                <strong>Img Is Required.</strong> Please upload an image.\n' +
                '                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
                '            </div>');
            $('#errorImg .alert').show('slow');
            $('#errorImg').delay(3000).hide('slow');
        }
    });



    count();
    tooltip();
    update_delete();

});