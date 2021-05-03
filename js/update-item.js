$( document ).ready(function() {
   
    //Montre ou cache les éléments
    $("#types").change(function() {
        showElementsOnChange();
    });
    showElementsOnChange();
    
    
    $("#updateForm").validate({
        //errorClass: 'errorField',
        //onkeyup: true,
        errorElement: 'span',
        rules: {
            nom: {
                required: true
            },
            price: {
                required: true
            },
            quantite: {
                required: true
            },
            efficacite: {
                required: function(element) { return $('#types').val() == 'AE'; },
                number: true
            },
            genres: {
                required: function(element) { return $('#types').val() == 'AE'; }
            },
            description: {
                required: function(element) { return $('#types').val() == 'AE'; },
                maxlength: 280
            },

            matieres: {
                required: function(element) { return $('#types').val() == 'AM'; }
            },
            poids: {
                required: function(element) { return $('#types').val() == 'AM'; },
                number: true
            },
            taille: {
                required: function(element) { return $('#types').val() == 'AM'; }
            },

            effet: {
                required: function(element) { return $('#types').val() == 'PO'; }
            },
            duree: {
                required: function(element) { return $('#types').val() == 'PO'; },
                number: true
            },

            ressourceDescription: {
                required: function(element) { return $('#types').val() == 'RS'; },
                maxlength: 280
            }
        }
      });

    function showElementsOnChange()
    {
        var el = $("#types");
        $(".addItemInfosContainer").removeClass("hidden").hide();
        if(el.val()=="AE")
            $("#armeInfos").show();
        else if(el.val()=="AM")
            $("#armureInfos").show();  
        else if(el.val()=="PO")
            $("#potionInfos").show();   
        else if(el.val()=="RS")
            $("#RS_Informations").show();

    }

    /*function updateElementClick()
    {
         
    }
    function validateElement(el, condition)
    {
        if(condition)
            el.addClass('errorField');
        else
            el.removeClass('errorField');
    }*/
    
});