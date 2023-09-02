<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form" onsubmit="return false">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input autofocus type="text" class="form-control" id="productNameUpdate">
                                <label class="form-label">Product Price *</label>
                                <input  type="text" class="form-control" id="productPriceUpdate">
                                <label class="form-label">Unit *</label>
                                <input autofocus type="text" class="form-control" id="productUnitUpdate">
                                <label class="form-label">Product Image *</label>
                                <input autofocus type="text" class="form-control" id="productImageUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>
   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res=await axios.post("/product-by-id",{id:id})
        hideLoader();
        document.getElementById('productNameUpdate').value=res.data['name'];
        document.getElementById('productNameUpdate').focus();
    }

    async function Update() {

        let categoryName = document.getElementById('productNameUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (categoryName.length === 0) {
            errorToast("Product Name Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-product",{name:productName,id:updateID})
            hideLoader();

            if(res.status===200 && res.data===1){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast("Request fail !")
            }


        }



    }



</script>
