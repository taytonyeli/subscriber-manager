$(document).ready(function () {
    // alert('jquery and dt ready')
    let subscriberTable = $('#subscribers-table').DataTable({
        serverSide: true,
        processing: true,
        ajax: '/api/v1/subscribers',
        columns: [
            {
                data: 'email',
                render: function (data, type, row, meta) {
                    return `<a href="/edit-subscriber/${row.DT_RowId}" class="underline">${data}</a>`
                }
            },
            { data: 'name' },
            { data: 'country' },
            { data: 'subscribed_at_date' },
            { data: 'subscribed_at_time' },
            {
                class: 'actions-control',
                orderable: false,
                data: null,
                defaultContent: `
                <button
                  class="del-action rounded-sm mt-2 py-1 px-4 text-center text-black ring-1 ring-red-500 bg-red-500"
                >
                  Delete
                </button>
                `
            }
        ]
    })

    // add click listener for delete action
    $('#subscribers-table tbody').on(
        'click',
        'tr td.actions-control .del-action',
        function () {
            let tr = $(this).closest('tr')
            let id = tr.attr('id')
            deleteSubscriber(id)
                .then(result => {
                    if (result) {
                        //refresh data
                        subscriberTable.ajax.reload()
                    } else {
                        alert('deletion failed')
                    }
                })
                .catch(error => {
                    console.log(error)
                    alert('deletion failed')
                })
        }
    )

    // add click listener for edit action
    // $('#subscribers-table tbody').on(
    //     'click',
    //     'tr td.actions-control .edit-action',
    //     function () {
    //         let tr = $(this).closest('tr')
    //         let id = tr.attr('id')
    //         // redirect to edit page with id in path
    //         window.location.href = `/edit-subscriber/${id}`
    //     }
    // )

    async function deleteSubscriber (id) {
        if (!!!id) {
            return false
        }
        const url = `/api/v1/subscribers/${id}`

        const response = await fetch(url, {
            method: 'DELETE',
            cache: 'no-cache',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer'
        })

        if (response.status === 204) {
            return true
        }

        return false
    }
})
