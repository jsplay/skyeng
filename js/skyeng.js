$( ".statuses" ).change(function() {
    $(this).parent().parent().children("#buttondiv").children("button").show();
});
$(".savebutton").click(function() {
    var thisobj = $(this);
    $.ajax({

        // The URL for the request
        url: "update.php",

        // The data to send (will be converted to a query string)
        data: {
            clientid: $(this).val(),
            statusid: $(this).parent().parent().children("#statuses-cont").children(".statuses").find(":selected").val()
        },

        // Whether this is a POST or GET request
        type: "POST",
    })
      // Code to run if the request succeeds (is done);
      // The response is passed to the function
      .done(function( data, status ) {
         thisobj.hide();
         thisobj.parent().children(".success").show();
         thisobj.parent().children(".success").fadeOut("slow");
         console.log("Data: " + data + "\nStatus: " + status);
      })
      // Code to run if the request fails; the raw request and
      // status codes are passed to the function
      .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
      })
});

$( "#addbutton" ).click(function() {
    $(this).parent().children(".hidden").show();
    $(this).hide();
});
$( "#cancel" ).click(function() {
    $(this).parent().children(".hidden").hide();
    $("#addform")[0].reset();
    $("#addbutton").show();
});
$( "#save" ).click(function() {
    var thisobj = $(this);
    if (formvalidation()) {
        $.ajax({

            // The URL for the request
            url: "update.php",

            // The data to send (will be converted to a query string)
            data: {
                name: $(this).parent().children("#name").val(),
                surname: $(this).parent().children("#surname").val(),
                phone: $(this).parent().children("#phone").val(),
            },

            // Whether this is a POST or GET request
            type: "POST",
        })
          // Code to run if the request succeeds (is done);
          // The response is passed to the function
          .done(function( data, status ) {
             thisobj.hide();
             thisobj.parent().children(".success2").show();
             thisobj.parent().children(".success2").fadeOut("slow", function() { location.reload(); });
             console.log("Data: " + data + "\nStatus: " + status);
          })
          // Code to run if the request fails; the raw request and
          // status codes are passed to the function
          .fail(function( xhr, status, errorThrown ) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
          })
    }
});
$("#phone").keyup(function () {  
    this.value = this.value.replace(/[^0-9\.]/g,''); 
});
function formvalidation() {
    if ($("#name").val() == "" || $("#name").val() == null) {
        $("#errors").text("Имя должно быть заполнено.");
        return false;
    }
    if ($("#surname").val() == "" || $("#surname").val() == null) {
        $("#errors").text("Фамилия должна быть заполнена.");
        return false;
    }
    if ($("#phone").val() == "" || $("#phone").val() == null) {
        $("#errors").text("Телефон должен быть заполнен.");
        return false;
    }
    if ($("#phone").val().length < 9) {
        $("#errors").text("Телефон должен содержать 8 цифр без пробелов и дефисов.");
        return false;
    }
    $("#errors").text("");
    return true;
}