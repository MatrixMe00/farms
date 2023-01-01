<div id="delete_box" class="hidden blocks fixed inset-0 bg-black/70 flex items-center justify-center">
    <div class="max-w-screen-sm lg:max-w-screen-md px-2 py-12 m-2 bg-white rounded w-full">
        <p class="text-center text-2xl mb-6">Are you sure you want to delete</p>
        <form class="flex items-center justify-center gap-2" name="delete-form">
            <input type="hidden" name="table" value="weight_table">
            <input type="hidden" name="row_id" value="">
            <button class="p-2 w-full max-w-[16rem] hover:shadow border border-green-600 hover:bg-green-600/20"
                type="submit" name="submit" value="delete_item"
            >Yes</button>
            <button class="p-2 w-full max-w-[16rem] hover:shadow border border-red-600 hover:bg-red-600/20"
                type="button" onclick="[$(this).parents('#delete_box').addClass('hidden'), $(this).parents('form')[0].reset()]"
            >No</button>
        </form>
    </div>
</div>