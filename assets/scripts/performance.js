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
    $("#update").find("input[name=animal_id]").val($(this).find("span[data-id]").html())
    $("#update").find("input[name=row_id]").val(row_id)
    $("#update").find("select[name=animal_type]").val(animal_type).change();
    $("#update").find("select[name=animal_sex]").val($(this).find("span[data-sex]").attr("data-sex"));
    $("#update").find("input[name=animal_breed]").val($(this).find("span[data-breed]").attr("data-breed"))
    $("#update").find("input[name=suck_date]").val($(this).find("span[data-suck-date]").attr("data-suck-date"))
    $("#update").find("input[name=sire_id]").val($(this).find("span[data-sire-id]").html())
    $("#update").find("input[name=birth_litter_weight]").val($(this).find("span[data-bl-weight]").attr("data-bl-weight"))
    $("#update").find("textarea[name=remarks]").val($(this).find("span[data-remark]").html())
    
    if(animal_type != "pig"){
        $("#update").find("input#birth_type").val($(this).find("span[data-birth-type]").html())
    }else{
        $("#update").find("input[name=litter_size]").val($(this).find("span[data-litter-size]").attr("data-litter-size"))
        //inserting the number of male and female offsprings
        const offspring = $(this).find("span[data-offspring]").attr("data-offspring")
        $("#update").find("input[name=male_pigs]").val(offspring.split(",")[0])
        $("#update").find("input[name=female_pigs]").val(offspring.split(",")[1])
    }

    //finally open the update view
    $("#update").removeClass("hidden")
})