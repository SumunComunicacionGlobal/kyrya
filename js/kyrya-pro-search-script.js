$ = jQuery;
 
var mafs = $("#kyrya-pro-search"); 
var mafsForm = mafs.find("form"); 
var data;
// var ajax_url = "//localhost:3000/kyrya/wp-admin/admin-ajax.php";
console.log(pro_search_ajax_object.ajax_url);
 
mafsForm.submit(function(e){
    e.preventDefault(); 
 
	if(mafsForm.find("#prosearch").val().length !== 0) {
	    var search = mafsForm.find("#prosearch").val();
	}
	// if(mafsForm.find("#year").val().length !== 0) {
	//     var year = mafsForm.find("#year").val();
	// }
	// if(mafsForm.find("#rating").val().length !== 0) {
	//     var rating = mafsForm.find("#rating").val();
	// }
	// if(mafsForm.find("#language").val().length !== 0) {
	//     var language = mafsForm.find("#language").val();
	// }
	// if(mafsForm.find("#genre").val().length !== 0) {
	//     var genre = mafsForm.find("#genre").val();
	// }
 
	data = {
	    action : "kyrya_pro_search",
	    search : search
	    // year : year,
	    // rating : rating,
	    // language : language,
	    // genre : genre
	}

});

$.ajax({
        url : pro_search_ajax_object.ajax_url,
        data : data,
        success : function(response) {
            mafs.find("ul").empty();
            if(response) {
                for(var i = 0 ;  i < response.length ; i++) {
                     var html  = "<li id='dlm_download-" + response[i].id + "'>";
                         html += "  <a class='download-link' href='" + response[i].permalink + "' title='" + response[i].title + "'>";
                         // html += "      <img src='" + response[i].poster + "' alt='" + response[i].title + "' />";
                         // html += "      <div class='movie-info'>";
                         // html += "          <h4>" + response[i].title + "</h4>";
                         html += "              " + response[i].title;
                         // html += "          <p>Year: " + response[i].year + "</p>";
                         // html += "          <p>Rating: " + response[i].rating + "</p>";
                         // html += "          <p>Language: " + response[i].language + "</p>";
                         // html += "          <p>Director: " + response[i].director + "</p>";
                         // html += "          <p>Genre: " + response[i].genre + "</p>";
                         // html += "      </div>";
                         html += "  </a>";
                         html += "</li>";
                     mafs.find("ul").append(html);
                }
            } else {
                var html  = "<li class='no-result'>No results.</li>";
                mafs.find("ul").append(html);
            }
        } 
    });