<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <form action="" onsubmit="return false">
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <label>Email Address</label>
                                    <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>First Name</label>
                                    <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Last Name</label>
                                    <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Mobile Number</label>
                                    <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Password</label>
                                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                                </div>
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button onclick="updateProfile()" class="btn mt-3 w-100  btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    getProfileDetails(); //SHOW PROFILE DETAILS THROUGH FORM
    async function getProfileDetails(){
        showLoader();
        let result = await axios.get("/user-profile");
        hideLoader();

        if(result.status === 200 && result.data['status'] === 'success'){
            let data = result.data['data'];
            document.getElementById('email').value = data.email;
            document.getElementById('firstName').value = data['firstName']; //Alternative of previous line
            document.getElementById('lastName').value = data['lastName'];
            document.getElementById('mobile').value = data['mobile'];
            document.getElementById('password').value = data['password'];
        }
        else {
            errorToast(result.data['message']);
        }
    }

    //WHILE CLICK IN UPDATE PROFILE BUTTON
    async function updateProfile(){
        let email = document.getElementById('email').value;
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;
        let password = document.getElementById('password').value

        if(firstName.length === 0){
            errorToast("First Name is Required");
        } else if(lastName.length ===0){
            errorToast("Last Name is Required");
        } else if(mobile.length === 0){
            errorToast("Mobile Number is required");
        } else if(password.length === 0){
            errorToast("Password is Required");
        } else {
            showLoader();
            let result = await axios.post("/user-update",{
                firstName:firstName,
                lastName:lastName,
                mobile:mobile,
                password:password
            });
            hideLoader();

            if(result.status === 200 && result.data['status'] === 'success'){
                successToast("Profile Updated Successfully!!!");
                await getProfileDetails; //Refresh Form with updated data
                /*setTimeout(function(){
                    window.location.ref = "/userLogin"
                }, 1000);
                */
            }
        }
    }
/*
    profileDetails();
    async function profileDetails(){
        let result = await axios.get("/");
    }

    async function profileDetailssss(){
        showLoader();
        let res = await axios.get("/user-profile-details");
        hideLoader();
        if(res.status===200 && res.data['status'] === 'success'){
            let data = res.data['data'];
            document.getElementById('email').value =data['email'];
            document.getElementById('firstName').value = data['firstName'];
            document.getElementById('lastName').value = data['lastName'];
            document.getElementById('mobile').value = data['mobile'];
            document.getElementById('password').value = data['password'];
        }
        else {
            errorToast(res.data['message']);
        }
    }

    async function onUpdate222() {
        //let email = document.getElementById('email').value;
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;
        let password = document.getElementById('password').value;
        if(firstName.length===0) {
            errorToast("First Name Required");
        }
        else if(mobile.length===0) {
            errorToast("Mobile Required");
        }
        else if(password.length ===0) {
            errorToast("Password Required");
        }
        else {
            showLoader();
            let res = await axios.post(
                "/user-update",
                {
                    firstName:firstName,
                    lastName:lastName,
                    //email:email,
                    mobile:mobile,
                    password:password
                }
            )   
            hideLoader();
            if(res.status === 200) {
                successToast("User Profile is Updated");
                //window.location.href="/userLogin"; 
                await profileDetails();
            }
            else {
                errorToast("User Profile Update Failed");
            }
        }
    }
*/

</script>
