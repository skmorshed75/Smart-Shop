<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Product</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>Icon</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>

getList();


async function getList() {

    showLoader();
    let result=await axios.get("/list-product");
    hideLoader();

    let tableData = $('#tableData');
    let tableList = $('#tableList');

    tableData.DataTable().destroy();
    tableList.empty();

    result.data.forEach(function(item, index){
        let row = `<tr>
            <td><img alt = "image" class = "w-25" src = "/${item['img_url']}"></td>
            <td>${item['name']}</td>
            <td>${item['unit']}</td>
            <td>${item['price']}</td>
            <td>
                <button data-path = "${item['img_url']}" data-id = "${item['id']}" class = "btn editBtn btn-sm btn-outline-success">Edit</button>
                <button data-path = "${item['img_url']}" data-id = "${item['id']}" class = "btn deleteBtn btn-sm btn-outline-danger">Delete</button>

            </td>
        </tr>`;

        tableList.append(row);
    })

    $('.editBtn').on('click', async function(){
        let id = $(this).data('id');
        let filePath = $(this).data('path');
        //alert(id);
        await FillUpUpdateForm(id,filePath);
        $("#update-modal").modal('show');
    });

    $('.deleteBtn').on('click', function(){
        let id = $(this).data('id');
        let filePath = $(this).data('path');

        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
        $("#deleteFilePath").val(filePath);

    });

    tableData.DataTable({
        lengthMenu: [5,15,20,25,30,35,40,45,50],
        language: {
            paginate: {
                next: '&#8594;',// ->
                Previous: '&#8592;',// <-
            }
        }
    });
   
}
</script>

