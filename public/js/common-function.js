//Function to show hide password
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
    	event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });

    //For tables
    $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });


});
//Delete class show popup function
function confirm_delete(class_id) {
    var delete_url = $('#delete-class').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + class_id;
    $('#delete-class').attr('href', delete_url);
    $('#modal-class-delete').modal('show');
}
//Function for show restore popup
function confirm_restore(class_id) {
    var restore_url = $('#restore-class').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + class_id;
    $('#restore-class').attr('href', restore_url);
    $('#modal-class-restore').modal('show');
}
//Delete class show popup function
function confirm_section_delete(section_id) {
    var delete_section_url = $('#delete-section').attr('href');
    delete_section_url = delete_section_url.replace(/\d+/g, '') + section_id;
    $('#delete-section').attr('href', delete_section_url);
    $('#modal-section-delete').modal('show');
}