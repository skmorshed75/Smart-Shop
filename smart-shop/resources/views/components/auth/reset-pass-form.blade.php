<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100  btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPass() {
        let password = document.getElementById('password').value;
        let cpassword = document.getElementById('cpassword').value;
        if(password.length === 0){
            errorToast('Password is required');
        }
        else if(cpassword.length ===0) {
            errorToast("Confirm password is required");
        }
        else if(password !== cpassword){
            errorToast("New password & confirm password should be same");
        }
        else {
            let res = await axios.post("/reset-password",{password:password});
            if(res.status ===200){
                window.location.href = "/userLogin"
            }
            else {
                errorToast("Request Fail!");
            }
        }
    }
</script>
