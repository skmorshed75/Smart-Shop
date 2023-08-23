<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <form action="" onsubmit="return false">
                        <h4>EMAIL ADDRESS</h4>
                        <br/>
                        <label>Your email address</label>
                        <input id="email" autofocus placeholder="User Email" class="form-control" type="email"/>
                        <br/>
                        <button onclick="VerifyEmail()"  class="btn w-100 float-end btn-primary">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function VerifyEmail(){
        let email = document.getElementById('email').value;

        if(email.length == 0 ){
            errorToast("Email is Required");
        } else {
            showLoader();
            let result = await axios.post("/send-otp",{email:email});
            hideLoader();
            if(result.status === 200){
                successToast(result.data['message']); 
                sessionStorage.setItem('email',email);
                setTimeout(function(){
                    window.location.href = "/verifyOtp";
                },1000);
            } else {
                errorToast("Email not Found");
            }
        }
    }
    /*
    async function VerifyEmail() {
        let email = document.getElementById('email').value;
        if(email.length === 0) {
            errorToast("Email is Required");
        }
        else {
            showLoader();
            let res = await axios.post("/send-otp",{email : email});
            hideLoader();
            if(res.status ===200){
                sessionStorage.setItem('email', email);
                window.location.href = "/verifyOtp";
            }
            else {
                errorToast("Email not Found");
            }
        }
    }
    */
</script>
