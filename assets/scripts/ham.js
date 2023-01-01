//ham button should show nav menu
$(".ham").click(function(){
    $("nav").toggleClass("hidden sm:flex flex col-span-10")
    $("main").toggleClass("col-span-12 col-span-2")
    $("main > *:not(#update, #delete_box, .blocks.hidden), main > *:first-child > *:not(.ham), main > .blocks.active-block").toggleClass("hidden")
    $("main > *:first-child").removeClass("hidden")
})