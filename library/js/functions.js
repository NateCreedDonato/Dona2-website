(function($){
  
  $.extend({
   
    //return site variables 
    defaults: function(){
      
      return {
        
        url: ($("#wpurl").val()) ? $("#wpurl").val() : "",
        templateURL: ($("#wptemplateurl").val()) ? $("#wptemplateurl").val() : "",
        hash: this.checkHash()
        
      }
      
    },
   
    //setup custom dropdowns
    customDropdowns: function(){
      
      if ($(".custom_select").length > 0){
        
        $(".custom_select").each(function (index, el) {
          var $select = (!$(this).hasClass("gfield")) ? $(el) : $(this).find("select"); //check if gravity forms
          var $wrapper = $("<div class='selectWrap' />");
          var $fake_select = $("<div class='fakeSelect'></div>");
          var $fake_dropdown = $("<div class='dropdown'></div>");
          
          var selected_text = $select.find("option:selected").text();
          var max_characters = 25;//max character length on the dropdown

          var name = ($(this).attr("name")) ? $(this).attr("name") : "";
          
          $select.wrap($wrapper);
          $select.after($fake_select);
          $select.after($fake_dropdown);
        
          // set selected value as default
          if($select.val() !== ""){
            $fake_select.addClass("selected").html(selected_text);
          }
          else{
            $fake_select.html(selected_text);
          }
          //.css({"width":$select.width()}); //Auto size
          
          /*
           * Loop through select options.
           * Limit the length
           *
           */
          $select.find("option").each(function(index){
            var text = $(this).text();	
            var classes = (text.length > max_characters) ? "long" : "";
            
            if(index != 0){
              
              //Duplicate each option to the fake dropdown menu
              $fake_dropdown.append("<span data-id='"+$(this).val()+"' class='"+classes+"'>"+$(this).text()+"</span>");
              
            }
            
          });
          
          
    
          // change handler
          $select.change(function (){
            //set the selected options
            $fake_select.html($(this).find("option:selected").text());
            $fake_select.append("<span></span>");
          });
          
          //add a class on focus
          $select.focus(function (){
            $fake_select.addClass("focus");
          }).focusout(function (){
            $fake_select.removeClass("focus");
          });
          
          //dropdown icon
          $fake_select.append("<span></span>");
        });
  
      }
      
      jQuery(document).off("click", ".fakeSelect");
      jQuery(document).off("click", ".dropdown span");
      
      //
      jQuery(document).on("click", ".fakeSelect", function(){
        $(".selectWrap").removeClass("open");		
        
        $(this).parent().toggleClass("open");
        
      });

      //set value when dropdown selected
      jQuery(document).on("click", ".dropdown span", function(){
        var value = $(this).text(),
            classes = (value.length > max_characters) ? "long" : "",
            id = $(this).data("id"),
            parent = $(this).parent(), //dropdown
            selectWrap = parent.parent();
        
        //set the fake value
        parent.siblings(".fakeSelect").addClass(classes).empty().html(value);
        parent.siblings(".fakeSelect").append("<span></span>");
        
        //set the real value to select box
        parent.siblings("select").val(id);

        //set the wrapper to open (for dropdown to open)
        selectWrap.toggleClass("open");
        
        if(!selectWrap.hasClass("sub")){
          
          //display sub categories
          $(".dropdown span").removeClass("display");
          
          if($.isNumeric(id)){

            //look for selected option and unhide
            $(".dropdown span[data-parent="+id+"]").addClass("display");
            
          }
              
        }
        
      });      
      
    },

    //setup custom radio buttons
    customRadioButtons: function(){

      if($(".custom_radio").length){

        $(".custom_radio").each(function (index, el) {
          var $this = $(this);


          if(!$this.next("label").length){
            var label = $this.data("label");
            var id = $this.attr("id");

            $this.after("<label for='"+id+"'><span></span>"+label+"</label>");

          }

        });

      }

    },
    
    //display a notification at the top of the page
    Message: function(text, type){

      var page = $("#page"),
          notify = $("#notify"),
          infoType = (type && type == "success") ? "success" : "error";
      
      if(text){
        
        page.addClass("notify");
        
        notify.addClass(infoType);
        notify.find("p").empty().append(text);
        
        //reset the notify popup
        setTimeout(function(){
          
          page.removeClass("notify");
          notify.removeClass(infoType);
          
        }, 3000);
        
      }
      
    },
    
    //return the hash value if set
    checkHash: function(){
      
      var hash = window.location.hash.replace("#","");
     
      return (hash) ? hash : false;
      
    },
  
     //function to check if a string contains numbers only
    isNumeric: function(n){
      return !isNaN(parseFloat(n)) && isFinite(n);
    },
    
    // validate email address
    isEmail: function(email){
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test(email);
    }
  
  });
  
})(jQuery);

var SITE = $.defaults();//site variables


