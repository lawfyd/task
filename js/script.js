//Сортировка данных на feedback
$(document).ready(function () {
   $(".sort span").click(function () {
       var id = $(this).attr('id');
       $.ajax({
           url:'feedback/getSort',
           data:'sort_id='+id, // sort_id=name_a
           type:'post',
           success:function (html) {
               $('#feedList').html(html).hide().fadeIn(1000);
           }
       });
   });
});