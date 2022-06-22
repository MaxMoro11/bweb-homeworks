$(document).ready(function () {
  $("form").submit(function (event) {
    var formData = {
      query: $("#ip").val(),
    };
	var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=";
	var token = "2ffc1135ee04bf595d7caa032b4eca686dba6b44";

    $.ajax({
      type: "GET",
      url: url + formData.query,
	  beforeSend: function(xhr) {
                 xhr.setRequestHeader("Authorization", "Token "+ token) 
            },
      data: '',
      dataType: "json",
      encode: true,
    }).done(function (result) {
      console.log(result);

      $("#result").html(
          '<p>' + result.location['value'] + '</p>'
      );
	});
    event.preventDefault();
  });
});