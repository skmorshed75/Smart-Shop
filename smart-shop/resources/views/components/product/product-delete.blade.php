<div class="modal" id="delete-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="mt-3 text-warning">Delete!!!</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input id="deleteID" class="d-none"/>
                <input id="deleteFilePath" class="d-none"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn shadow-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete(){
        let id = document.getElementById('deleteID').value;
        let deleteFilePath = document.getElementById('deleteFilePath').value;
        document.getElementById('delete-modal-close').click();
        showLoader();
        let result = await axios.post("/delete-product",{id:id, filePath:deleteFilePath});
        hideLoader();

        if(result.data === 1){
            successToast("Request is Successful!!!");
            await getList();
        } else {
            errorToast("Request is Failed");
        }
    }
</script>
