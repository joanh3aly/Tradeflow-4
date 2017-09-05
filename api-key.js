$.ajax({
    type: 'POST',
    url: 'http://localhost:8888/ci/application/views/track.php',
    crossDomain: true,
    data: '{"myID":"hello"}',
    dataType: 'json',
    success: function(responseData, textStatus, jqXHR) {
        var value = responseData.someKey;
    },
    error: function (responseData, textStatus, errorThrown) {
        alert('POST failed.');
    }
});

  
