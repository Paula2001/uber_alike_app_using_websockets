function createDataTable(type){
    $('#monopolies').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        stateSave: true,
        order: [[0, "desc"]],
        select: true,

        ajax: {
            "url": `${base_url}/driver/json-monopolists/${type}`,
            "type": 'GET',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'vehicle_type', name: 'vehicle_type'},
            {data: 'created_at', name: 'created_at'},
        ],
    });
}
$(document).ready(function(){
    $('#select_duration').change(function(){
        createDataTable($(this).val())
    });
    createDataTable($('#select_duration').val());

});
