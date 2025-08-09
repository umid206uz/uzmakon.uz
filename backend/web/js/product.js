$(document).on('pjax:complete', function(event) {
    location.reload();
});
$('.modalButtonDeliveryPrice').click(function(){
    $('#modalDeliveryPrice').modal('show')
        .find('#modalContentDeliveryPrice')
        .load($(this).attr('value'));
});
$('.modalButtonAddPicture').click(function(){
    $('#modalAddPictureToProduct').modal('show')
        .find('#modalContentAddPictureToProduct')
        .load($(this).attr('value'));
});
$('.modalButtonAddVideo').click(function(){
    $('#modalAddVideoToProduct').modal('show')
        .find('#modalContentAddVideoToProduct')
        .load($(this).attr('value'));
});
$('.select-photo').change(function() {
    let id = $(this).data('id');
    let product_id = $(this).data('product_id');
    $.ajax({
        url: '/backend/web/product/ajax',
        method: 'GET',
        data:{
            status: 'status',
            id: id,
            product_id: product_id
        },
        dataType: 'json',
        success: function (data){
            location.reload();
        }
    });
})