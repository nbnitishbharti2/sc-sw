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

//Delete vehicle type show popup function
function vehicle_type_confirm_delete(vehicle_type_id) {
    var delete_url = $('#delete-vehicle_type').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + vehicle_type_id;
    $('#delete-vehicle_type').attr('href', delete_url);
    $('#modal-vehicle_type-delete').modal('show');
}
//Function for show restore popup for vehicle type
function vehicle_type_confirm_restore(vehicle_type_id) {
    var restore_url = $('#restore-vehicle_type').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + vehicle_type_id;
    $('#restore-vehicle_type').attr('href', restore_url);
    $('#modal-vehicle_type-restore').modal('show');
}

//Delete vehicle show popup function
function vehicle_confirm_delete(vehicle_id) {
    var delete_url = $('#delete-vehicle').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + vehicle_id;
    $('#delete-vehicle').attr('href', delete_url);
    $('#modal-vehicle-delete').modal('show');
}
//Function for show restore popup for vehicle
function vehicle_confirm_restore(vehicle_id) {
    var restore_url = $('#restore-vehicle').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + vehicle_id;
    $('#restore-vehicle').attr('href', restore_url);
    $('#modal-vehicle-restore').modal('show');
}

//Delete root show popup function
function root_confirm_delete(root_id) {
    var delete_url = $('#delete-root').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + root_id;
    $('#delete-root').attr('href', delete_url);
    $('#modal-root-delete').modal('show');
}
//Function for show restore popup for root
function root_confirm_restore(root_id) {
    var restore_url = $('#restore-root').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + root_id;
    $('#restore-root').attr('href', restore_url);
    $('#modal-root-restore').modal('show');
}

//Delete vehicle root map show popup function
function vehicle_root_map_confirm_delete(vehicle_root_map_id) {
    var delete_url = $('#delete-vehicle_root_map').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + vehicle_root_map_id;
    $('#delete-vehicle_root_map').attr('href', delete_url);
    $('#modal-vehicle_root_map-delete').modal('show');
}
//Function for show restore popup for vehicle root map
function vehicle_root_map_confirm_restore(vehicle_root_map_id) {
    var restore_url = $('#restore-vehicle_root_map').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + vehicle_root_map_id;
    $('#restore-vehicle_root_map').attr('href', restore_url);
    $('#modal-vehicle_root_map-restore').modal('show');
}

//Delete stopage show popup function
function stopage_confirm_delete(stopage_id) {
    var delete_url = $('#delete-stopage').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + stopage_id;
    $('#delete-stopage').attr('href', delete_url);
    $('#modal-stopage-delete').modal('show');
}
//Function for show restore popup for stopage
function stopage_confirm_restore(stopage_id) {
    var restore_url = $('#restore-stopage').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + stopage_id;
    $('#restore-stopage').attr('href', restore_url);
    $('#modal-stopage-restore').modal('show');
}

//Delete hostel show popup function
function hostel_confirm_delete(hostel_id) {
    var delete_url = $('#delete-hostel').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + hostel_id;
    $('#delete-hostel').attr('href', delete_url);
    $('#modal-hostel-delete').modal('show');
}
//Function for show restore popup for hostel
function hostel_confirm_restore(hostel_id) {
    var restore_url = $('#restore-hostel').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + hostel_id;
    $('#restore-hostel').attr('href', restore_url);
    $('#modal-hostel-restore').modal('show');
}

//Delete room show popup function
function room_confirm_delete(room_id) {
    var delete_url = $('#delete-room').attr('href');
    delete_url = delete_url.replace(/\d+/g, '') + room_id;
    $('#delete-room').attr('href', delete_url);
    $('#modal-room-delete').modal('show');
}
//Function for show restore popup for room
function room_confirm_restore(room_id) {
    var restore_url = $('#restore-room').attr('href');
    restore_url = restore_url.replace(/\d+/g, '') + room_id;
    $('#restore-room').attr('href', restore_url);
    $('#modal-room-restore').modal('show');
}