$(document).ready(function() {

    var params = {
        'typeID': "tradeSupportStage",
        'paymentsID': 'paymentsStage',
        'custodyID': 'custodyStage',
        'corporateActionID': 'corporateActionStage',
        'settlementsID': 'settlementsStage'
    };
    $.post("<?php echo 'http://tradeflowhq.ie/API_test/ci/index.php/site/IDnumberFill' ?>",
        params,
        function(dataIDs, status) {
            $('#stageIDs').html(dataIDs);
        });

    $("#T6, #T12, #T18, #T24").on("click", function() {
        var a_href = $(this).attr('href');
        var idNumberChosen = a_href.split('#');
        var params = {
            type: idNumberChosen[1]
        };
        $.post("<?php echo 'http://tradeflowhq.ie/API_test/ci/index.php/site/lateTradeIDs' ?>",
            params,
            function(data, status) {
                $('section').html(data);
            });
    });

    $("li a").on("click", function() {
        var a_href = $(this).attr('href');
        var idNumberChosen = a_href.split('#');
        var params = {
            type: idNumberChosen[1]
        };
        $.post("<?php echo 'http://tradeflowhq.ie/API_test/ci/index.php/site/IDnumberAJAX' ?>",
            params,
            function(data, status) {
                $('section').html(data);
            });
    });

    $("#stageIDs").on("click", 'a.tradeIDs', function() {
        var a_href = $(this).attr('href');
        var idNumberChosen = a_href.split('#');
        var params = {
            type: idNumberChosen[1]
        };
        $.post("<?php echo 'http://tradeflowhq.ie/API_test/ci/index.php/site/IDnumberAJAX' ?>",
            params,
            function(data, status) {
                $('section').html(data);
            });
    });

    $(".tradeSupportStage select").on("click", 'option', function() {
        var a_href = $(this).attr('href');
        var idNumberChosen = a_href.split('#');
        var params = {
            type: idNumberChosen[1]
        };
        $.post("<?php echo 'http://tradeflowhq.ie/API_test/ci/index.php/site/IDnumberAJAX' ?>",
            params,
            function(data, status) {
                $('section').html(data);
            });
    });

    $("#stageIDs").on("click", "#Payments", function() {
        $(".tradeSupportStage ul").toggle();
    });


});