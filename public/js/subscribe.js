$(document).ready(function () {
    // alert('jquery and dt ready')
    $('#subscribers-table').DataTable({
        serverSide: true,
        ajax: '/api/v1/subscribers',
        columns: [
            { data: 'email' },
            { data: 'name' },
            { data: 'country' },
            { data: 'subscribed_at_date' },
            { data: 'subscribed_at_time' }
        ]
    })
})
