// Setup your quiz text and questions here

// NOTE: pay attention to commas, IE struggles with those bad boys;]

var quizJSON = (function () {
    var quizJSON = null;
    $.ajax({
        'async': false,
        'global': false,
        'url': '/quiz/refresher',
        'dataType': "json",
        'success': function (data) {
            quizJSON = data;
        }
    });
    return quizJSON;
})();
