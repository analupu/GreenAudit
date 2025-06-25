$(function() {
    $('.deleteUser').click(function(e) {
        e.preventDefault();
        var url = e.currentTarget.getAttribute('href');
        Swal.fire({
            title: "Esti sigur?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Da",
            cancelButtonText: "Nu"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    $('.blockUser').click(function(e) {
        e.preventDefault();
        var url = e.currentTarget.getAttribute('href');
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});