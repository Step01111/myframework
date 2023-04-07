function SendRequest (url, request, method)
{
    if (request) {
        request = JSON.stringify(request);

        if(!method) {
            method = 'POST';
        }
    } else {
        method = 'GET';
    }

    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: request
    })
    .then(function (response) {
        return response.json();
    })
}