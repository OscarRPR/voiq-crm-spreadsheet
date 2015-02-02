function progressBar(button)
{
  document.getElementById("loading_progress_main").style.display = 'block';  
  document.getElementById("loading_bar").style.width = '0%';
  document.getElementById("result").innerHTML = "";
  var elem = document.getElementById("flashMessage");

  if(typeof page_name != 'undefined') {
    elem.parentElement.removeChild(elem);
  }

  var interval_id = window.setInterval("", 9999); 
                                                  
  for (var i = 1; i < interval_id; i++) {
    window.clearInterval(i);
  }

  var interval = setInterval(
    function() {
      var xmlhttp;                                
      if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          button.disabled = true;
          document.getElementById("loading_progress_main").style.display = 'block';
          var values = $.trim(xmlhttp.responseText);
          array_counter = values.split("|");

          var rows_read = parseInt(array_counter[0]);
          var total_rows = parseInt(array_counter[1]);

          var percentage = 100*rows_read/total_rows;

          document.getElementById("result").innerHTML = parseInt(percentage) + '%'
          document.getElementById("loading_bar").style.width = parseInt(percentage) + '%';

          if ( rows_read >= total_rows && total_rows > 0 ) {
            document.getElementById("result").innerHTML = "The upload has ended. Please, check the downloaded log for details."; 
            clearInterval(interval);

            var fileInput = $("#fileInput");

            fileInput.wrap('<form>').parent('form').trigger('reset');
            fileInput.unwrap();

            button.disabled = false;
          }
        }
      }

      xmlhttp.open("GET","getLoadingData", true);
      xmlhttp.send();
    } , 800);

}