$(document).ready(function () {

    actionButtons();

    searchComplete()
    searchCheck();

    console.log("ready!");
})

/**
 * * Check for action buttons and add event listeners
 */

const actionButtons = () => {

    $('.action-btn').click(function (e) {
        e.preventDefault(); // Prevent default form submission

        let form = $(this).closest('form'); // Get the closest form element
        let action = form.attr('action'); // Get the form action URL

        form.attr('action', $(this).data('action'));
        form.submit(); // Submit the form

        form.attr('action', action); // Reset the form action URL
    });
}

/**
 * * Check for search inputs and add event listeners
 */

const SEARCH = "/api/search"
const SEARCH_ID = "/api/search/id"
const SEARCH_MIN_LENGTH = 5

const searchComplete = () => {
    $('.search').each(function() {
        const name = $(this).attr("id") // search_id
        const column = name.substr(7) // id
        const values = sync(SEARCH_ID, { column , id: $("#" + column).val() })
        $("#" + name).val(values[1])
    })
}

const searchCheck = () => {

    $('.search').on('input', function () {

        const input = $(this)

        const name = input.attr("id") // search_id
        const column = name.substr(7) // id
        const text = input.val().trim()

        const searchId = "#searchOverlay_" + column
        const search = $(searchId)
        
        $('.list-group-item').off();

        if (text.length > SEARCH_MIN_LENGTH) {

            let data = sync(SEARCH, { column, text });

            if (data.length === 0) {
                search.html("No results found!")
            }

            else {
                search.empty();
                data.forEach(item => {
                    search.append(
                        `<a href="#" class="list-group-item list-group-item-action" 
                            data-id="${item[0]}">${item[1]}</a>`
                    );
                });
    
                search.fadeIn(200);
            }

            // Handle item selection
            search.on('click', '.list-group-item', function(e) {
                e.preventDefault();
                input.val($(this).text());
                $("#" + column).val($(this).data("id"));
                search.empty()
            });
        }

        else {
            search.html("Finding...")
        }
    })
}

function sync(url, data = null, method = 'GET') {

    let result = null, error = null;

    $.ajax({
        url: url,
        type: method,
        data: data,
        async: false, // Hacemos la petición síncrona
        dataType: 'json',
        success: function (response) {
            result = response.data;
        },
        error: function (xhr, status, err) {
            console.log("Error: ", url, data)
            error = new Error(`Error en la petición: ${status} - ${err}`);
        }
    });

    if (error) {
        throw error;
    }

    return result;
}