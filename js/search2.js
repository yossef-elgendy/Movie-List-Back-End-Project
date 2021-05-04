$(document).ready(function (){
    $('#search2').keyup(function () {
       let key2 = $(this).val();
       $.post("ajax/search.php",{
           key2:key2
       }, function (data, status){
           $('#movies').html(data);
       });
    });

});