var path;
$(function(){
    path=$('.path').attr('rel')+'/';
    $('.btn-home').click(function(){
        alert(path+'index');
        window.location.replace(path+'index');
    })
});
