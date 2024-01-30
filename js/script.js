$('a.delete').on('click', function(e){
    e.preventDefault();
    if(confirm('Do you want to delete?')){
        alert('Deleted');
        const frm = $("<form>");
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");
        frm.submit();
    }
});

$.validator.addMethod("dateTime", function(value, element){
    return (value == "") || ! isNaN(Date.parse(value));
}, "Must be a valid date and time");

$('#article-form').validate({
    rules:{
        text:{
            required: true
        },
        content:{
            required: true
        },
        date:{
            dateTime: true
        }
    }

});

$('#formContact').validate({
    rules:{
        email:{
            required: true,
            email: true
        },
        title:{
            required: true
        },
        message:{
            required: true
        }
    }

});