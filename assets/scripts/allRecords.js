//keys used for searching
let search_elements = {};

//variable to reload page if ther is a change
let modified = false;

//let the forms be brought to default
$(document).ready(function(){
    $("select[name=animal_type]").change();

    search_elements = getKeys();
})

//search functionality
$("input[name=search]").keyup(function(){
    if($(this).val() == ""){
        $(".animal").removeClass("hidden");
    }else{
        $(".animal").addClass("hidden");
        let search = $(this).val();
        if(search.includes(":")){
            let search_key = search.split(":")[0];
            let search_value = search.split(":")[1];

            if(search_elements[search_key] == null){
                $("#wrong_key").html("Your key '" + search_key +"' is invalid for this search").removeClass("hidden");
            }else if(search_value != null && search_value != ""){
                $(".animal").each(function(){
                    hasElement = $(this).find("span[" + search_elements[search_key] + "]").length;
                    if($.isNumeric(search_value) && hasElement > 0){
                        child = $(this).find("span[" + search_elements[search_key] + "]").attr(search_elements[search_key]);
                        if(parseInt(child) == parseInt(search_value)){
                            $(this).removeClass("hidden");
                        }else if(child.includes(search_value)){
                            $(this).removeClass("hidden")
                        }
                    }else if(hasElement > 0){
                        attr = $(this).find("span[" + search_elements[search_key] + "]").attr(search_elements[search_key]);
                        child = $(this).find("span[" + search_elements[search_key] + "]").html()
                        if(!$.isNumeric(child) && child.toLowerCase().includes(search_value.toLowerCase())){
                            $(this).removeClass("hidden");
                        }else if(attr.includes(search_value)){
                            $(this).removeClass("hidden");
                        }
                    }
                })
            }  
        }else{
            $("#wrong_key").html("").addClass("hidden")
        }
    }  
})

//show instructions when search is on focus
$("input[name=search]").focus(function(){
    $(this).siblings(".instruction").removeClass("hidden");
})

$("input[name=search]").blur(function(){
    $(this).siblings(".instruction").addClass("hidden");
})

$("select[name=animal_type]").change(function(){
    value = $(this).val();

    //grid containers and labels
    $("#update form, #add form").find(".grid.cow, .grid.sheep, .grid.goat, .grid.pig").addClass("hidden").children("input, select").prop("disabled", true);
    $("#update form, #add form").find("label.cow, label.sheep, label.goat, label.pig").addClass("hidden");

    //search through a grid container
    if($(this).parent().siblings(".grid").hasClass(value)){
        $(this).parent().siblings(".grid." + value).removeClass("hidden").children("input, select").prop("disabled", false);
    }

    //search through labels
    if($(this).parents("#update form, #add form").find("label").hasClass(value)){
        $(this).parents("#update form, #add form").find("label." + value).removeClass("hidden");
    }
})

$("button[name=resetForm]").click(function(){
    $(this).parents("form")[0].reset()
    $(this).parents("#add").find("select[name=animal_type]").change()
})

//making the tag change event
$("#tabs > .tab").click(function(){
    //check if its active
    if(!$(this).hasClass("bg-sky-600")){
        //change color
        $("#tabs > .tab").removeClass("bg-sky-600 text-white border-sky-600 hover:bg-sky-700").addClass("hover:bg-sky-600 hover:text-white")
        $(this).addClass("bg-sky-600 text-white border-sky-600 hover:bg-sky-700").removeClass("hover:bg-sky-600 hover:text-white")

        //provide view
        view = $(this).attr("data-block-id")
        $(".blocks").addClass("hidden").removeClass("active-block")
        $("#" + view).removeClass("hidden").addClass("active-block")
    }
})

$("form").submit(function(e){
    e.preventDefault()
    Form = $(this);
    form_name = $(Form).attr("name");

    form = $(Form).serialize();
    
    if(!form.includes("submit=")){
        form += "&submit=" + $(Form).find("button[name=submit]").attr("value");
    }

    let loading = "", original = "";
    let message_box = null;

    //button texts
    switch (form_name) {
        case "update-form":
            loading = "Updating...";
            original = "Update Performance";
            break;
        case "add-form":
            loading = "Creating...";
            original = "Add Performance";
            break;
        case "delete-form":
            loading = "Deleting..."
            original = "Yes"
            break;
        default:
            loading = "Loading...";
            original = $(Form).find("button[name=submit]").html();
            break;
    }

    if(form_name == "delete-form"){
        message_box = $("form[name=update-form]").find(".message-box");
    }else{
        message_box = $(Form).find(".message-box");
    }

    let message_span = $(message_box).children("span");

    //submit the form
    $.ajax({
        url: "submit.php",
        data: form,
        type: "POST",
        dataType: "JSON",
        beforeSend: function(){
            //disable all input fields
            switch (form_name) {
                case "update-form":
                case "add-form":
                    $(Form).find("input, select").prop("disabled", true);
                    $(Form).find("button[name=submit]").html(loading).prop("disabled", true);
                    break;
                case "delete-form":
                    $(message_box).removeClass("hidden");
                    $(message_span).html(loading);
                    $("#delete_box").addClass("hidden");
                    break;
            }
        },
        success: function(data) {
            data = JSON.parse(JSON.stringify(data));
            message = ""; addClass = "";
            setTimeout(function(){
                if(!data["error"]){
                    message = data["message"];
                    //enable inputs
                    switch (form_name) {
                        case "update-form":
                            $(Form).find("input, select").prop("disabled", false);
                            modified = true;
                            break;
                        case "add-form":
                            $(Form).find("input, select").prop("disabled", false);
                            $(Form).find("button[name=resetForm]").click();
                            modified = true;
                            break;
                    }
                    $(Form).find("button[name=submit]").html(original).prop("disabled", false);
                }else{
                    message = data["message"];
                    addClass = "bg-red-500 text-white";

                    //enable inputs
                    $(Form).find("input, select").prop("disabled", false);
                    $(Form).find("button[name=submit]").html(original).prop("disabled", false);
                }

                //parse message into message box
                $(message_box).addClass(addClass);
                $(message_box).removeClass("hidden");
                $(message_span).html(message);

                setTimeout(function(){
                    //remove message in message box
                    $(message_box).addClass("hidden");
                    $(message_box).removeClass(addClass);
                    $(message_span).html(message);

                    if(form_name == "delete-form"){
                        //remove specified animal element and close the update form
                        $(".animal.clicked").remove();
                        $("form[name=update-form]").find("button[name=closeForm]").click();
                    }                                    
                }, 5000)
            }, 1500)
        },
        error: function(message){
            alert(JSON.stringify(message));
            //enable inputs
            $(Form).find("input, select").prop("disabled", false);
            $(Form).find("button[name=submit]").html(original).prop("disabled", false);
        }
    })
})

//delete an animal
$("#delete-animal").click(function(){
    $("#delete_box").removeClass("hidden");

    //parse row id into delete form
    row_id = $("#update").find("input#row_id").val();
    $("#delete_box").find("input[name=row_id]").val(row_id)
})

//reload the page if there has been modifications
$("#update .back, #update button[name=closeForm], .tab[data-block-id=view]").click(function(){
    if(modified){
        location.reload();
    }
})