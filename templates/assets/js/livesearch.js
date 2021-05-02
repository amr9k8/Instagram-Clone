
  console.log("Hello world!"); 


$(document).ready(function() {

  $("#close_search").click(function(event){
    event.preventDefault();
  });

      $('#real_time_search').focus(function() {
      $('#close_search').css({'opacity':'1'});
      $('.search_drop').slideDown();
      
      })
      $('#real_time_search').focusout(function() {
      $('#close_search').css({'opacity':'0'});
      $('.search_drop').slideUp();
      

      })


    $('#real_time_search').keyup(function() {

      var keyword = $('#real_time_search').val();    
      $.ajax({
        type: "get",
        url: 'search.php',
        data: {query:keyword},
        dataType:"json",
        success: function(result)
        {
            

        var res ='';
        for (i=0; i<result.length; i++)
        {
          
          res = res.concat( ` <div class = srch_drp_row>
          <div class="srch_avatar">
              <img src="uploads/`+result[i][4] +`"> 
          </div>
          <div class="srch_name">
              <a href="otherprofile.php?id=`+ result[i][0] + `" class="name_comment">`+ result[i][1] +`</a>  
              <span>` + result[i][2] + `</span>  
          </div>             
          </div>`);
         
            
          //  'ID: ' + result[i][0] + 
          
          //  '<br> Avatar'+result[i][4] + '<br>'  

          $('.search_drop').html(res); 
        }

        
        // var obj = JSON.parse(response);
        // $('#').html(response);
        // $('#content').load('test.php?order=DESC');
           
        },
        error: function(xhr) {
          //Do Something to handle error
          $('.search_drop').html('<p style="text-align:center; color:rgb(146, 146, 146);">NoResults</p>'); 
        }
      });
          

       }); });
     











