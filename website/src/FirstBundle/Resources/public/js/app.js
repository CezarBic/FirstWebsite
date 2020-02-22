document.addEventListener('DOMContentLoaded',function (e) {
    //edit
    // const edit = document.querySelectorAll('#taticu #edit');
    //
    // for (var i = 0; i < edit.length; i++) {
    //     edit[i].addEventListener('click', (e) => {
    //         e.preventDefault();
    //         const id = e.target.getAttribute('data-id');
    //         fetch(`/edit/edit/${id}`,{method: 'POST'}).then(result => 1);
    //     });
    // }


    //delete
    const dell = document.querySelectorAll('#taticu .delete');

    for (var i = 0; i < dell.length; i++) {
        dell[i].addEventListener('click', (e) => {
            e.preventDefault();
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');

               fetch(`/dell/delete/${id}`,{method: 'DELETE'}).then(result => window.location.reload());
            }
        });
    }

$('#messages').animate({scrollTop: $('#messages')[0].scrollHeight});
});


