<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <form action="" onsubmit="return false">
                        <h4>ENTER OTP CODE</h4>
                        <br/>
                        <label>4 Digit Code Here</label>
                        <input id="otp" autofocus placeholder="OTP Code" class="form-control" type="text"/>
                        <br/>
                        <button onclick="VerifyOtp()"  class="btn w-100 float-end btn-primary">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function VerifyOtp(){
        let otp = document.getElementById('otp').value;
        if(otp.length !== 4){
            errorToast("Please enter 4 digit OTP");
        } else {
            showLoader();
            let result = await axios.post("/verify-otp",{
                email:sessionStorage.getItem('email'),
                otp:otp
            });
            hideLoader();
            if(result.status === 200 && result.data['status'] === 'success'){
                successToast(result.data['message']);
                sessionStorage.clear();
                setTimeout(function(){
                    window.location.href = "/resetPassword"
                }, 1000);
            } else {
                errorToast('OTP is mismatch');
            }
        }

    }

    /*
    async function VerifyOtp() {
        let code = document.getElementById('code').value;
        if(code.length!==4) {
            errorToast("4 digit verification code is required");
        }
        else {
            let res = await axios.post(
                "/otp-verify",{
                    otp:code,
                    email:sessionStorage.getItem('email')
            });
            if(res.status === 200){
                sessionStorage.clear();
                window.location.href = "/resetPassword";
            }
            else {
                errorToast("Something went Wrong!!!");
            }
        }
    }
    */
</script>
