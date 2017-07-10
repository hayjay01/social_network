$(document).ready(function() {

// getting like by id
    $("body").delegate("#like", "click", function(event) {
        event.preventDefault();
        console.log(1);
    });
});