//open the update view when an animal is clicked on
$(".animal").click(function(){
    //remove clicked from all animal tags and add to this one
    $(".animal").removeClass("clicked");
    $(this).addClass("clicked");
    
    //get animal type
    animal_type = $(this).attr("data-animal-type");
    row_id = $(this).attr("data-row-id");

    //grab animal data
    $("#update").find("#form-animal-id").html($(this).find("span[data-id]").html())
    $("#update").find("input#animal_id").val($(this).find("span[data-id]").html())
    $("#update").find("input#row_id").val(row_id)
    $("#update").find("select#animal_type").val(animal_type).change();
    $("#update").find("input[name=record_date]").val($(this).find("span[data-date]").attr("data-date"))
    $("#update").find("input#animal_breed").val($(this).find("span[data-breed]").attr("data-breed"))
    $("#update").find("select#animal_sex").val($(this).find("span[data-sex]").attr("data-sex"))
    $("#update").find("input[name=animal_weight]").val($(this).find("span[data-weight]").attr("data-weight"))
    $("#update").find("textarea#remarks").val($(this).find("span[data-remark]").html())
    
    if(animal_type == "pig"){
        $("#update").find("input[name=wean_weight]").val($(this).find("span[data-w-weight]").attr("data-w-weight"))
    }

    //finally open the update view
    $("#update").removeClass("hidden")
})