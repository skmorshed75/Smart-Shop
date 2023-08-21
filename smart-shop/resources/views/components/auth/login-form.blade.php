<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <form action="" onsubmit="return false">
                        <h4>SIGN IN</h4>
                        <br/>
                        <input id="email" placeholder="User Email" class="form-control" type="email"/>
                        <br/>
                        <input id="password" placeholder="User Password" class="form-control" type="password"/>
                        <br/>
                        <button onclick="SubmitLogin()" class="btn w-100 btn-primary">Next</button>
                        <hr/>
                        <div class="float-end mt-3">
                            <span>
                                <a class="text-center ms-3 h6" href="{{url('/userRegistration')}}">Sign Up </a>
                                <span class="ms-1">|</span>
                                <a class="text-center ms-3 h6" href="{{url('/sendOtp')}}">Forget Password</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

async function SubmitLogin(){
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if(email.length === 0) {
        errorToast('Email is Required');
    } else if(password.length === 0){
        errorToast('Password is Required');
    } else {
        showLoader();
        let result = await axios.post(
            "/user-login",
        {
            email:email,
            password:password
        });
        hideLoader();

        if (result.status === 200 && result.data['status'] ==='success') {
            window.location.href = "/dashboard"; //after successful login
        } else {
            //alert(result.status);
            //errorToast("Invalid User ID or Password");
            errorToast(result.data['message']);
            //errorToast(result.data['message']);
        }         
    }
}
    /*
    async function SubmitLogin(){
        let email = document.getElementById('email').value;
        let pass = document.getElementById('pass').value;
        if(email.length === 0){
            errorToast('Email Required');
        } else if(pass.length===0) {
            errorToast('Password is required');
        } else {
            showLoader();
            let res = await axios.post(
                "/user-login",
                {
                    email:email,
                    password:pass,
                }
            )
            hideLoader();
            if(res.status ===200){
                successToast("Login Successful");
                window.location.href = "/dashboard";
            } else {
                errorToast("Invalid User ID or Password");
            }
        }

    }
    */
</script>
