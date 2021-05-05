$( document ).ready(function() {
   
    //Montre ou cache les éléments
    $("#types").change(function() {
        showElementsOnChange();
    });
    showElementsOnChange();
    
    $("#updateForm").change(function() {
        $("#updateForm").valid();
    });

    $("#updateForm").validate({
       
        errorElement: 'span',
        rules: {
            nom: {
                required: true
            },
            price: {
                required: true,
                number: true,
                min: 0
            },
            quantite: {
                required: true,
                number: true,
                min: 0
            },
            efficacite: {
                required: function(element) { return $('#types').val() == 'AE'; },
                number: true,
                min: 0
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
                number: true,
                min: 0
            },
            taille: {
                required: function(element) { return $('#types').val() == 'AM'; }
            },

            effet: {
                required: function(element) { return $('#types').val() == 'PO'; }
            },
            duree: {
                required: function(element) { return $('#types').val() == 'PO'; },
                number: true,
                min: 0
            },

            ressourceDescription: {
                required: function(element) { return $('#types').val() == 'RS'; },
                maxlength: 280
            },
            picture: {
                extension: "jpg|jpeg|png"
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
});

function ChangeImagePreview() {
    let imagePreview = document.getElementById("UploadedImage");
    let input = document.getElementById("picture");

    if (input.files[0] !== undefined) {
        let fileName = input.files[0].name;
        let ext = fileName.split('.').pop().toLowerCase();

        if ((ext !== "png") &&
            (ext !== "jpeg") &&
            (ext !== "jpg") &&
            (ext !== "bmp") &&
            (ext !== "gif")) {
            alert("Ce n'est pas un fichier d'image de format reconnu. Sélectionnez un autre fichier.");
        } else {
            let fReader = new FileReader();
            fReader.readAsDataURL(input.files[0]);
            fReader.onloadend = function (event) {
                imagePreview.src = event.target.result;
            }
        }
    } else {
        imagePreview.src = "../icons/DefaultIcon.png";
    }
}